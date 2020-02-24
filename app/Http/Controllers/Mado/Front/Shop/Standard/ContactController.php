<?php

namespace App\Http\Controllers\Mado\Front\Shop\Standard;

use App\Facades\MadoLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mado\Front\ContactRequest;
use App\Mail\ShopContact;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShopContactToShop;
use App\Mail\ShopContactToCustomer;
use App\Repositories\BaseRepository; //Add Estimate Thanh 20190507
use App\Http\Controllers\Estimate\Front\HelpersCartController; //Add Estimate Thanh 20190507

class ContactController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request, $pref_code, $shop_code)
    {
		//Add Start Estimate Thanh 20190507
		$estimate_data = null; $e_data_type = 0;
		if ($request->isMethod('POST')) {
			if ($request->has('from_estimate') && $request->input('from_estimate') == 'cart'){
				$e_data_type = $request->input('type');
				$cart = new HelpersCartController();
				$estimate_data = $cart->get_content_mail($e_data_type,$pref_code,$shop_code);
			}
		}
		//Add End Estimate Thanh 20190507
		
        // ショップを取得
        $shop = Shop::code($shop_code)->prefCode($pref_code)->first();
        return view('mado.front.shop.standard.contact.index', [
            'shop' => $shop
			, 'estimate_data' => $estimate_data, 'e_data_type' => $e_data_type //Add Estimate Thanh 20190507
        ]);
    }

    public function confirm(ContactRequest $request, $pref_code, $shop_code)
    {
        // ショップを取得
        $shop = Shop::code($shop_code)->prefCode($pref_code)->first();

        return view('mado.front.shop.standard.contact.confirm', [
            'shop' => $shop,
            'data' => $request->all(),
        ]);
    }

    public function complete(ContactRequest $request, $pref_code, $shop_code)
    {
        // ショップを取得
        $shop = Shop::code($shop_code)->prefCode($pref_code)->first();

        // 入力データを取得
        $data = $request->all();

        // メール送信: 加盟店、お問い合わせ者
        try {
            Mail::to($shop->{config('const.db.shops.EMAIL')})
                ->queue(new ShopContactToShop($shop, $request->all()));
            MadoLog::info('Fs003 加盟店へのお問い合わせ処理中、加盟店へのメールのキューイングを完了しました。', ['to' => $shop->{config('const.db.shops.EMAIL')}]);
        } catch (\Exception $e) {
            MadoLog::error('Ff003 加盟店へのお問い合わせ処理中、加盟店へのメールのキューイングを失敗しました。', ['to' => $shop->{config('const.db.shops.EMAIL')}, 'error' => $e->getMessage()]);
            throw $e;
        }
        sleep(0.5);
        try {
            Mail::to($data[config('const.form.front.standard.contact.EMAIL')])
                ->queue(new ShopContactToCustomer($shop, $request->all()));
            MadoLog::info('Fs005 加盟店へのお問い合わせ処理中、お問い合わせ者へのメールのキューイングを完了しました。', ['to' => $data[config('const.form.front.standard.contact.EMAIL')]]);
        } catch (\Exception $e) {
            MadoLog::error('Ff005 加盟店へのお問い合わせ処理中、お問い合わせ者へのメールのキューイングを失敗しました。', ['to' => $data[config('const.form.front.standard.contact.EMAIL')], 'error' => $e->getMessage()]);
            throw $e;
        }
        
		//Add Start Estimate Thanh 20190507
		//delete session cart when send mail success
		$e_cart_helpers = new HelpersCartController();
		$e_base = new BaseRepository();
		if ($data['e_data_type'] == 'door' || $data['e_data_type'] == 'window' ) {
			$e_shop = $e_base->get_shop_id($pref_code, $shop_code);
			$e_cart_helpers->clear_cart($data['e_data_type'],$e_shop['id'] );
		}
		//Add End Estimate Thanh 20190507
		
        // トークンをリフレッシュする
        $request->session()->regenerateToken();

        return view('mado.front.shop.standard.contact.complete', [
            'shop' => $shop,
        ]);
    }
}
