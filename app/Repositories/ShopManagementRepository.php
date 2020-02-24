<?php

namespace App\Repositories;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;
use App\Repositories\AmountSetDetailRepository;

class ShopManagementRepository
{
    protected $products = [2,3,4,1,6,7,8,9,10];
    protected $data_is_generatting = '他のユーザがデータを更新しました。';
    protected $can_not_delete_folder = 'ロックフォルダが削除できないので、リクエストが処理できません。';
    protected $error_handling_data = 'データ作成時、エラーが発生しました。';

    public function getDataShopManagements($shop_id)
    {
        return DB::connection(config('settings.connect_db2'))
            ->table('m_shop_management AS shop_m')
            ->where('shop_m.del_flg', 0)
            ->join('m_shop_category AS shop_cate', function ($join) use ($shop_id) {
                $join->on('shop_cate.m_shop_category_id', '=', 'shop_m.m_shop_category_id')
                    ->where('shop_cate.shop_id', '=', $shop_id)
                    ->where('shop_cate.del_flg', 0);
            })
            ->join('m_product', function ($join) {
                $join->on('m_product.m_product_id', '=', 'shop_cate.m_product_id')
                    ->where('m_product.del_flg', 0);
            })
            ->join('m_category', function ($join) {
                $join->on('m_category.m_category_id', '=', 'm_product.m_category_id')
                    ->where('m_category.del_flg', 0);
            })
            ->select(
                'm_product.product_name',
                'm_product.m_product_id',
                'm_category.category_name',
                'm_category.category_code',
                'shop_m.m_shop_management_id',
                'shop_m.rate',
                'shop_m.amount',
                'shop_m.handling_flg',
                'shop_m.setting_type',
                'shop_m.add_datetime',
                'shop_m.upd_datetime'
            )
            ->groupBy('shop_m.m_shop_category_id', 'shop_m.setting_type')
            ->orderBy('m_product.m_product_id')
            ->get()
            ->all();
    }

    /**
     * Check data shop_management of shop_id
     * @param  integer $shop_id
     * @return boolean true if already data, false if not have data
     */
    public function check_generate_data_shop_management($shop_id)
    {
        $data_count = DB::connection(config('settings.connect_db2'))
            ->table('m_shop_management AS shop_m')
            ->where('shop_m.del_flg', 0)
            ->join('m_shop_category AS shop_cate', function ($join) use ($shop_id) {
                $join->on('shop_cate.m_shop_category_id', '=', 'shop_m.m_shop_category_id')
                    ->where('shop_cate.shop_id', '=', $shop_id)
                    ->where('shop_cate.del_flg', 0);
            })
            ->join('m_product', function ($join) {
                $join->on('m_product.m_product_id', '=', 'shop_cate.m_product_id')
                    ->where('m_product.del_flg', 0);
            })
            ->join('m_category', function ($join) {
                $join->on('m_category.m_category_id', '=', 'm_product.m_category_id')
                    ->where('m_category.del_flg', 0);
            })
            ->groupBy('shop_m.m_shop_category_id')
            ->get()
            ->count();

        return $data_count >= count($this->products);
    }


    /**
     * get data m_shop_category
     * @param  array $products
     * @param  integer $shop_id
     * @return array with format [m_shop_category_id:m_product_id]
     */
    public function get_shop_categories($products, $shop_id)
    {
        return DB::connection(config('settings.connect_db2'))
            ->table('m_shop_category')
            ->join('m_product', 'm_product.m_product_id', '=', 'm_shop_category.m_product_id')
            ->where('shop_id', $shop_id)
            ->where('m_shop_category.del_flg', 0)
            ->where('m_product.del_flg', 0)
            ->whereIn('m_shop_category.m_product_id', $products)
            ->groupBy('shop_id', 'm_shop_category.m_product_id')
            ->orderBy('m_shop_category_id')
            ->pluck('m_shop_category.m_product_id', 'm_shop_category_id')
            ->toArray();
    }

