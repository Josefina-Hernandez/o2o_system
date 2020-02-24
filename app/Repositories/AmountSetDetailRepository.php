<?php
namespace App\Repositories;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Estimate\TAmountSetDetail;

class AmountSetDetailRepository {

	public
		$connect_db2,
		$tAmountSetDetailModel;

    public function __construct() {
    	$this->connect_db2 = DB::connection(config('settings.connect_db2'));
    	$this->tAmountSetDetailModel = new TAmountSetDetail();
    }

    /**
     * Insert data to t_amount_set_detail when create new shop
     * @param  [integer] $m_shop_management_id
     */
	public function insert_data_default($m_shop_management_id) {

		$sql = "
			INSERT INTO t_amount_set_detail(
				m_shop_management_id,
				m_master_define_id,
				amount,
				amount_discount,
				created_at,
				updated_at
			)
			SELECT
				:m_shop_management_id,
				m_master_define_id,
				0, -- default amount
				0, -- default amount_discount
				:created_at,
				:updated_at
			FROM m_master_define
			WHERE
				del_flg = 0 AND
				data_type = 'AMOUNT_PRICE_SET'
			ORDER BY sort_flg
		";

		$this->connect_db2
			->select($sql, [
			'm_shop_management_id' => $m_shop_management_id,
			'created_at' => \Carbon\Carbon::now(),
			'updated_at' => \Carbon\Carbon::now()
		]);
	}

	/**
	 * Check and insert data to t_amount_set_detail for shop_management_id if not exits
	 * @param  [integer] $shop_id
	 */
	public function insert_data_old_shop($shop_id) {
		$sql = "
			INSERT INTO t_amount_set_detail(
				m_shop_management_id,
				m_master_define_id,
				amount,
				amount_discount,
				created_at,
				updated_at
			)
			SELECT
				d.m_shop_management_id,
				m_master_define_id,
				CASE
					WHEN md.sort_flg = 1
					THEN d.amount
					ELSE 0
					END
				,
				CASE
					WHEN md.sort_flg = 1
					THEN CEILING((COALESCE(d.discount,0) * d.amount / 100))
					ELSE 0
					END
				,
				NOW(),
				NOW()
			FROM m_master_define md
			JOIN (
				SELECT * FROM
				(
					SELECT
						shop_m.m_shop_management_id,
						shop_m.amount,
						COALESCE(pd.discount,0) as discount,
						CASE
							WHEN ta.m_shop_management_id IS NULL
							THEN 1
							ELSE 0
							END
						as exits_column
					FROM
						m_shop_management AS shop_m
					INNER JOIN m_shop_category AS shop_cate ON shop_cate.m_shop_category_id = shop_m.m_shop_category_id
						AND shop_cate.shop_id = :shop_id
						AND shop_cate.del_flg = 0
					INNER JOIN m_product ON m_product.m_product_id = shop_cate.m_product_id
						AND m_product.del_flg = 0
					INNER JOIN m_category ON m_category.m_category_id = m_product.m_category_id
						AND m_category.del_flg = 0
					LEFT JOIN (
						SELECT DISTINCT m_shop_management_id FROM t_amount_set_detail
					) as ta ON ta.m_shop_management_id = shop_m.m_shop_management_id
					LEFT JOIN m_product_discount pd ON pd.m_shop_management_id = shop_m.m_shop_management_id AND pd.del_flg = 0
					WHERE
						shop_m.del_flg = 0
				) tmp
			) d
			WHERE
				del_flg = 0 AND
				data_type = 'AMOUNT_PRICE_SET' AND
				d.exits_column = 1
			ORDER BY d.m_shop_management_id
		";

		$this->connect_db2
			->select($sql, [
			'shop_id' => $shop_id
		]);
	}

