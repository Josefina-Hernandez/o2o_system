<?php

namespace App\Http\Middleware\Tostem\Front;

use Closure;

class CheckSessionNewOrReform
{
    const SS_NEW_OR_REFORM = 'new_or_reform';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url_path = str_replace('tostem.front.', '', $request->route()->getName());
        $url_path_except = ['index', 'quotation_system'];
        $url_path_accept = ['check_session_new_or_reform', 'check_session_new_or_reform.generate'];
        $ss_new_or_reform = \Session::get(CheckSessionNewOrReform::SS_NEW_OR_REFORM);
        $vali_new_or_reform = ['0', '1'];

        if ($request->ajax()) {
            if ($request->method() === 'GET') {
                if (in_array($url_path, $url_path_accept) && !in_array((string) $ss_new_or_reform, $vali_new_or_reform)) {
                    return response()->json([
                        'status' => 'session_error',
                        'msg' => ''
                    ]);
                }
            } else {
                $status = $request->status;
                if (in_array($url_path, $url_path_accept) && in_array((string) $status, $vali_new_or_reform)) {
                    \Session::put(CheckSessionNewOrReform::SS_NEW_OR_REFORM, (int) $status);
                    return response()->json([
                        'status' => 'session_success',
                        'msg' => ''
                    ]);
                }
            }
    	} else {
            if (!in_array($url_path, $url_path_except) && !in_array((string) $ss_new_or_reform, $vali_new_or_reform)) {
                return redirect()->route('tostem.front.index');
            }
        }
        return $next($request);
    }
}
