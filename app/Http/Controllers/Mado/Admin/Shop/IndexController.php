<?php

namespace App\Http\Controllers\Mado\Admin\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facades\NoticeMessage;

class IndexController extends Controller
{
    public function index($shop_id)
    {
        // 公開ステータスに応じてメッセージを表示する
        NoticeMessage::adminShop($shop_id);

        return view(
            'mado.admin.shop.index',
            [
            ]
        );
    }
}
