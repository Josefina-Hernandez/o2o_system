<?php

namespace App\Http\Controllers\Tostem\Front;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Traits\Tostem\Front\DataSession;

class ProductController extends Controller
{
    use DataSession;
    /**
     * Sql get products
     *
     * @var
     */
    protected $sql_get_products;
    protected $sql_get_products_2;//for ctg id 2
    protected $sql_get_options;
    protected $sql_get_spec_group;
    protected $sql_get_group_label;

    /**
     * Sql get models
     *
     * @var
     */
    protected $sql_get_models;
    protected $sql_get_models_2;

    /**
     * Sql get category
     *
     * @var
     */
    protected $sql_get_category;

    /**
     * Data return view
     * Useful when add a param use many screen view
     * @var
     */
    protected $data;

    /**
     * Lang user use on client
     * @var string
     */
    protected $lang = '';

    function __construct()
    {
        $this->sql_get_category            = config('sql_building.select.CATEGORY');
        $this->sql_get_products            = config('sql_building.select.PRODUCTS');
        $this->sql_get_products_2          = config('sql_building.select.PRODUCTS_2');
        $this->sql_get_models              = config('sql_building.select.MODELS');
        $this->sql_get_models_2            = config('sql_building.select.MODELS_2');
        $this->sql_get_options             = config('sql_building.select.OPTIONS');
        $this->sql_get_spec_group          = config('sql_building.select.SPEC_GROUP');
        $this->sql_get_group_label         = config('sql_building.select.GROUP_LABEL');
        $this->sql_get_celling_code_option = config('sql_building.select.CELLING_CODE_OPTION');
        $this->sql_get_m_item_display      = config('sql_building.select.SELECT_MODEL_ITEM_DISPLAY');
        $this->sql_get_submenu             = config('sql_building.select.GET_SUBMENU');
		$this->data = [];
		$this->giestaDefaultSpecs = [
    		'spec51'     => null,
			'spec52'     => null,
			'spec53'     => null,
			'spec54'     => null,
			'spec55'     => null,
			'spec56'     => null,
			'spec57'     => null
    	];
        $this->lang = str_replace('_', '-', app()->getLocale());
    }

    public function index(Request $request, $slug_name) {
        $data = $this->data;
        $data['ctg'] = collect(DB::select(str_replace('(:viewer_flg)', $this->getRoleString(), $this->sql_get_category), [
        	'ctg_slug'  => $slug_name,
        	'lang_code' => $this->lang
        ]))->first();
    	return view('tostem.front.quotation_system.products.products', $data);
    }

    public function getCtgId($slug_name) {
    	$data = collect(DB::select(str_replace('(:viewer_flg)', $this->getRoleString(), $this->sql_get_category), [
    		'ctg_slug'  => $slug_name,
        	'lang_code' => $this->lang
    	]))->first();
    	return $data->ctg_id;
    }

    public function get_products (Request $request, $slug_name) {

    	$ctg_id = $this->getCtgId($slug_name);

    	if($ctg_id == 2) {
    		$sql = $this->sql_get_products_2;
    	} else {
    		$sql = $this->sql_get_products;
    	}

    	$sql = str_replace('(:viewer_flg)', $this->getRoleString(), $sql);

        $products = collect(DB::select($sql, [
        	'lang_code' => $this->lang,
            'ctg_id'    => $ctg_id,
        ]));

        return response($products);
    }

    public function getSubmenu(Request $request, $slug_name) {

        $ctg_id = $this->getCtgId($slug_name);

        $sql = $this->sql_get_submenu;

        $results = collect(DB::select($sql, [
            'lang_code' => $this->lang,
            'ctg_id'    => $ctg_id,
        ]));

        $sub_menus = [];
        foreach ($results as $result) {
            if ($ctg_id == 2) {
                $sub_menus[$result->product_id.$result->spec_code] = $result;
            } else {
                $sub_menus[$result->product_id] = $result;
            }
        }

        return response($sub_menus);
    }