	public function update_amount_discount($data, $args_quantity_define, $m_shop_management_id) {
		$quantity = isset($data['quantity']) ? $data['quantity'] : 0;
		$data_amount = $this->tAmountSetDetailModel->get_data_by_shop_manamagement_id($m_shop_management_id);
		if(!$data_amount->isEmpty()) {
			$data_update = [];
			foreach($data_amount as $_data) {
				$data_update = [
					'amount_discount_final_1' => $this->_calc_amount_discount_final_1($_data['amount'], $_data['amount_discount_increment_1'], $_data['m_master_define_id'], $quantity, $args_quantity_define),
					'upd_datetime' => Carbon::now()
				];
				$this->tAmountSetDetailModel->where('m_shop_management_id', $_data['m_shop_management_id'])->where('m_master_define_id', $_data['m_master_define_id'])->update($data_update);
			}
		}
	}

	public function update_amount($data, $data_discount, $args_quantity_define) {

    	$result_update = [];
    	$args_shop_management_id = [];
    	$args_discount = [];
    	$args_quantity = [];
    	$amount_discount_increment_1 = 0;
		$quantity = 0;
    	$args_shop_management_id = array_column($data_discount, 'm_shop_management_id');
		$main_amount = (isset($data['main_amount']) && $data['main_amount'] != NULL) ? $data['main_amount'] : 0;

		foreach($data_discount as $_data) {
			$args_discount[$_data['m_shop_management_id']] = $_data['discount'];
			$args_quantity[$_data['m_shop_management_id']] = $_data['quantity'];
		}

		$_updated_flg = 0;
		if($data['handling_flg'] != $data['old_handling_flg'] || $data['old_rate'] != $data['rate'] || $data['old_main_amount'] != $data['main_amount']) {
			$_updated_flg = 1;
		}

		if(count($data_discount)>0 && in_array($data['m_shop_management_id'], $args_shop_management_id)){ //Has discount
			$quantity = $args_quantity[$data['m_shop_management_id']];
		}

		foreach($data['amount'] as $_data){

			if($_data['amount'] == NULL) {
				$_data['amount'] = 0;
			}

			if($_data['amount'] != $_data['old-amount']){
				$_updated_flg = 1;
			}

			$amount_discount_increment_1 = $this->_calc_amount_discount_increment_1($amount_discount_increment_1, $_data['amount']);
			$amount_discount_final_1 = $this->_calc_amount_discount_final_1($main_amount, $amount_discount_increment_1, $_data['m_master_define_id'], $quantity, $args_quantity_define);

			$data_update = [
				'amount' => $main_amount,
				'amount_discount_1' => $_data['amount'],
				'amount_discount_increment_1' => $amount_discount_increment_1,
				'amount_discount_final_1' => $amount_discount_final_1
			];

			if(isset($data['m_shop_management_id_2_3'])) {
				$m_shop_management_id_2_3 = json_decode($data['m_shop_management_id_2_3'], true);
				$this->tAmountSetDetailModel->update_product_2_3($m_shop_management_id_2_3, $_data['m_master_define_id'], $data_update);
			} else {
				$this->tAmountSetDetailModel->update_product($_data['t_amount_set_detail_id'], $data_update);
    		}
    	}

    	if($_updated_flg == 1) {
    		$result_update = $data;
    	}

    	if(count($result_update)>0) {
    		return $result_update;
    	}

    	return null;
	}

