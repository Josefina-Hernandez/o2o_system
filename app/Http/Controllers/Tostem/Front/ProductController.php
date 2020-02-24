<?php

namespace App\Http\Controllers\Tostem\Front;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
    protected $sql_get_colors;
    protected $sql_get_options;
    protected $sql_get_spec_group;

    /**
     * Sql get models
     *
     * @var
     */
    protected $sql_get_models;

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
        $this->sql_get_category = config('sql_building.select.CATEGORY');
        $this->sql_get_products = config('sql_building.select.PRODUCTS');
        $this->sql_get_models = config('sql_building.select.MODELS');
        $this->sql_get_colors = config('sql_building.select.COLORS');
        $this->sql_get_options = config('sql_building.select.OPTIONS');
        $this->sql_get_spec_group = config('sql_building.select.SPEC_GROUP');
        $this->data = [];
        $this->lang = str_replace('_', '-', app()->getLocale());
    }

    public function index(Request $request, $slug_name) {
        $data = $this->data;
        $data['category'] = collect(DB::select($this->sql_get_category, ['ctg_slug'=> $slug_name]))->first();
    	$data['ctg_slug'] = $data['category']->slug_name;
    	return view('tostem.front.quotation_system.products.products', $data);
    }



    public function get_products (Request $request, $slug_name) {

        $data = $this->data; //dd(app('session')->get('data'));
        $data['category'] = collect(DB::select($this->sql_get_category, ['ctg_slug'=> $slug_name]))->first();


        $param_sql = array(
            'lang_code' => $this->lang,
            'ctg_id' => $data['category']->ctg_id,
        );


        $products = collect(DB::select($this->sql_get_products, $param_sql)); //dd($products);
        return response($products);
    }

    public function get_models (Request $request, $slug_name) {

        $data = $this->data;
        $data['request'] = $request->all();
        if (isset($data['request']['product_id']) == false) {
            return response(array(
                'success' => false,
                'models' => [],
                'message' => "product_id not found",
                'request' => $data['request']['product_id']
            ),201,[]);
        }
        $data['category'] = collect(DB::select($this->sql_get_category, ['ctg_slug'=> $slug_name]))->first();
        $param_sql = array(
            //'lang_code' => $this->lang,
            'ctg_id' => $data['category']->ctg_id,
            'product_id' => $data['request']['product_id'],
        );
        foreach ($param_sql as $key => $param) {
            $this->sql_get_models = str_replace(':'.$key, $param, $this->sql_get_models);
        }
        $data = collect(DB::select($this->sql_get_models,  ['lang_code' => $this->lang] ));
        return response($data);

    }

    /**
     * Fetch list color
     * @param  Request $request
     * @param $slug_name
     * @return collection
     */
    public function fetchColors(Request $request, $slug_name) {
        $data = $this->data;
        $data['category'] = collect(DB::select($this->sql_get_category, ['ctg_slug'=> $slug_name]))->first();
		$data = collect(DB::Select($this->sql_get_colors, [
			'lang_code' => $this->lang,
			'ctg_id' => $data['category'] ->ctg_id,
			'product_id' => $request->input('product_id'),
			'm_model_id' => $request->input('m_model_id')
		]));

    	return response($data);
    }

    /**
     * Fetch list option
     * @param  Request $request
     * @return collection
     */
    public function fetchOptions(Request $request) {
    	$param = [
			'lang_code' => $this->lang,
			'ctg_id' => $request->session()->get($this->getSessionKey('quotation.ctg_id')),
			'product_id' => $request->input('product_id'),
			'm_model_id' => $request->input('m_model_id')
		];
    	$data = collect(DB::Select($this->sql_get_options, $param));

    	return response($data);
    }

    public function getSpecTrans(Request $request) {
		$data = collect(DB::table('m_selling_spec_trans')
			->select('spec_code', 'spec_name')
			->whereIn('spec_code', $request->input('list_spec'))
			->where([
				['del_flg', '=', 0],
				['m_lang_id', '=' , 1]
			])
			->get()
		)->mapWithKeys(function ($item) {
		    return [$item->spec_code => $item->spec_name];
		});
		return response($data);
    }

    public function getDataSellingSpec() {
		$data = collect(DB::Select($this->sql_get_spec_group));
    	return response($data);
    }
}
