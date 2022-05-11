<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLoginUserController extends Controller
{
     
     public function checkUserLoginAdmin(Request $request){
         
           $return['status'] = 'OK';
           
           if (!Auth::check())
              {
                   $return['status'] = 'auth';
                   $return['msg'] = 'Your session has expired.';
                   $return['key'] = 0;

              }else{
                   if(!Auth::user()->isAdmin()){
                        $return['status'] = 'auth';
                        $return['msg'] ="Your session has expired.";
                        $return['key'] = 0;

                   }
              }
            return response()->json($return);
    }
     public function checkUserLogin(Request $request){
         
           $return['status'] = 'OK';
         
           if (!Auth::check())
              {
                   $return['status'] = 'auth';
                   $return['msg'] = 'Your session has expired.';
                   $return['key'] = 0;

              }else{
                   if(Auth::user()->isAdmin()){
                        $return['status'] = 'auth';
                        $return['msg'] ="Your session has expired.";
                        $return['key'] = 0;
                   }
              }
            
            return response()->json($return);
    }
    
}