	/* Comment by BP_MMEN-23 NEW SETTING PRICE: spec2
	public function update_amount_discount($data, $data_amount, $args_quantity_define, $m_shop_management_id, $is_m_product_id_2_3 = false, $delete = false) {
		$amount_set1 = $this->_get_amount_set1($data_amount[0]);
		$amount_increment      = 0;
		$total_amount_difference = 0;
		$total_amount_discount = 0;

		foreach ($data_amount  as $_data) {

			if($delete === false) {
    			$amount_discount = $this->_calc_amount_discount($_data['amount'], $data['discount']);
    			$amount_increment = $this->_calc_amount_increment($amount_increment, $_data['amount']);
    			$amount_difference = $this->_calc_amount_difference($amount_set1, $_data['amount']);
    			$total_amount_difference = $this->_calc_total_amount_difference($total_amount_difference, $amount_difference);
    			$total_amount_discount = $this->_calc_total_amount_discount($total_amount_discount, $amount_discount);
    			$quantity = $data['quantity'];
    			$amount_discount_final = $this->_calc_amount_discount_final($_data['m_master_define_id'], $quantity, $args_quantity_define, $total_amount_difference, $total_amount_discount);
    			$data_update = [
					'amount' => $_data['amount'],
					'amount_increment' => $amount_increment,
					'amount_difference' => $amount_difference,
					'amount_discount' => $amount_discount,
					'amount_discount_final' => $amount_discount_final
				];
    		} else {
    			$amount_discount = 0;
    			$amount_difference = $this->_calc_amount_difference($amount_set1, $_data['amount']);
	    		$total_amount_difference = $this->_calc_total_amount_difference($total_amount_difference, $amount_difference);
	    		$amount_discount_final = $total_amount_difference;
    			$data_update = [
					'amount_discount' => $amount_discount,
					'amount_difference' => $amount_difference,
					'amount_discount_final' => $amount_discount_final
				];
    		}

	    	if($is_m_product_id_2_3) {
	    		$this->tAmountSetDetailModel->update_product_2_3($m_shop_management_id, $_data['m_master_define_id'], $data_update);
	    	} else {
	    		$this->tAmountSetDetailModel->update_product($_data['t_amount_set_detail_id'], $data_update);
	    	}
    	}
	}

	public function update_amount($data, $data_discount, $args_quantity_define) {
    	$result_update = [];
    	$args_discount = [];
    	$args_quantity = [];
    	$args_shop_management_id = [];
    	$amount_increment      = 0;
		$total_amount_difference = 0;
		$total_amount_discount = 0;
		$amount_set1 = $this->_get_amount_set1($data['amount'][0]);

		$args_shop_management_id = array_column($data_discount, 'm_shop_management_id');
		foreach($data_discount as $_data) {
			$args_discount[$_data['m_shop_management_id']] = $_data['discount'];
			$args_quantity[$_data['m_shop_management_id']] = $_data['quantity'];
		}

		$_updated_flg = 0;
		if($data['handling_flg'] != $data['old_handling_flg'] || $data['old_rate'] != $data['rate']) {
			$_updated_flg = 1;
		}

    	if(count($data_discount)>0 && in_array($data['m_shop_management_id'], $args_shop_management_id)){ //Has discount
    		foreach($data['amount'] as $_data){

    			if($_data['amount'] == NULL) {
    				$_data['amount'] = 0;
    			}

    			if($_data['amount'] != $_data['old-amount']){
    				$_updated_flg = 1;
    			}

    			$amount_discount = $this->_calc_amount_discount($_data['amount'], $args_discount[$data['m_shop_management_id']]);
    			$amount_increment = $this->_calc_amount_increment($amount_increment, $_data['amount']);
    			$amount_difference = $this->_calc_amount_difference($amount_set1, $_data['amount']);
    			$total_amount_difference = $this->_calc_total_amount_difference($total_amount_difference, $amount_difference);
    			$total_amount_discount = $this->_calc_total_amount_discount($total_amount_discount, $amount_discount);
    			$quantity = $args_quantity[$data['m_shop_management_id']];
    			$amount_discount_final = $this->_calc_amount_discount_final($_data['m_master_define_id'], $quantity, $args_quantity_define, $total_amount_difference, $total_amount_discount);

    			$data_update = [
					'amount' => $_data['amount'],
					'amount_increment' => $amount_increment,
					'amount_difference' => $amount_difference,
					'amount_discount' => $amount_discount,
					'amount_discount_final' => $amount_discount_final
				];

				if(isset($data['m_shop_management_id_2_3'])) {
					$m_shop_management_id_2_3 = json_decode($data['m_shop_management_id_2_3'], true);
					$this->tAmountSetDetailModel->update_product_2_3($m_shop_management_id_2_3, $_data['m_master_define_id'], $data_update);
				} else {
					$this->tAmountSetDetailModel->update_product($_data['t_amount_set_detail_id'], $data_update);
	    		}
	    	}

	    	if($_updated_flg == 1) {
	    		$result_update = $data;
	    	}

    	} else { //No discount
    		foreach($data['amount'] as $_data){

    			if($_data['amount'] == NULL) {
    				$_data['amount'] = 0;
    			}

    			if($_data['amount'] != $_data['old-amount']){
    				$_updated_flg = 1;
    			}

    			$amount_increment = $this->_calc_amount_increment($amount_increment, $_data['amount']);

    			$data_update = [
					'amount' => $_data['amount'],
					'amount_increment' => $amount_increment,
					'amount_difference' => $this->_calc_amount_difference($amount_set1, $_data['amount']),
					'amount_discount_final' => 0
				];

    			if(isset($data['m_shop_management_id_2_3'])) {
					$m_shop_management_id_2_3 = json_decode($data['m_shop_management_id_2_3'], true);
					$this->tAmountSetDetailModel->update_product_2_3($m_shop_management_id_2_3, $_data['m_master_define_id'], $data_update);
				} else {
					$this->tAmountSetDetailModel->update_product($_data['t_amount_set_detail_id'], $data_update);
				}
    		}

    		if($_updated_flg == 1) {
	    		$result_update = $data;
	    	}
    	}

    	if(count($result_update)>0) {
    		return $result_update;
    	}

    	return null;
	}

	public function _get_amount_set1($data) {
		$amount_set1 = 0;

		if( $data['amount'] != NULL ) {
			$amount_set1 = $data['amount'];
		}

		return $amount_set1;
	}

	public function _calc_amount_increment($amount, $amount_increment) {
		$amount_increment = $amount_increment + $amount;
		return $amount_increment;
	}

	public function _calc_amount_discount($amount, $discount) {
		return ceil($amount * ( $discount / 100 ));;
	}

	public function _calc_amount_difference($amount_set1, $amount) {
		return $amount_set1 - $amount;
	}

	public function _calc_total_amount_difference($total_amount_difference, $amount_difference) {
		return $total_amount_difference + $amount_difference;
	}

	public function _calc_total_amount_discount($total_amount_discount, $amount_discount) {
		return $total_amount_discount + $amount_discount;
	}

	public function _calc_amount_discount_final($m_master_define_id, $quantity, $args_quantity_define, $total_amount_difference=0, $total_amount_discount=0) {
		$quantity_set = $args_quantity_define[$m_master_define_id];
		if( $quantity_set >= $quantity ) {
			return $total_amount_difference + $total_amount_discount;
		} else {
			return $total_amount_difference;
		}
	}
	*/

	public function get_data_quantity_master_define (){
		$return = [];
		$data_query = $this->connect_db2->table('m_master_define')
            ->where('del_flg', 0)
            ->where('data_type', 'AMOUNT_PRICE_SET')
            ->select('value', 'm_master_define_id')
            ->orderBy('sort_flg')
            ->get();
        if(count($data_query)>0){
        	foreach($data_query as $index => $_data) {
        		$return[$_data->m_master_define_id] = str_replace('枚目', '', $_data->value);
        	}
        }
		return $return;
	}

	public function _calc_amount_discount_increment_1($amount_discount_increment_1, $amount_discount_1) {
		return $amount_discount_increment_1 + $amount_discount_1;
	}

	public function _calc_amount_discount_final_1($main_amount, $amount_discount_increment_1, $m_master_define_id, $quantity, $args_quantity_define) {
		$quantity_set = $args_quantity_define[$m_master_define_id];
		if( $quantity_set >= $quantity && $quantity >= 1 ) {
			return $quantity_set * $main_amount;
		} else {
			return $amount_discount_increment_1;
		}
	}
}