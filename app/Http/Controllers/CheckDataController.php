<?php
namespace App\Http\Controllers;


use DB;
use App\Models\CheckData;

class CheckDataController extends Controller {
     
    public function index() {
     
         

         
        return view('tostem.admin.viewcheckdata');
         
    }
    
   
    

}