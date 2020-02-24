<?php
namespace App\Repositories;
use DB;
use Session;
use Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use function Couchbase\defaultDecoder;
use PDF;

class BaseRepository {
	const SS_DATA = 'data';
	const SS_CART_WINDOW = 'cart_window';
	const SS_CART_DOOR = 'cart_door';
	const SS_CART_CONFIG_WINDOW = 'cart_config_window';

	/**
	 * [getCartData]
	 * @param  string $type category_type_code
	 * @param  string $key
	 * @return [mix]
	 */
	public function getCartData($type, $shop_id, $step, $key=''){
		$data = [];
		if(!Session::has(BaseRepository::SS_DATA)){
			return -1;
		}

		$data = Session::get(BaseRepository::SS_DATA);
		if($key == ''){
			if(isset($data[$type][$shop_id])){
				$return = [];
				foreach($data[$type][$shop_id] as $k => $v){
					if($k > $step){
						unset($data[$type][$shop_id][$k]);
						continue;
					}
					foreach($v as $key => $value){
						$return[$key] = $value;
					}
				}
			}
			Session::put(BaseRepository::SS_DATA, $data);
			if (isset($return)){
				return $return;
			}else {
				return -1;
			}
		}else{
			if(isset($data[$type][$shop_id][$step][$key])){
				return $data[$type][$shop_id][$step][$key];
			}else{
				return -1;
			}
		}

		return $data[$type][$shop_id][$step];
	}

	public function saveData($pref_code,$standard_shop_code, $step){
		$shop = $this->get_shop_id($pref_code, $standard_shop_code);
		$shop_id = $shop['id'];
		$type = \Request::route()->getName();
		$step = str_replace('step', '', $step);
    	if ( \Request::isMethod('post')) {
    		$data  = array();
	    	$posts = \Request::post();
	    	parse_str($posts['data'], $data);
	    	foreach($data as $key => $value){
	    		if(Session::has(BaseRepository::SS_DATA)){
					$cart = Session::get(BaseRepository::SS_DATA);
					if($value != ''){
						$cart[$type][$shop_id][$step][$key] = $value;
					}
					Session::put(BaseRepository::SS_DATA, $cart);
				}else{
					$cart[$type][$shop_id][$step][$key] = $value;
					Session::put(BaseRepository::SS_DATA, $cart);
				}
	    	}
	    }
    }

    public function add_to_cart($request){
		$category = $request->category;
		$shop_id = $request->shop_id;
		if ($category == 'door'){
			$cart = BaseRepository::SS_CART_DOOR;
		}else {
			$cart = BaseRepository::SS_CART_WINDOW;
		}
		$ss_cart = $cart.'_'.$shop_id;
		$data = Session::get($ss_cart);
		if (!is_array($data))
			$data = [];
		$index = $shop_id.'_'.time();
		$data[$index] = $request->all();

		//set index and delete product in cart when back step
        $index_old = "";
		if(Session::has(BaseRepository::SS_DATA)){
			$data_prod = Session::get(BaseRepository::SS_DATA);
			if (isset($data_prod[$category][$shop_id][1]['cart_index'])){
				$old = $data_prod[$category][$shop_id][1]['cart_index'];
                $index_old = $old;
				unset($data[$old]);
			}
			$data_prod[$category][$shop_id][1]['cart_index'] = $index;
			Session::put(BaseRepository::SS_DATA, $data_prod);
		}

		Session::put($ss_cart,$data);

        $config_cart = $this->config_cart($category, $shop_id,$data);
		if (isset($request->recommend) === true) {
            $recommend = json_decode($request->recommend);
            $recommend->index_product_cart = $index;
            $config_cart['recommend'][$index] = $recommend;
            //set index and delete recommend in cart when back step
            if (($index_old !== "") && (isset($config_cart['recommend'][$index_old]) == true)) {
                unset($config_cart['recommend'][$index_old]);
            }

            $this->save_config_cart($config_cart, $category,$shop_id);
        }

		return $data;
    }

    public function delete_product($request){
		if ($request->category == 'door'){
			$cart = BaseRepository::SS_CART_DOOR;
		}else {
			$cart = BaseRepository::SS_CART_WINDOW;
		}
		$ss_cart = $cart.'_'.$request->shop_id;
		$data = Session::get($ss_cart);
		$index = $request->index;
		if (isset($data[$index])){
			unset($data[$index]);
		}
		Session::put($ss_cart,$data);

        $this->delete_recommend ($request->category,$request->shop_id,$index);
		return $data;
	}

