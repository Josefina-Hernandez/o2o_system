@extends('mado.template')

@section('title', 'LIXIL簡易見積りシステム')

@section('frontcss')
<link rel="stylesheet" href="{{ asset('/common/css/owl.carousel.css') }}">
<link rel="stylesheet" href="{{ asset('/css/top.css') }}">
@endsection

@section('head')
<meta name="description" content="@yield('description')">
<meta name="keywords" content="@yield('keywords')">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="format-detection" content="telephone=no">
@if(app()->isLocal())
<meta name="robots" content="noindex,nofollow">
@endif
{{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/common/img/favicon.ico') }}"> --}}
<link rel="stylesheet" href="{{ asset('/common/css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('/common/css/common.css') }}">
<link rel="stylesheet" href="{{ asset('/common/css/colorbox.css') }}">
@yield('frontcss')
<script src="{{ asset('/common/js/jquery.js') }}"></script>
<script src="{{ asset('/common/js/common.js') }}"></script>
<script src="{{ asset('/common/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('/common/js/jquery.colorbox-min.js') }}"></script>
@endsection

@section('body')
<body>
@endsection

@section('header')
<!-- header -->
<header>
    <div class="headerInr">
        <h1 class="logo"><a href="{{ route('front') }}"><img src="{{ asset('/common/img/header_logo.png') }}" alt="LIXIL簡易見積りシステム" width="237"></a></h1>
        <div class="flexBlock pconly">
            {!! Form::open() !!}
                {{-- <div class="searchBox">
                    <input type="text" name="" placeholder="サイト内検索">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div> --}}
            {!! Form::close() !!}
            <p class="contactBtn">
                <!-- @if (0 === strncmp(\Route::currentRouteName(), 'front.shop.standard', mb_strlen('front.shop.standard')))
                    {{-- 加盟店の場合は加盟店のお問い合わせにリンクする --}}
                    <a href="{{ route('front.shop.standard.contact', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}">お問い合わせ</a>
                @else
                    {{-- //@TODO: 20190424: 一時的に非表示にする --}}
                    {{-- その他の場合はLIXILのお問い合わせにリンクする --}}
                    {{-- <a href="{{ route('front.contact') }}">お問い合わせ</a> --}}
                @endif -->
            </p>
        </div>
        <div class="flexBlock sponly">
            <p class="shopBtn"><a href="{{ route('front.shop.search.keyword') }}"><i class="fas fa-search"></i><br>店舗検索</a></p>
            <button class="menuBtn"><i class="fas fa-bars"></i></button>
        </div>
    </div>

    {{-- グロナビ --}}
    <nav id="glonav">
        <ul>
            <li class="navTop">
                <p><a href="{{ route('front') }}">トップ</a></p>
            </li>
            <li class="downList">
                <p><a href="/page/about/index">「LIXIL簡易見積りシステム」とは</a></p>
                <div class="slidedown">
                    <ul>
                        <li><a href="/page/about/service">ここがちがうLIXIL簡易見積りシステムのサービスの流れ</a></li>
                        <li><a href="/page/about/zero">不安0宣言</a></li>
                        <li><a href="/page/about/meister">マイスター制度</a></li>
                        <!--li><a href="/page/about/calender">住まいの<br>メンテナンスカレンダー</a></li-->
                        <li><a href="/page/about/diagnosis">窓診断の流れ</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <p><a href="{{ route('front.shop.search.keyword') }}">ショップを探す</a></p>
            </li>
            <li>
                <p><a href="{{ route('front.shop.photo') }}">全国の施工事例</a></p>
            </li>
            <li class="sponly">
                <p><a href="/page/beginner/index">初めての方へ</a></p>
            </li>
            <li>
                <p><a href="/page/problem/index">お悩み改善提案</a></p>
            </li>
            <li>
                <p><a href="/page/column/index">お役立ちコラム</a></p>
            </li>
            <li class="sponly">
                <p><a href="/page/knowledge/index">知って得する窓・ドアの基本知識</a></p>
            </li>
            <li>
                <p><a href="/page/recommend/index">おすすめ<br class="pconly">簡単リフォーム商品</a></p>
            </li>
            <li class="sponly">
                <p>
                    @if (0 === strncmp(\Route::currentRouteName(), 'front.shop.standard', mb_strlen('front.shop.standard')))
                        {{-- 加盟店の場合は加盟店のお問い合わせにリンクする --}}
                        <a href="{{ route('front.shop.standard.contact', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}">お問い合わせ</a>
                    @else
                        {{-- //@TODO: 20190424: 一時的に非表示にする --}}
                        {{-- その他の場合はLIXILのお問い合わせにリンクする --}}
                        {{-- <a href="{{ route('front.contact') }}">お問い合わせ</a> --}}
                    @endif
                </p>
            </li>
        </ul>
        {{-- //@TODO: 20190424: 一時的に非表示する --}}
        {{-- <div class="searchBox sponly">
            {!! Form::open() !!}
                <input type="text" name="" placeholder="サイト内検索">
                <button type="submit"><i class="fas fa-search"></i></button>
            {!! Form::close() !!}
        </div> --}}
    </nav>
    {{-- /グロナビ --}}

    <p class="sideBtn"><a href="{{ route('front.shop.search.keyword') }}"><img src="{{ asset('/common/img/btn_side_store.png') }}" alt="店舗を探す" width="60"></a></p>
</header>
<!-- /header/ -->
@endsection

@section('footer')
<!-- footer -->
<footer>
    <div class="footerInr">
        <nav class="footerNav">
            <p class="shopNav"><a href="{{ route('front.shop.search.keyword') }}">ショップを探す</a></p>
            <ul class="footerNavList _main clearfix">
                <li>
                    <p><a href="/page/about/index">「LIXIL簡易見積りシステム」とは</a></p>
                    <ul class="lowerNavList">
                        <li><a href="/page/about/service">ここがちがうLIXIL簡易見積りシステムのサービスの流れ</a></li>
                        <li><a href="/page/about/zero">不安0宣言</a></li>
                        <li><a href="/page/about/meister">マイスター制度</a></li>
                        <!--li><a href="/page/about/calender">住まいのメンテナンスカレンダー</a></li-->
                        <li><a href="/page/about/diagnosis">窓診断の流れ</a></li>
                    </ul>
                </li>
                <li class="pconly"><a href="{{ route('front.shop.search.keyword') }}">ショップを探す</a></li>
                <li><a href="{{ route('front.shop.photo') }}">全国の施工事例</a></li>
                <li><a href="{{ route('front.shop.search.modal.estimate') }}" class="shopmodal">見積りシミュレーション</a></li>
                <li><a href="/page/beginner/index">初めての方へ</a></li>
                <li><a href="/page/problem/index">お悩み改善提案</a></li>
                <li><a href="/page/column/index">お役立ちコラム</a></li>
                <li><a href="/page/knowledge/index">知って得する窓・ドアの<br class="sponly">基本知識</a></li>
                <li><a href="/page/housingpoint">次世代住宅ポイント制度</a></li>
                <li><a href="{{ route('front.news') }}">お知らせ</a></li>
                <li><a href="/page/recommend/index">おすすめ<br class="sponly">簡単リフォーム商品</a></li>
            </ul>
        </nav>
        <ul class="footerNavList _sub">
            {{-- //@TODO: 20190424: 一時的に非表示にする --}}
            {{-- <li><a href="{{ route('front.contact') }}">お問い合わせ</a></li> --}}
            <li><a href="{{ route('front.privacy') }}">プライバシーポリシー</a></li>
            <li><a href="https://www.lixil.co.jp/termsofuse/" target="_blank">サイト利用条件</a></li>
            <li><a href="{{ route('front.sitemap') }}">サイトマップ</a></li>
        </ul>
        <ul class="note">
            <li>［LIXIL簡易見積りシステム］は株式会社LIXILが提供する<br class="sponly">リフォームサービスの名称です。</li>
            <li>LIXIL簡易見積りシステムの各店舗と株式会社LIXILとは、<br class="sponly">資本提携のない別法人です（一部店舗を除く）。</li>
            <li>リフォームの工事請負契約はお客さまとLIXIL簡易見積りシステムの<br class="sponly">各店舗との間でおこなわれます。</li>
        </ul>
    </div>
    <small class="copy">Copyright &copy; LIXIL簡易見積りシステム. All Rights Reserved.</small>
</footer>
<!-- /footer/ -->
@endsection

@section('script')
@endsection
