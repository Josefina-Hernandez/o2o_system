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
            $toRoute = 'admin.shop.login';

        } elseif (starts_with($currentRoute, 'admin.lixil')) {
            // LIXIL管理画面
            $toRoute = 'admin.lixil.login';

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
            $toRoute = 'admin.shop.login';

        } elseif (starts_with($currentRoute, 'admin.lixil')) {
            // LIXIL管理画面
            $toRoute = 'admin.lixil.login';

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
        if ($this->isHttpException($exception)) {
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