	public function edit_quantity ($request) {
		if ($request->category == 'door'){
			$cart = BaseRepository::SS_CART_DOOR;
		}else {
			$cart = BaseRepository::SS_CART_WINDOW;
		}
		$ss_cart = $cart.'_'.$request->shop_id;
		$data = Session::get($ss_cart);
		foreach ($request->quantity as $index => $value) {
			if (isset($data[$value['data_index']]['quantity'])){
				$data[$value['data_index']]['quantity'] = $value['data_quantity'];
			}
		}
		Session::put($ss_cart,$data);
		return $data;
	}

	public function cart($screen, $shop_id){
		if ($screen == 'door'){
			$cart = BaseRepository::SS_CART_DOOR;
		}else {
			$cart = BaseRepository::SS_CART_WINDOW;
		}
		$ss_cart = $cart.'_'.$shop_id;

		$cart = Session::get($ss_cart);
		if ($cart === null) {
			$cart = [];
		}



		return $cart;
	}

	public function clear_cart($category, $shop_id) {
		if ($category == 'door'){
			$cart = BaseRepository::SS_CART_DOOR;
		}else {
			$cart = BaseRepository::SS_CART_WINDOW;
		}
		$ss_cart = $cart.'_'.$shop_id;

		return  Session::forget($ss_cart);
	}


    /**
     * Add Thanh VNIT BP_MMEN-24 20190822
     * @param $recommend
     * @param $type_product
     * @param $shop_id
     * @return array
     */
	public function save_config_cart ($recommend, $type_product, $shop_id) {
        if ($type_product === 'window') {
            $index_config =  BaseRepository::SS_CART_CONFIG_WINDOW;
        } else {
            return [];
        }
        $index_config .= '_'.$shop_id;

        Session::put($index_config,$recommend);
    }

    /**
     * Add Thanh VNIT BP_MMEN-24 20190822
     * @param $type_product
     * @param $shop_id
     * @return array
     */
    public function config_cart ($type_product, $shop_id, $cart) {
	    if ($type_product === 'window') {
            $index_config =  BaseRepository::SS_CART_CONFIG_WINDOW;
        } else {
	        return [];
        }

        $data_recommend = Session::get($index_config.'_'.$shop_id);
        $handling = $this->check_setting_recommend($shop_id);
        if($handling) {
            if (count($cart) == 0) {
                $data_recommend = [];
                $data_recommend['status_recommend'] = config('recommend.status.display');
            } else {
                foreach ($cart as $key => $data) {
                    $product = json_decode($data['product_data'], true);
                    if (in_array($product['m_product_id'], config('recommend.recommend_curtain'))) {
                        $data_recommend['status_recommend'] = config('recommend.status.not_display');
                        break;
                    } else {
                        $data_recommend['status_recommend'] = config('recommend.status.display');
                    }
                }
            }
        } else {
            $data_recommend['status_recommend'] = config('recommend.status.not_display');

        }
        $this->save_config_cart($data_recommend, $type_product, $shop_id);

        $data_config = Session::get($index_config.'_'.$shop_id);

        return $data_config;
    }

    public function delete_recommend ($type_product,$shop_id,$index) {
        if ($type_product === 'window') {
            $index_config =  BaseRepository::SS_CART_CONFIG_WINDOW;
        } else {
            return [];
        }
        $data_config = Session::get($index_config.'_'.$shop_id);
        if (isset($data_config['recommend'][$index])) {
            unset($data_config['recommend'][$index]);
        }
        $this->save_config_cart($data_config, $type_product, $shop_id);
    }

    /**
     * @param $shop_id
     * @return bool
     */
    public function check_setting_recommend ($shop_id) {
        $sql = config('recommend.sql.check_display');
        $param = array('shop_id' => $shop_id);
        $handling = DB::connection(config('settings.connect_db2'))->Select($sql,$param);
        if (count($handling) > 0) {
            return true;
        } else {
            return false;
        }


    }


