<?php

namespace App\Http\Controllers\Mado\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('mado.admin.shop.login.index');
    }

    /**
     * 認証後のリダイレクト先を指定する
     * redirectTo関数はredirectToプロパティよりも優先される
     */
    protected function redirectTo()
    {
        $user = Auth::user();
        return route('admin.shop', ['shop_id' => $user->shop_id]);
    }

    /**
     * Get the login username to be used by the controller.
     * 
     * プロバイダのモデルでどのカラムを認証に使うかを指定する
     *
     * @return string
     */
    public function username()
    {
        return 'login_id';
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $_paramLogin = $this->credentials($request);
        $_paramLogin[config('const.db.users.STATUS')] = 1;
        return $this->guard()->attempt(
            $_paramLogin
        );
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

        $request->session()->invalidate();

        // ログアウト時にショップ管理ログイン画面にリダイレクトする
        return redirect()->route('admin.login');
    }
}
