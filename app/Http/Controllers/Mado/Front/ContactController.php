<?php

namespace App\Http\Controllers\Mado\Front;

use App\Facades\MadoLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mado\Front\ContactRequest;
use App\Mail\LixilContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        return view('mado.front.contact.index');
    }

    public function confirm(ContactRequest $request)
    {
        return view('mado.front.contact.confirm', [
            'data' => $request->all(),
        ]);
    }

    public function complete(ContactRequest $request)
    {
        // 入力データを取得
        $data = $request->all();

        // メール送信: LIXIL管理者、お問い合わせ者
        try {
            Mail::to(config('mail.from.address'))
                ->queue(new LixilContact($request->all()));
            MadoLog::info('Fs001 LIXILへのお問い合わせ処理中、LIXILへのメールのキューイングを完了しました。', ['to' => config('mail.from.address')]);
        } catch (\Exception $e) {
            MadoLog::error('Ff001 LIXILへのお問い合わせ処理中、LIXILへのメールのキューイングを失敗しました。', ['to' => config('mail.from.address'), 'error' => $e->getMessage()]);
            throw $e;
        }
        sleep(0.5);
        try {
            Mail::to($data[config('const.form.front.standard.contact.EMAIL')])
                ->queue(new LixilContact($request->all()));
            MadoLog::info('Fs002 LIXILへのお問い合わせ処理中、お問い合わせ者へのメールのキューイングを完了しました。', ['to' => $data[config('const.form.front.standard.contact.EMAIL')]]);
        } catch (\Exception $e) {
            MadoLog::error('Ff002 LIXILへのお問い合わせ処理中、お問い合わせ者へのメールのキューイングを失敗しました。', ['to' => $data[config('const.form.front.standard.contact.EMAIL')], 'error' => $e->getMessage()]);
            throw $e;
        }

        // トークンをリフレッシュする
        $request->session()->regenerateToken();

        return view('mado.front.contact.complete');
    }
}