	public function get_shop_id($pref_code, $standard_shop_code){

		$shop = [
			'id' => NULL,
			'premium' => 0,
			'shop_class_id' => null
		];

		$pref_id = DB::table('prefs')->where([
			['code', '=', $pref_code],
			['deleted_at', '=', NULL],
		])->value('id');

		if($pref_id){
			$sql = "
				SELECT
					id,
				    name, -- Add Thanh VNIT 20190814
					(CASE WHEN shop_class_id = 2 THEN 1 ELSE 0 END) as premium,
					shop_class_id,
					can_simulate,
				    shop_type
				FROM shops
				WHERE shop_code =:shop_code and pref_id =:pref_id and deleted_at IS NULL
				LIMIT 1
			";
			$result = DB::select($sql, [
				'shop_code' => $standard_shop_code,
				'pref_id' => $pref_id
			]);
			if($result){
				$shop = collect($result[0])->toArray();
			}
		}

		return $shop;
	}

    /**
     * @param $pref_code
     * @param $standard_shop_code
     * @return |null
     */
	public function get_shop ($pref_code, $standard_shop_code) {
        $sql = "
				SELECT
					sh.id,
				    sh.name, -- Add Thanh VNIT 20190814,
				    sh.email, -- Add Thanh VNIT 20191021
					(CASE WHEN sh.shop_class_id = 2 THEN 1 ELSE 0 END) as premium,
					sh.shop_class_id
				FROM shops sh
				INNER JOIN prefs pr ON sh.pref_id = pr.id
				WHERE sh.shop_code =:shop_code and pr.code =:pref_code and sh.deleted_at IS NULL
				LIMIT 1
			";
        $shop = DB::select($sql, [
            'shop_code' => $standard_shop_code,
            'pref_code' => $pref_code
        ]);
        if (count($shop) > 0) {
            return $shop[0];
        } else {
            return null;
        }
    }

	public function get_district() {
		$sql = "
				SELECT value FROM m_master_define
				WHERE data_type  = '都道府県' AND del_flg = 0
				ORDER BY sort_flg
				";
		$districts = DB::connection(config('settings.connect_db2'))->Select($sql);
		return $districts;
	}

	public function get_shop_by_id ($id) {
		$shop = array();
		$sql = "
				SELECT
					*
				FROM shops
				WHERE id =:shop_id
				LIMIT 1
			";
		$result = DB::select($sql, [
				'shop_id' => $id,
		]);
		if($result){
			$shop = collect($result[0])->toArray();
		}
		return $shop;
	}


	public function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

	/**
	 * Save cart to table t_mail_detail, t_select_detail, t_select_option_detail
	 * @param  [array] $data
	 */
	public function store_history($data){

		$t_mail_detail_id = DB::connection(config('settings.connect_db2'))->table('t_mail_detail')->insertGetId([
			'shop_id'      => $data['shop_id'],
			'total_price'  => $data['save_cart']['total_price'],
			'mail_content' => $data['mail_content'],
			'status'       => $data['mail_status'],
			'ip_address'   => $this->get_client_ip(),
			'session_id'   => \Session::getId(),
			'button_name'  => $data['button_name']
		]);
		if($t_mail_detail_id != 0){
			foreach($data['save_cart']['t_select_detail_id'] as $id){
	        	DB::connection(config('settings.connect_db2'))->table('t_select_detail')
	            ->where('t_select_detail_id', $id)
	            ->update(['t_mail_detail_id' => $t_mail_detail_id]);
	    	}
		}
	}

	/**
	 * Create pdf file save at tmp folder
	 * @param  [array] $data [cart_data]
	 * @return [array]       [tmp_path vs file name pdf]
	 */
	public function create_pdf($data){
       	$pdf_data['file_name'] = '窓シミュレーション結果.pdf';
       	if($data['screen'] == 'door') {
       		$view = 'Estimate.Front.pages.door.cart';
       	} else {
       		$view = 'Estimate.Front.pages.windows.cart';
       	}
    	$pdf = PDF::loadView($view, collect($data))->setOption('viewport-size', '1366x1024')
            ->setOption('enable-javascript', true)
            ->setOption('javascript-delay', 100)
            ->setOption('orientation', 'Landscape');
       	$temp_file = tempnam(sys_get_temp_dir(), 'inv');
       	$pdf->save($temp_file, true);
       	$pdf_data['path'] = $temp_file;

       	return $pdf_data;
    }

}