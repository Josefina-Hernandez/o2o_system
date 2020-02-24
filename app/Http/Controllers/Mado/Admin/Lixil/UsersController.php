<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Mado\Admin\Lixil;

use App\Facades\MadoLog;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Controllers\M_MailAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * Description of UsersController
 *
 * @author Vnit
 */
class UsersController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        
        $user = Auth::user();
        $data = $this->getUsers();
        $companies=M_MailAddress::where('del_flg', 0)->get();
        $return["Users"] = $data;
        $return["Companies"]=$companies;
        $return["Role"] = $user['admin'];
        return view('mado.admin.lixil.users', $return);
    }

    private function getUsers() {
        $user = Auth::user();
        if($user->isAdmin()){
            $data = User::where(config('const.db.users.DEL_FLG'), 0)->get()->sortBy(config('const.db.users.ID'));
        }
        if(!$user->isAdmin()){
           $data = User::where(config('const.db.users.DEL_FLG'), 0)->where(config('const.db.users.ID'),$user->id)->get()->sortBy(config('const.db.users.ID'));
        }
        return $data;
    }

    public function save(Request $request) {
        
        try {
            User::beginTransaction();
            $jsonData = json_decode($request->getContent(), true);
            $user = Auth::user();
            foreach ($jsonData["user"] as $row) {
                //var_dump($row);exit;
                if ($row["id"] > 0) {
                    if ($user->isAdmin()) {
                        $res = User::whereId($row["id"])->update([
                                        config('const.db.users.EMAIL') => $row["email"],
                                        config('const.db.users.NAME') => $row["name"],
                                        config('const.db.users.LOGIN_ID') => $row["userid"],
                                        config('const.db.users.PHONENUMBER') => $row["phonenumber"],
                                        config('const.db.users.COMPANY') => $row["company"],
                                        config('const.db.users.STATUS') => $row["status"],
                                        config('const.db.users.ADMIN') => $row["role"],
                                        config('const.db.users.UPDATED_AT') => now(),
                                        config('const.db.users.UPDATED_USER')=>$user->id,
                                    ]);
                    } elseif ($user->id == $row["id"]) {
                         $res = User::whereId($row["id"])->update([
                                        config('const.db.users.EMAIL') => $row["email"],
                                        config('const.db.users.NAME') => $row["name"],                          
                                        config('const.db.users.PHONENUMBER') => $row["phonenumber"],
                                        config('const.db.users.COMPANY') => $row["company"],
                                        config('const.db.users.STATUS') => $row["status"],
                                        config('const.db.users.ADMIN') => $row["role"],
                                        config('const.db.users.UPDATED_AT') => now(),
                                        config('const.db.users.UPDATED_USER') => $user->id,
                                    ]);
                    }
                } else {
                    if ($user->isAdmin()) {
                        $userData=User::where('del_flg', 0)->where('login_id','=', $row["userid"])->first();
                        if ($userData == null) {
                            $res = User::create([
                                        config('const.db.users.LOGIN_ID') => $row["userid"],
                                        config('const.db.users.EMAIL') => $row["email"],
                                        config('const.db.users.NAME') => $row["name"],
                                        config('const.db.users.SHOP_ID') => 4,
                                        config('const.db.users.SHOP_CLASS_ID') => 4,
                                        config('const.db.users.PHONENUMBER') => $row["phonenumber"],
                                        config('const.db.users.COMPANY') => $row["company"],
                                        config('const.db.users.PASSWORD') => Hash::make($row["userid"]),
                                        config('const.db.users.STATUS') => $row["status"],
                                        config('const.db.users.ADMIN') => $row["role"],
                                        config('const.db.users.CREATE_USER')=> $user->id,
                                        config('const.db.users.UPDATED_USER')=> $user->id,
                                    ]);
                        } else {
                            echo 1;                          
                            exit;
                        }
                    }
                }
            }
            User::commit();
        } catch (Exception $ex) {
            User::rollBack();
        }


        //load data again
        $user = Auth::user();
        $data = $this->getUsers();
        $companies=M_MailAddress::where('del_flg', 0)->get();
        $return["Users"] = $data;
        $return["Companies"]=$companies;
        $return["Role"] = $user['admin'];
      
        return view('mado.admin.lixil.users.listuser', $return);
    }

    public function delete(Request $request) {

        $id = $request->id;
        try {
            $user = Auth::user();

            if ($user->isSuperAdmin()) {
                //$res=  User::destroy($id); 
                $res = User::whereId($id)->update([config('const.db.users.DEL_FLG') => 1,
                    config('const.db.users.UPDATED_USER')=>$user->id,
                    config('const.db.users.UPDATED_AT') => now(),
                    config('const.db.users.DELETED_AT') => now(),
                ]);
                return 0;
            } else {
                return 1;
            }
        } catch (Exception $ex) {
            return 1;
        }
    }

    public function changepass(Request $request) {
        $id = $request->id;
        $password = $request->password;
        $newpassword = $request->newpassword;
        try {
            $user = Auth::user();
            if ($user->isAdmin() || $user->id == $id) {
                $rowuser = User::where(config('const.db.users.ID'), "=", $id)->where(config('const.db.users.DEL_FLG'), "=", 0)->first();
                if (isset($rowuser) && Hash::check($password, $rowuser->password)) {
                    $res = User::whereId($id)->update([config('const.db.users.PASSWORD') => Hash::make($newpassword),
                        config('const.db.users.UPDATED_USER') => $user->id,
                        config('const.db.users.UPDATED_AT') => now(),
                    ]);
                    return 0;
                } else {
                    return 1;
                }
            }else {
                return 1;
            }
        } catch (Exception $ex) {
            return 1;
        }
    }

}
