<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * 認可失敗時に実行される例外ハンドラ
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthorizationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function accessDenied($request, AuthorizationException $e)
    {
        $currentRoute = $request->route()->getName();

        // 強制ログアウトさせる
        Auth::logout();
        $request->session()->invalidate();

        // リダイレクト先のルートを決定する
        if (starts_with($currentRoute, 'admin.shop')) {
            // ショップ管理画面
            $toRoute = 'admin.login';

        } elseif (starts_with($currentRoute, 'admin.lixil')) {
            // LIXIL管理画面
            $toRoute = 'admin.login';

        } else {
            // 管理画面以外であるならフロントトップ
            $toRoute = '/';
        }

        // ログイン画面にリダイレクト
        return redirect()->route($toRoute);
    }

    /**
     * トークンミスマッチ時に実行される例外ハンドラ
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Session\TokenMismatchException $exception
     * @return \Illuminate\Http\Response
     */
    protected function tokenMismatch($request, TokenMismatchException $e)
    {
        //@TODO: リダイレクトするのかエラー画面を出力するのか不明
        // ログアウトさせるなら Auth::logout() の呼び出しをする
        abort(404, $e->getMessage());
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $currentRoute = $request->route()->getName();

        // リダイレクト先のルートを決定する
        if (starts_with($currentRoute, 'admin.shop')) {
            // ショップ管理画面
            $toRoute = 'admin.login';

        } elseif (starts_with($currentRoute, 'admin.lixil')) {
            // LIXIL管理画面
            $toRoute = 'admin.login';

        } elseif (starts_with($currentRoute, 'tostem.front.quotation_system')) {
        	$toRoute = 'tostem.front.login';

        } else {
            // 管理画面以外であるならフロントトップ
            $toRoute = '/';
        }

        return $request->expectsJson()
            ? response()->json(['message' => $exception->getMessage()], 401)
            : redirect()->guest(route($toRoute));
    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }
    


    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        
    	if ($request->ajax()) {
    		// If request is an ajax request, then check to see if token matches token provider in
		    // the header. This way, we can use CSRF protection in ajax requests also.
    		$token = $request->ajax() ? $request->header('X-CSRF-Token') : $request->input('_token');
    		if($request->session()->token() != $token) {
    			return response()->json([
    				'msg' => __('validation.tokenexpired')
    			], 401);
    		}
    	}

        if ($request->ajax()){
             
                $currentRoute = $request->route()->getName();
              
                if(starts_with($currentRoute, 'admin.lixil')){
                   
                       if (!Auth::check())
                        {
                             $return['status'] = 'auth';
                             $return['msg'] = 'Your session has expired.';
                             $return['key'] = 0;
                             return response()->json($return);
                        }else{
                             if(!Auth::user()->isAdmin()){
                                  $return['status'] = 'auth';
                                  $return['msg'] ="Your session has expired.";
                                  $return['key'] = 0;
                             return response()->json($return);
                             }
                             else
                             {
                                  $return['status'] = 'auth';
                                  $return['msg'] ="There is an error in your file. For more detail, please contact admin.";
                                  $return['key'] = 1;
                                  return response()->json($return); 
                             }
                        }
                     
               }
        }

        if ($this->isHttpException($exception)) {

             if ($request->ajax()){
                $currentRoute = $request->route()->getName();
                if(starts_with($currentRoute, 'admin.lixil.price-maintenance')){
                       if (!Auth::check())
                        {
                                   $return['status'] = 'auth';
                                   $return['msg'] = 'Your session has expired.';
                                   $return['key'] = 0;
                                   return response()->json($return);
                        }else{
                             if(!Auth::user()->isAdmin()){
                                   $return['status'] = 'auth';
                                   $return['msg'] ="Your session has expired.";
                                   $return['key'] = 1;
                                   return response()->json($return);    
                             }else{
                                  $return['status'] = 'auth';
                                  $return['msg'] ="There is an error in your file. For more detail, please contact admin.";
                                  $return['key'] = 1;
                                  return response()->json($return); 
                             }
                        }
                   
               }
           }


            if ($exception->getStatusCode() === 403) {
                return response()->view('mado.admin.error.403', [
                    'exception' => $exception,
                ]);
            }elseif($exception->getStatusCode() === 404){
                return response()->view('mado.errors.404', [
                    'exception' => $exception,
                ]);
            }elseif($exception->getStatusCode() === 503){
                return response()->view('mado.errors.503', [
                    'exception' => $exception,
                ]);
            }

        } else {
            if ($exception instanceof AuthorizationException) {
                return $this->accessDenied($request, $exception);

            } else if ($exception instanceof TokenMismatchException) {
                // トークン切れ
                return $this->tokenMismatch($request, $exception);
            }

        }


        return parent::render($request, $exception);
    }
}
