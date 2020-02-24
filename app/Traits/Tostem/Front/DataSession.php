<?php
namespace App\Traits\Tostem\Front;
use DB;
use Session;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait DataSession {

	public $sessionkey = 'data';

	public function getSessionKey($key) {

		return "{$this->sessionkey}.$key";
	}

	public function save(Request $request, $screen) {

    	if ( $request->isMethod('post')) {

	    	$posts = $request->except('_token');

	    	foreach($posts as $key => $value) {

	    		if($request->session()->has($this->sessionkey)) {
					$data_tmp = $request->session()->get($this->sessionkey);
					$data_tmp[$screen][$key] = $value;
				} else{
					$data_tmp[$screen][$key] = $value;
				}
	    	}

	    	$request->session()->put($this->sessionkey, $data_tmp);
	    }
    }

    public function get_data () {
	    return Session::get('data');
    }
}