    /**
     * get m_shop_management exists
     * @param  array $shop_category_ids
     * @param  integer $shop_id
     * @return array with format [m_product_id:m_shop_category_id]
     */
    public function get_shop_management_exists($shop_category_ids, $shop_id)
    {
        return DB::connection(config('settings.connect_db2'))
            ->table('m_shop_management')
            ->join('m_shop_category', 'm_shop_category.m_shop_category_id', '=', 'm_shop_management.m_shop_category_id')
            ->where('shop_id', $shop_id)
            ->where('m_shop_category.del_flg', 0)
            ->where('m_shop_management.del_flg', 0)
            ->whereIn('m_shop_category.m_shop_category_id', $shop_category_ids)
            ->groupBy('m_shop_management.m_shop_category_id')
            ->pluck('m_shop_management.m_shop_category_id', 'm_shop_category.m_product_id')
            ->toArray();
    }

    public function get_product_ids()
    {
        return DB::connection(config('settings.connect_db2'))
            ->table('m_product')
            ->where('m_product.del_flg', 0)
            ->pluck('m_product_id')
            ->toArray();
    }

    public function generate_shop_cate_and_shop_manage_from_products($shop_info)
    {
        $shop_id = $shop_info->id;
        $products = $this->products;
        $shop_categories = $this->get_shop_categories($products, $shop_id);
        $product_ids = $this->get_product_ids();
        $content_spec0011 =  $this->get_content_spec0011();

        $data_generate_shopcates = [];
        foreach ($products as $key => $val_product_id) {
            if (in_array($val_product_id, $shop_categories)) continue;
            if (!in_array($val_product_id, $product_ids)) {
                throw new \Exception("Product is not exists in table m_product: " . $val_product_id);
            }

            $data_generate_shopcates[$key]['m_product_id'] = $val_product_id;
            $data_generate_shopcates[$key]['shop_id'] = $shop_id;
        }

        if (count($data_generate_shopcates)) {
            DB::connection(config('settings.connect_db2'))->table('m_shop_category')->insert($data_generate_shopcates);
            $shop_categories = $this->get_shop_categories($products, $shop_id);
        }

        $shop_category_ids = array_keys($shop_categories);
        $shop_management_exists = $this->get_shop_management_exists($shop_category_ids, $shop_id);

        $data_generate_shop_manages = [];
        foreach ($shop_categories as $shop_category_id => $m_product_id) {
            if (in_array($shop_category_id, $shop_management_exists)) continue;

            $data_create = [
                'm_shop_category_id' => $shop_category_id,
                'setting_type' => NULL,
                'rate_set' => 1,
                'handling_flg' => 1,
                'rate' => 1,
                'amount' => 0
            ];

            if ($m_product_id == 1) {
                $data_create['setting_type'] = '電気錠以外';
                $data_generate_shop_manages[] = $data_create;

                $data_create['setting_type'] = '電気錠';
                $data_generate_shop_manages[] = $data_create;

                continue;
            }

            if ($m_product_id == 6) {
                $data_create['setting_type'] = $content_spec0011['196'];
                $data_generate_shop_manages[] = $data_create;

                $data_create['setting_type'] = $content_spec0011['195'];
                $data_generate_shop_manages[] = $data_create;

                $data_create['setting_type'] = $content_spec0011['194'];
                $data_generate_shop_manages[] = $data_create;

                continue;
            }

            if ($m_product_id == 9) {
                $data_create['setting_type'] = NULL;
                $data_generate_shop_manages[] = $data_create;

                $data_create['setting_type'] = '装飾レール／機能レール';
                $data_generate_shop_manages[] = $data_create;

                continue;
            }

            $data_generate_shop_manages[] = $data_create;
        }

        if(count($data_generate_shop_manages)) {
            $AmountSetDetailRepo = new AmountSetDetailRepository();
        	foreach($data_generate_shop_manages as $shop_manages) {
        		$shop_management_id = DB::connection(config('settings.connect_db2'))->table('m_shop_management')->insertGetId($shop_manages);
            	$AmountSetDetailRepo->insert_data_default($shop_management_id);
        	}
        }
    }

