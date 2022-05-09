<?php

namespace App\Http\Controllers\Tostem\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/quotation_system';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
    {
        $this->middleware('front.employee')->except('logout');
    }

    public function showLoginForm()
    {
    	return view('tostem.front.login.index');
    }

    protected function redirectTo()
    {
        return route('tostem.front.quotation_system');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        // $request->session()->invalidate(); //Remove delete session cart thay cho delete all session hainp 20200925
        app('App\Http\Controllers\Tostem\Front\CartController')->clearCart(); //Add delete session cart thay cho delete all session hainp 20200925
        $request->session()->regenerateToken();

        return redirect()->route('tostem.front.index');
    }

    public function username()
    {
        return 'login_id';
    }

    protected function attemptLogin(Request $request)
    {
        $_paramLogin = $this->credentials($request);
        $_paramLogin[config('const.db.users.STATUS')] = 1;
        $_paramLogin[config('const.db.users.SHOP_CLASS_ID')] = 4;
        $check_login = $this->guard()->attempt($_paramLogin);
        if ($check_login) {
            return redirect()->back();
        }
        return $check_login;
    }

    /*protected function guard()
    {
    	return Auth::guard('guard-name');
    }*/
}
