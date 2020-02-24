<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class M_MailAddress extends Model {
    //put your code here
    protected $table = 'm_mailaddress';    
    protected $fillable = ['id','groupname','description','maillist','create_user','update_user','del_flg'];
    public static function GetMailList($groupnames) {
        $sql = "SELECT * from users where del_flg=0 ";
        $whereval="";
        foreach ($groupnames as $value) 
        {
            $value=addslashes($value);
            if($whereval !="") 
                $whereval.=" or ";
            $whereval .=" company ='$value' ";
        }
        $sql .= " and (" . $whereval . ")";
        $res = DB::select($sql);
        return $res;
    }
}