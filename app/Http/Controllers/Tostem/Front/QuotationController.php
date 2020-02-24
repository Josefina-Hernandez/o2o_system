<?php

namespace App\Http\Controllers\Tostem\Front;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Traits\Tostem\Front\DataSession;

class QuotationController extends Controller {
	use DataSession;

	public $lang_code;
	public $sql_Select_Ctg;

	public function __construct() {
		$this->lang_code = str_replace('_', '-', \App::getLocale());
		$this->sql_Select_Ctg = config('sql_building.select.CTG');
	}

    public function index() {
	    $data = [];
        $data['categories'] = collect(DB::Select($this->sql_Select_Ctg, ['lang_code' => $this->lang_code]));
        //dd($data['categories']);
    	return view('tostem.front.quotation_system.index', $data);
    }

   /* public function fetchItemList() {
		$data = collect(DB::Select($this->sql_Select_Ctg, ['lang_code' => $this->lang_code]));
    	return response($data);
    }*/
}