    public function get_content_spec0011()
    {
        $result = DB::connection(config('settings.connect_db2'))
            ->table('m_spec_content')
            ->join('m_spec', 'm_spec_content.m_spec_id', '=', 'm_spec.m_spec_id')
            ->where('m_spec.m_spec_id', '=', 'spec0011')
            ->whereIn('m_spec_content_id', [194, 195, 196])
            ->pluck('spec_content', 'm_spec_content_id')
            ->toArray();

        return $result;
    }

    public function createDataManagement($shop_id)
    {
        // update m_shop_management.handling_flg = shops.can_simulate
        //AN VNIT - 2019/06/18 - Comment code synch handling_flg = can_simulate
        // $this->update_handling_flg($shop_id);
        // $this->synch_handling_flg_door_product($shop_id);
        $return = [
            'status' => true,
            'msg' => ''
        ];

        $check_generatedata = $this->check_generate_data_shop_management($shop_id);
        if ($check_generatedata === true) {
        	$AmountSetDetailRepo = new AmountSetDetailRepository();
	    	$AmountSetDetailRepo->insert_data_old_shop($shop_id);
            return $return;
        }

        $path_folder_lock = storage_path('app') . DIRECTORY_SEPARATOR . date('Ymd_') . $shop_id;
        try {
            mkdir($path_folder_lock);
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            $return['status'] = false;
            $return['msg'] = $this->data_is_generatting;

            return $return;
        }

        try {
            $shop_info = DB::table('shops')->where('id', '=', $shop_id)->select('name', 'can_simulate')->first();
            $shop_info->id = $shop_id;
            $this->generate_shop_cate_and_shop_manage_from_products($shop_info);

            if (file_exists($path_folder_lock)) {
                if (rmdir($path_folder_lock) ==  false) {
                    Log::info('ERROR!!!! Can not delete folder lock, Path: ' . $path_folder_lock);
                    $return['status'] = false;
                    $return['msg'] = $this->can_not_delete_folder;

                    return $return;
                }
            }

            return $return;
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            if (file_exists($path_folder_lock)) {
                if (rmdir($path_folder_lock) ==  false) {
                    Log::info('ERROR!!!! Can not delete folder lock, Path: ' . $path_folder_lock);
                    $return['status'] = false;
                    $return['msg'] = $this->can_not_delete_folder;

                    return $return;
                }
            }

            $return['status'] = false;
            $return['msg'] = $this->error_handling_data;

            return $return;
        }
    }

    public function update_handling_flg($shop_id)
    {
        $shop_managements = $this->getDataShopManagements($shop_id);
        $can_simulate = DB::table('shops')->where('id', '=', $shop_id)->pluck('can_simulate')->first();

        if (count($shop_managements)) {
            $shop_management_ids = [];
            $check_update = false;
            foreach ($shop_managements as $value) {
                if ($value->handling_flg != $can_simulate) {
                    $check_update = true;
                }

                $shop_management_ids[] = $value->m_shop_management_id;
            }

            if ($check_update === true) {
                DB::connection(config('settings.connect_db2'))
                    ->table('m_shop_management')
                    ->whereIn('m_shop_management_id', $shop_management_ids)
                    ->update(['handling_flg' => $can_simulate]);
            }
        }
    }

    public function synch_handling_flg_door_product($shop_id)
    {
        $shop_managements = $this->getDataShopManagements($shop_id);
        $can_simulate = DB::table('shops')->where('id', '=', $shop_id)->pluck('can_simulate')->first();

        if (count($shop_managements)) {
            $shop_management_ids = [];
            foreach ($shop_managements as $value) {
                if (
                    $value->category_code == 'door' &&
                    $value->m_product_id == 1 &&
                    $value->handling_flg != $can_simulate
                ) {
                    $shop_management_ids[] = $value->m_shop_management_id;
                }
            }

            if (count($shop_management_ids)) {
                DB::connection(config('settings.connect_db2'))
                    ->table('m_shop_management')
                    ->whereIn('m_shop_management_id', $shop_management_ids)
                    ->update([
                        'handling_flg' => $can_simulate,
                        'upd_datetime' => now()
                    ]);
            }
        }
    }
}