    public function get_models (Request $request, $slug_name) {

        $ctg_id = $this->getCtgId($slug_name);
        $param_sql = [
            //'lang_code' => $this->lang,
            'ctg_id' => $ctg_id,
            'product_id' => $request->input('product_id'),
            'spec1' => $request->input('spec1'),
        ];

        header("X-spec1:v-".$param_sql['spec1']);
        if($ctg_id == 2 and $param_sql['spec1'] && $param_sql['spec1']!="null") {
        	//Exterior
        	$sql = $this->sql_get_models_2;
        } elseif($ctg_id == 3) {
        	//Giesta
        	$sql = config('sql_building.select.MODELS_GIESTA');
        } else {
        	$sql = $this->sql_get_models;
        }

    	$sql = str_replace('(:viewer_flg)', $this->getRoleString(), $sql);
        foreach ($param_sql as $key => $param) {
            $sql = str_replace(':'.$key, $param, $sql);
        }

        $data = collect(DB::select($sql,  ['lang_code' => $this->lang] ));
        return response($data);
    }

    /**
     * Fetch list option
     * @param  Request $request
     * @return collection
     */
    public function fetchOptions(Request $request, $slug_name) {
        if ( isset($_SERVER['HTTP_ACCEPT_ENCODING']) && substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
        {
            ob_start('ob_gzhandler');
        }
    	$ctg_id = $this->getCtgId($slug_name);
    	$strRole = $this->getRoleString();
    	$model_id = $request->input('m_model_id');
	    $color_id = intval($request->input('color_id'));
    	$param = [
			'lang_code' => 'en',
			'ctg_id' => $ctg_id,
			'product_id' => $request->input('product_id'),
			'm_model_id' => $model_id
		];
		$dataOption = array();
		$cacheKey = 'ctg' . $ctg_id . ':p' . $param['product_id'] . ':m' . $model_id;
    	if($ctg_id == 3) { //Giesta
			$cachedCount = -1;
			$dataOption = json_decode(Redis::get($cacheKey), false);
			
				if(count(DB::select("SHOW TABLES LIKE 'v_option_giesta_refer'")) > 0) {
					$sqlOption = config('sql_building.select.OPTIONS_GIESTA_DATA');
					$dataOption = DB::Select(str_replace('(:viewer_flg)', $strRole, $sqlOption), $param);
					$cachedCount = "db" . count($dataOption);	
				}
				if(is_null($dataOption) || count($dataOption) == 0) {
					$dataOption = DB::Select(str_replace('(:viewer_flg)', $strRole, config('sql_building.select.SELECT_MAIN_PANEL_GIESTA')), $param);
				}
				Redis::set($cacheKey, json_encode($dataOption), 'EX', 3600);

			$filteredData = [];
			$defaultColorID = intval($request->input('default_color_id'));
			if ($color_id > 0) {
				$defaultColorID = $color_id;
			}
			$optionColor = array();
			foreach($dataOption as $record) {
				$cid = $record->m_color_id;
				if ($defaultColorID <= 0) {
					$defaultColorID = $cid;
				}
				if ($defaultColorID == $cid) {
					array_push($filteredData, $record);
				}
				if (!isset($optionColor[$cid])) {	
					$optionColor[$cid] = $record;
				}
			}
			$data['option'] = $filteredData;
			$data['cached_count'] = $cachedCount;
			if ($color_id == 0) {
				$data['option_color'] = $optionColor;
			}
    		
	    	$data['option_handle_giesta']= DB::Select(str_replace('(:viewer_flg)', $strRole, config('sql_building.select.SELECT_OPTION_HANDLE_GIESTA')),[
	    		'lang_code' => $this->lang,
				'ctg_id' => $ctg_id,
				'product_id' => $request->input('product_id'),
				'spec51' => null,
				'spec52' => null,
				'spec53' => null,
				'spec54' => null,
				'spec55' => null,
				'spec56' => null,
				// 'spec57' => null
	    	]);

	    	$data['spec_image'] = DB::table('m_spec_image')
	    		->select('img_path', 'img_name', 'spec51', 'option4', 'spec57','spec53')
				->where([
					['del_flg', '=', 0],
					['product_id', '=' , $request->input('product_id')]
				])->get()->mapWithKeys(function ($item) {

					$path = $item->img_path . DIRECTORY_SEPARATOR . $item->img_name;

					if ($item->spec51 != null) {
						$key = $item->spec51;
					} elseif ($item->spec57 != null) {
						$key = $item->spec57;
					} elseif ($item->option4 != null) {
						$key = $item->option4;
					} elseif ($item->spec53 != null) {
						$key = $item->spec53;
					}

				    return [$key => $path];
				});


    	} else {
			$dataOption = DB::Select(str_replace('(:viewer_flg)', $strRole, config('sql_building.select.SELECT_MAIN_PANEL_GIESTA')), $param);

    		if(count(DB::select("SHOW TABLES LIKE 'v_option_refer'")) > 0){
	    		$sqlOption = config('sql_building.select.OPTIONS_DATA');
	    		$data['option'] = DB::Select(str_replace('(:viewer_flg)', $strRole, $sqlOption), $param);
	    		if(count($data['option']) == 0) {
	    			$data['option'] = DB::Select(str_replace('(:viewer_flg)', $strRole, $this->sql_get_options), $param);
	    		}
	    	} else {
	    		$sqlOption = $this->sql_get_options;
	    		$data['option'] = DB::Select(str_replace('(:viewer_flg)', $strRole, $sqlOption), $param);
	    	}

    		$sqlGetFenceModel = "
    			SELECT def_value AS m_model_id
				FROM   m_define_hardcode
				WHERE   del_flg = 0
					AND def_name = 'fence_setting'
					AND column_name = 'm_model_id'
    		";
    		$fenceModel = collect(DB::Select($sqlGetFenceModel))->map(function ($item) {
			    return $item->m_model_id;
			})->toArray();

	    	$data['is_fence'] = (in_array($model_id, $fenceModel)) ? true : false;

	    	//<Dup row for fence != Panel>
	    	if ($data['is_fence'] == true) {
	    		$data['config_fence_quantity'] = collect(DB::Select(config('sql_building.select.GET_CONFIG_FENCE_QUANTITY')));
	    	}
	    	//</Dup row for fence != Panel>

	    	//Get check spec10 display description: tồn tại m_model_id trong table m_define_hardcode => display
	    	$data['spec10_description_rule'] = false;
	    	//Check display Folding door image description
	    	$data['folding_door_image_manual'] = false;
	    	//Check display description
	    	$data['config_picture_show_r_movement'] = false;

			$dataQuerySettingModel = DB::table('m_define_hardcode')
				->whereIn('def_name', ['setting_model_left_picture_is_r', 'config_folding_door_image_manual', 'config_picture_show_r_movement'])
				->where([
					['del_flg', 0],
					['def_value', $model_id]
				])
	            ->get();

	        if(count($dataQuerySettingModel) > 0 ) {

	        	foreach ($dataQuerySettingModel as $setting) {
	        		$settingModel[$setting->def_name] = $setting;
	        	}

	        	//spec10_description_rule -> không sử dụng nữa thay bằng config_picture_show_r_movement
	        	//$data['spec10_description_rule']   = isset($settingModel['setting_model_left_picture_is_r'])  ? true : false;
	        	$data['folding_door_image_manual'] = isset($settingModel['config_folding_door_image_manual']) ? true : false;
	        	if (isset($settingModel['config_picture_show_r_movement'])) {
	        		$data['config_picture_show_r_movement'] =  $settingModel['config_picture_show_r_movement']->def_value2;
	        	}
	        }
    	}
		$data['m_item_display'] = $this->queryMItemDisplay($request->input('m_model_id'), $ctg_id, $request->input('product_id'));

        //Add BP_O2OQ-29 antran 2021/11/02
        $data['color_exclude'] = $this->getColorExlude($request->input('m_model_id'), $request->input('product_id'));
        //Add BP_O2OQ-29 antran 2021/11/02
        $data['check_add_gapcover'] = $this->getConfigAddGapcover($request->input('m_model_id'), $request->input('product_id'));

        //Add Start BP_O2OQ-7 hainp 20200714
		$cart = new CartService(null, null, null);
		$data['max_decimal'] = $cart->getMaxDecimal();
		//Add End BP_O2OQ-7 hainp 20200714
    	return response($data);
    }

    public function getSpecTrans(Request $request) {
    	$list_spec = $request->input('list_spec');
		$data_query = collect(DB::table('m_selling_spec_trans')
			->join('m_selling_spec', 'm_selling_spec_trans.spec_code', '=', 'm_selling_spec.spec_code')
			->join('m_lang', 'm_lang.m_lang_id', '=', 'm_selling_spec_trans.m_lang_id')
			->select('m_selling_spec_trans.spec_code', 'm_selling_spec_trans.spec_name', 'm_selling_spec.sort_order')
			->whereIn('m_selling_spec_trans.spec_code', $list_spec)
			->where([
				['m_selling_spec_trans.del_flg', '=', 0],
				['m_lang.lang_code', '=' , $this->lang],
				['m_selling_spec.del_flg', '=' , 0]
			])
			->orderBy('m_selling_spec.sort_order')
			->get()
		);

		//Text value translate
		$data['list_spec_trans'] = $data_query->mapWithKeys(function ($item) {
		    return [$item->spec_code => $item->spec_name];
		});

		//List order của value
		$data['list_spec'] = $data_query->mapWithKeys(function ($item) {
		    return [$item->spec_code => $item->sort_order];
		});

		$group_label = [];
		foreach($list_spec as $value) {
			$group_label[] = substr($value, 0, strpos($value, "."));
		}

		$sql = str_replace('(:m_spec_group_id)', "('" . join("','", array_unique($group_label)) ."')", $this->sql_get_group_label);
		$sql_spec_exclude = str_replace('(:spec_code)', "('" . join("','", array_unique($list_spec)) ."')", config('sql_building.select.SPEC_GROUP_DO_NOT_DISPLAY'));
		$data['spec_exclude'] = collect(DB::Select($sql_spec_exclude, ['lang_code' => $this->lang]))
			->map(function($item) {
				return $item->m_spec_group_id;
			});

		$spec_group = collect(DB::Select($sql, ['lang_code' => $this->lang]));
		$data['group_label'] = $spec_group->mapWithKeys(function ($item) {
			return [$item->m_spec_group_id => $item->spec_group_label];
		});

		//List order của spec
		$data['spec_code_order'] = [];
		if(!$spec_group->isEmpty()) {
			$data['spec_code_order'] = $spec_group->mapWithKeys(function ($item, $key) {
				$key = 'spec'.$item->m_spec_group_id;
				return [$key => $item->sort_order];
			});
		}

        $data['option_code_order'] = [];
        if(!$spec_group->isEmpty()) {
            $data['option_code_order'] = $spec_group->mapWithKeys(function ($item, $key) {
                $key = 'option'.str_replace('o','',$item->m_spec_group_id);
                return [$key => $item->sort_order];
            });
        }

		return response($data);
    }

    public function getDataSellingSpec() {
		$data = collect(DB::Select($this->sql_get_spec_group));
    	return response($data);
    }

    public function queryModelSpec($m_model_id) {
    	$data = DB::table('m_model_spec')
			->where([
				['m_model_id', '=', $m_model_id],
				['del_flg', '=', 0],
			])->get()->first();

		return $data;
    }

    public function queryMItemDisplay($m_model_id, $ctg_id, $product_id) {

    	$sql = $this->sql_get_m_item_display;

        //Start BP_O2OQ-27_new antran 20210823
        $params = [
            'lang_code' => $this->lang,
            'm_model_id' => $m_model_id,
            'product_id' => $product_id
        ];

    	if($ctg_id == 3) {
    		$sql = config('sql_building.select.SELECT_GIESTA_MODEL_ITEM_DISPLAY');
            unset($params['product_id']);
    	}

    	$data = DB::Select($sql, $params);

    	return $data;
    }

    public function getCellingCodeOption(Request $request) {
    	$where  = '';
    	$width_where = '';
    	$height_where = '';
    	$spec_where = '';
    	$option_where = '';
    	$option2 = null;
    	$order_by = " ORDER BY op.m_selling_code_id ASC";

		$specs          = $request->input('spec');
		$item_display   = $request->input('item_display');
    	$options        = $request->input('option');
    	$width          = $request->input('width');
    	$height         = $request->input('height');

    	foreach($specs as $spec => $spec_value) {
    		//$spec_where .= " AND ( op.$spec IS NULL OR op.$spec = '$spec_value' )";
    		$spec_where .= " AND ( sc.$spec = '$spec_value' )";
		}

		if($item_display) {
			foreach($item_display as $spec => $spec_value) {
				//$spec_where .= " AND ( op.$spec IS NULL OR op.$spec = '$spec_value' )";
				$spec_where .= " AND ( sc.$spec = '$spec_value' )";
			}
		}

    	foreach($options as $option => $option_value) {
    		$option_where .= " AND ( op.$option IS NULL OR op.$option = '$option_value' )";
    		if($option == 'option2') {
    			$option2 = $option_value;
    		}
    	}

    	if($width != null) {
    		$width_where = "
    			AND (op.min_width IS NULL OR op.min_width <= ".$width." )
				AND (op.max_width IS NULL OR op.max_width >= ".$width." )
    		";
    	}

    	if($height != null) {
    		$height_where = "
    			AND (op.min_height IS NULL OR op.min_height <= ".$height." )
				AND (op.max_height IS NULL OR op.max_height >= ".$height." )
    		";
    	}
    	$where = " AND
    		(
				-- Nhóm Insect screen check option, spec, width, height
				(
					op.option_ctg_spec_id = 34
					".$option_where."
					".$spec_where."
					".$width_where."
					".$height_where."
				)
				OR
				-- Nhóm Door closer check option2
				(
					op.option_ctg_spec_id = 35
					AND op.option2 = '".$option2."' -- Cố định option2
				)
				OR
				-- Nhóm Usage check spec
				(
					op.option_ctg_spec_id = 36
					".$spec_where."
				)
				OR
				-- Nhóm Soft Closer -- Add BP_O2OQ-6 MinhVnit 20200625
				(
					op.option_ctg_spec_id = 74
					".$option_where."
					".$spec_where."
				)
				OR
				-- Nhóm Handle type -- Add BP_O2OQ-6 MinhVnit 20200625
				(
					op.option_ctg_spec_id = 75
					".$option_where."
					".$spec_where."
				)
				OR
				-- Nhóm Net type -- Add BP_O2OQ-27 MinhVnit 20210825
				(
					op.option_ctg_spec_id = 77
					".$option_where."
					".$spec_where."
				)
				OR
				-- Nhóm Handle ATIS type -- Add BP_O2OQ-27 MinhVnit 20210825
				(
					op.option_ctg_spec_id = 78
					".$option_where."
					".$spec_where."
				)
				OR
				-- Nhóm Flat sill attachment type -- Add BP_O2OQ-27 MinhVnit 20210825
				(
					op.option_ctg_spec_id = 79
					".$option_where."
					".$spec_where."
				)
				OR
				-- Nhóm Balancer type -- Add BP_O2OQ-27 MinhVnit 20210825
				(
					op.option_ctg_spec_id = 80
					".$option_where."
					".$spec_where."
				)
				OR
				-- Nhóm Option Parts -- Add BP_O2OQ-29 MinhVnit 20211029
				(
					op.option_ctg_spec_id = 85
					".$option_where."
					".$spec_where."
				)
				OR
				-- Nhóm Chain Length -- Add BP_O2OQ-29 MinhVnit 20211029
				(
					op.option_ctg_spec_id = 86
					".$option_where."
					".$spec_where."
				)
				OR
				-- Nhóm Gap Cover -- Add BP_O2OQ-29 MinhVnit 20211029
				(
					op.option_ctg_spec_id = 87
					".$option_where."
					".$spec_where."
				)
			)
    	";


		$sql = $this->sql_get_celling_code_option . $where . $order_by;
    	$data = collect(DB::Select($sql, [
    		'lang_code' => $this->lang,
    		'product_id' => $request->input('product_id'),
    		'm_color_id' => $request->input('m_color_id'),
    		'width' => $request->input('width'),
    		'height' => $request->input('height'),
    		'm_model_id' => $request->input('m_model_id')
    	]));
    	return response($data);
    }

    public function getGiestaHiddenData(Request $request) {
    	$data['frame']             = $this->getGiestaFrame($request);
    	$data['sub_panel']         = $this->getGiestaSubPanel($request);
    	$data['option_cylinder']   = $this->getGiestaOptionCylinder($request);
    	$data['option_closer']     = $this->getGiestaOptionCloser($request);
    	$data['option_door_guard'] = $this->getGiestaOptionDoorGuard($request);
		//echo var_dump($data);
    	return response($data);
		
    }

    public function getGiestaSubPanel($request) {
    	$argSpecs = array_merge($this->giestaDefaultSpecs, $request->input('specs'));
    	$param = [
			'lang_code'     => $this->lang,
			'spec51'        => $argSpecs['spec51'],
			'spec52'        => null, //Không lọc theo spec này
			'spec53'        => $argSpecs['spec53'],
			'spec54'        => $argSpecs['spec54'],
			'spec55'        => $argSpecs['spec55'],
			'spec56'        => $argSpecs['spec56'],
			'spec57'        => $argSpecs['spec57'],
			'ctg_id'        => $request->input('ctg_id'),
			'product_id'    => $request->input('product_id'),
			'm_model_id'    => $request->input('m_model_id'),
			'main_color_id' => $request->input('m_color_id'),
			'width'         => $request->input('width'),
			'height'        => $request->input('height')
    	];
    	return DB::Select(str_replace('(:viewer_flg)', $this->getRoleString(), config('sql_building.select.SELECT_SUB_PANEL_GIESTA')), $param);
    }

    public function getGiestaOptionCylinder($request) {
    	$flg_get_data = true;//True thì lấy data bình thường
    	$config_giesta_digital_hidden_cylinder = DB::table('m_define_hardcode')
    		->select('column_name', 'def_value')
    		->where([
    			['del_flg', 0],
    			['def_name', 'config_giesta_digital_hidden_cylinder'],
    		])->get();

    	if (empty($config_giesta_digital_hidden_cylinder) == false) {
    		$spec = $request->input('specs');
    		foreach ($config_giesta_digital_hidden_cylinder as $row) {
    			if ($spec[$row->column_name] == $row->def_value) {
	    			$flg_get_data = false;
	    		}
    		}
    	}

    	if ($flg_get_data == true) {
    		$argSpecs = array_merge($this->giestaDefaultSpecs, $request->input('specs'));
	    	$param = [
				'lang_code'     => $this->lang,
				'spec51'        => $argSpecs['spec51'],
				'spec52'        => $argSpecs['spec52'],
				'spec53'        => $argSpecs['spec53'],
				'spec54'        => $argSpecs['spec54'],
				'spec55'        => $argSpecs['spec55'],
				'spec56'        => $argSpecs['spec56'],
				// 'spec57'        => $argSpecs['spec57'],
				'ctg_id'        => $request->input('ctg_id'),
				'product_id'    => $request->input('product_id'),
				'handle_color_id' => $request->input('handle_color_id'),
	    	];
	    	return DB::Select(str_replace('(:viewer_flg)', $this->getRoleString(), config('sql_building.select.SELECT_OPTION_CYLINDER_GIESTA')), $param);
    	}

	    return [];
    }

    public function getGiestaOptionDoorGuard($request) {
    	$argSpecs = array_merge($this->giestaDefaultSpecs, $request->input('specs'));
    	$param = [
			'lang_code'     => $this->lang,
			'spec51'        => $argSpecs['spec51'],
			'spec52'        => $argSpecs['spec52'],
			'spec53'        => $argSpecs['spec53'],
			'spec54'        => $argSpecs['spec54'],
			'spec55'        => $argSpecs['spec55'],
			'spec56'        => $argSpecs['spec56'],
			// 'spec57'        => $argSpecs['spec57'],
			'ctg_id'        => $request->input('ctg_id'),
			'product_id'    => $request->input('product_id'),
			'handle_color_id' => $request->input('handle_color_id'),
    	];
    	return DB::Select(str_replace('(:viewer_flg)', $this->getRoleString(), config('sql_building.select.SELECT_OPTION_DOOR_GUARD_GIESTA')), $param);
    }

    public function getGiestaOptionCloser($request) {
    	$argSpecs = array_merge($this->giestaDefaultSpecs, $request->input('specs'));
    	$param = [
			'lang_code'     => $this->lang,
			'spec51'        => $argSpecs['spec51'],
			'spec52'        => null, //Không lọc theo spec này
			'spec53'        => $argSpecs['spec53'],
			'spec54'        => $argSpecs['spec54'],
			'spec55'        => $argSpecs['spec55'],
			'spec56'        => null, //không lọc theo spec này
			// 'spec57'        => $argSpecs['spec57'],
			'ctg_id'        => $request->input('ctg_id'),
			'product_id'    => $request->input('product_id'),
			'main_color_id' => $request->input('m_color_id'),
    	];
    	return DB::Select(str_replace('(:viewer_flg)', $this->getRoleString(), config('sql_building.select.SELECT_OPTION_CLOSER_GIESTA')), $param);
    }

    public function getGiestaFrame($request) {
    	$argSpecs = array_merge($this->giestaDefaultSpecs, $request->input('specs'));
    	$param = [
			'lang_code'     => $this->lang,
			'spec51'        => $argSpecs['spec51'],
			'spec52'        => null, //Không lọc theo spec này
			'spec53'        => $argSpecs['spec53'],
			'spec54'        => $argSpecs['spec54'],
			'spec55'        => null, // $argSpecs['spec55'],
			'spec56'        => null, //không lọc theo spec này
			'spec57'        => $argSpecs['spec57'],
			'ctg_id'        => $request->input('ctg_id'),
			'product_id'    => $request->input('product_id'),
			'm_model_id'    => $request->input('m_model_id'),
			'main_color_id' => $request->input('m_color_id'),
			'width'         => $request->input('width'),
			'height'        => $request->input('height')
    	];
		#$logs=str_replace('(:viewer_flg)', $this->getRoleString(), config('sql_building.select.SELECT_FRAME_GIESTA'));
		#dd($logs);
    	$res = DB::Select(str_replace('(:viewer_flg)', $this->getRoleString(), config('sql_building.select.SELECT_FRAME_GIESTA')), $param);
        if ($res) return array_slice($res,0,1);
        return [];
    }

    /**
     * Get Giesta handle type(opiton4)
     * @param  Request $request
     * @return json
     */
    public function getGiestaHandleType(Request $request) {
    	$argSpecs = array_merge($this->giestaDefaultSpecs, $request->input('specs'));
    	$return = DB::Select(str_replace('(:viewer_flg)', $this->getRoleString(), config('sql_building.select.SELECT_OPTION_HANDLE_GIESTA')),[
			'lang_code'  => $this->lang,
			'ctg_id'     => $request->input('ctg_id'),
			'product_id' => $request->input('product_id'),
			'spec51'     => $argSpecs['spec51'],
			'spec52'     => $argSpecs['spec52'],
			'spec53'     => $argSpecs['spec53'],
			'spec54'     => $argSpecs['spec54'],
			'spec55'     => $argSpecs['spec55'],
			'spec56'     => $argSpecs['spec56'],
			// 'spec57'     => $argSpecs['spec57'],
    	]);
    	return response($return);
    }

    /**
     * Get Giesta sub panel
     * @param  Request $request
     * @return json
     */
    public function getGiestaSidePanel(Request $request) {
    	$argSpecs = array_merge($this->giestaDefaultSpecs, $request->input('specs'));
    	$return = DB::Select(str_replace('(:viewer_flg)', $this->getRoleString(), config('sql_building.select.SELECT_SIDE_PANEL_GIESTA')),[
			'lang_code'     => $this->lang,
			'spec51'        => $argSpecs['spec51'],
			'spec52'        => null, //Không lọc theo spec này
			'spec53'        => $argSpecs['spec53'],
			'spec54'        => $argSpecs['spec54'],
			'spec55'        => $argSpecs['spec55'],
			'spec56'        => $argSpecs['spec56'],
			'spec57'        => $argSpecs['spec57'],
			'ctg_id'        => $request->input('ctg_id'),
			'product_id'    => $request->input('product_id'),
			'm_model_id'    => $request->input('m_model_id'),
			'main_color_id' => $request->input('m_color_id'),
			'width'         => $request->input('width'),
			'height'        => $request->input('height')
    	]);
        if (empty($return) && $argSpecs['spec55'] == "55.3") {
            $return = DB::Select(str_replace('(:viewer_flg)', $this->getRoleString(), config('sql_building.select.SELECT_SIDE_PANEL_GIESTA')),[
			'lang_code'     => $this->lang,
			'spec51'        => $argSpecs['spec51'],
			'spec52'        => null, //Không lọc theo spec này
			'spec53'        => $argSpecs['spec53'],
			'spec54'        => $argSpecs['spec54'],
			'spec55'        => "55.2",
			'spec56'        => $argSpecs['spec56'],
			'spec57'        => $argSpecs['spec57'],
			'ctg_id'        => $request->input('ctg_id'),
			'product_id'    => $request->input('product_id'),
			'm_model_id'    => $request->input('m_model_id'),
			'main_color_id' => $request->input('m_color_id'),
			'width'         => $request->input('width'),
			'height'        => $request->input('height')
    	]);
        }

    	return response($return);
    }

    public function getCornerfixAmount (Request $request) {
    	$return = collect(DB::table('v_product_price_refer')
			->select('amount')
			->where([
				['design', $request->input('selling_code')],
				['width' , $request->input('width')],
				['height' , $request->input('height')]
			])
			->get()
		);

    	return response($return);
    }

    private function getRoleString() {
    	if(\Auth::check() && \Auth::user()->isEmployee()){
    		return '(3,1)';
    	}

    	return '(3)';
    }

    public function getConficStackNumber(Request $request) {
    	$return = 0;
    	$data = DB::Select(config('sql_building.select.GET_CONFIG_STACK_NUMBER_DISPLAY'), [
    		'm_model_id' => $request->input('m_model_id')
    	]);

    	if(count($data) > 0) {
    		$return = collect($data)->first();
    	}

    	return response()->json($return);
    }

    /**
     * Hiển thị hình ảnh description
     * @param  Request $request
     * @return boolen
     */
    public function getConfigDisplayImageDescription(Request $request) {

    	$config = [];

    	$config_display_pitch_list = DB::Select(config('sql_building.select.GET_CONFIG_DISPLAY_PITCH_LIST'), [
			'product_id' => $request->input('product_id'),
			'm_model_id'   => $request->input('model_id')
		]);

		$config_display_jamb_frame_list = DB::table('m_define_hardcode')
			->where([
				['del_flg', 0],
				['def_name', 'config_display_jamb_frame_list'],
				['def_value', $request->input('model_id')]
			])
			->select('def_value2')
			->get();

		if ($config_display_jamb_frame_list->isNotEmpty()) {
			$config[] = [
				'title' => 'jamb_frame_list',
				'image' => $config_display_jamb_frame_list[0]->def_value2,
				'description' => '',
				'spec' => ['spec34']
			];
		}

		if ($config_display_pitch_list) {
			$config[] = [
				'title' => 'pitch_list',
				'image' => $config_display_pitch_list[0]->img_name,
				'description' => __('screen-select.pitch_list_description'),
				'spec' => ['spec18']
			];
		}

		return response()->json($config);
    }

    public function getConfigAlwayDisplaySpecItem() {
    	$data = collect(DB::table('m_define_hardcode')
			->where([
				['del_flg', 0],
				['def_name', 'config_always_display_spec_item']
			])
			->select('def_value')
            ->get())->map(function ($item) {
            	return $item->def_value;
            })->toArray();
    	return response()->json($data);
    }

    public function getConfigRuleCompareItemSpec () {
    	$data = collect(DB::table('m_define_hardcode')
			->where([
				['del_flg', 0],
				['def_name', 'config_rule_compare_item_spec']
			])
			->select('def_value')
            ->get())->map(function ($item) {
            	return $item->def_value;
            })->toArray();
    	return response()->json($data);
    }

    public function getSizeLimit($product_id) {
    	$data = collect(DB::table('m_size_limit')
			->where([
				['del_flg', 0],
				['product_id', $product_id]
			])
			->select('spec35', 'spec33', 'min_width', 'max_width', 'min_height', 'max_height')
            ->get());
    	return response()->json($data);
    }

    /**
     * BP_O2OQ-14: Dup row cho hanging door
     * @param  Request $request
     * @return collection
     */
    public function getConfigCloneOptionAtProudct(Request $request) {
    	$data = DB::table('m_define_hardcode')
			->where([
				['del_flg', 0],
				['def_name', 'config_clone_option_at_product'],
				['def_value', $request->input('product_id')],
				['def_value1', $request->input('model_id')]
			])->get();
    	return response()->json($data);
    }

    /**
     * BP_O2O-29 Get color exclude
     * @param Request $request
     * @return  collection
     */
    protected function getColorExlude($model_id,$product_id) {
        return DB::table('m_define_hardcode')
            ->where([
                ['del_flg', 0],
                ['def_name', 'color_exclude_setting'],
                ['def_value1', $model_id],
                ['def_value', $product_id]
            ])
            ->pluck('def_value2')
            ->toArray();
    }

    /**
     * BP_O2O-29 check model add gap cover
     * @param Request $request
     * @return  collection
     */
    protected function getConfigAddGapcover($model_id,$product_id) {
        $data = DB::table('m_define_hardcode')
            ->where([
                ['del_flg', 0],
                ['def_name', 'config_add_option_gapcover'],
                ['def_value1', $product_id],
                ['def_value', $model_id]
            ])
            ->get();

        if (!empty($data) && count($data) > 0) {
            return true;
        }

        return false;
    }
}
