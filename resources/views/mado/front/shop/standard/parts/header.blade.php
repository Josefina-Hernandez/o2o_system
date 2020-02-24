<header class="shopHead">
    <div class="headInr">
        <div class="shopttl">
            <p>LIXIL簡易見積りシステム</p>
            <h2 class="shopname">{{ $shop->{config('const.db.shops.NAME')} }}</h2>
        </div>
        <div class="consultBox">
            <p class="consultTtl">お見積り・ご相談・お問い合わせ等、無料で承ります。</p>
            <div class="flexBlock">
                <dl class="tel">
                    <dt>お電話でのお問い合わせ<br class="sponly">（営業時間内での受付）</dt>
                    <dd><a href="tel:{{ $shop->telWithoutHyphen() }}" class="telnum"><i class="fas fa-phone"></i>{{ $shop->{config('const.db.shops.TEL')} }}</a></dd>
                </dl>
                <p>
                    <a href="{{ route('front.shop.standard.contact', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/header_consultbtn_sp.png') }}">
                        <img src="{{ asset('img/header_consultbtn_pc.png') }}" width="140" alt="24時間受付中　無料相談">
                    </picture>
                    </a>
                </p>
            </div>
        </div>
    </div>
    <nav>
        <ul>
            <li @if ('front.shop.standard' === \Route::currentRouteName()) class="_cur" @endif><a href="{{ route('front.shop.standard', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}">店舗トップ</a></li>
            <li @if ('front.shop.standard.staff' === \Route::currentRouteName()) class="_cur" @endif><a href="{{ route('front.shop.standard.staff', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}">スタッフ紹介</a></li>
            <li @if (in_array(\Route::currentRouteName(), ['front.shop.standard.photo', 'front.shop.standard.photo.search', 'front.shop.standard.photo.detail'], true)) class="_cur" @endif><a href="{{ route('front.shop.standard.photo', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}">施工事例</a></li>
            <li @if (in_array(\Route::currentRouteName(), ['front.shop.standard.blog', 'front.shop.standard.blog.detail'])) class="_cur" @endif><a href="{{ route('front.shop.standard.blog', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}">現場ブログ</a></li>
            <li @if (in_array(\Route::currentRouteName(), ['front.shop.standard.event', 'front.shop.standard.event.detail'])) class="_cur" @endif><a href="{{ route('front.shop.standard.event', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}">イベントキャンペーン</a></li>
            <li @if ('front.shop.standard.news' === \Route::currentRouteName()) class="_cur" @endif><a href="{{ route('front.shop.standard.news', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}">お知らせ</a></li>
        </ul>
    </nav>
</header>
