@extends('mado.template')

@section('title', '簡易見積りシステム 管理画面')

@section('head')
<meta name="description" content="">
<meta name="keywords" content="">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('common/css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">


<link rel="stylesheet" href="{{ asset('css/users.css') }}">
<script src="{{ asset('js/jquery-2.2.4.min.js') }}"></script>
<meta name="robots" content="noindex,nofollow" >
{{-- TinyMCEの読み込み --}}
{{-- TinyMCEの読み込みは使用箇所の前でなければいけない --}}

@if ( \Schema::hasColumn('shops', 'shop_type') !== false ) {{--general--}}
<style>

    @media (max-width: 768px) {
        .headerInr {
            padding-left: 10px;
        }

    }
    header .headerInr:after {
        background: transparent !important;
    }
    a.disabled {
        background: #c6c8ca!important;
        cursor: no-drop;
    }
</style>
@endif
@endsection

@section('body')
<body>
@endsection

@section('header')
<!-- header -->

@if(Auth::user()->isAdmin())
<header>
    <div class="headerInr">
        <p class="logo">
            @if ( \Schema::hasColumn('shops', 'shop_type') === false ) {{--portal--}}
            <a class="rendect-page" data-href="{{ route('admin.lixil') }}"><img src="{{ asset('img/header_logo.png') }}" alt="simple estimation system" width="183" height="31"></a>
            @else {{--general--}}
            <a class="rendect-page" data-href="{{ route('admin.lixil') }}"><img src="{{ asset('estimate/img/icon/h_logo.png') }}" alt="simple estimation system" width="124" height="67"></a>
            @endif
        </p>
        <p class="name red">LIXIL administrator</p>
        <p class="logout"><a href="{{ route('admin.lixil.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></p>

        {!! Form::open([
            'id' => 'logout-form',
            'route' => 'admin.lixil.logout',
            'style' => 'display: none;',
        ]) !!}
        {!! Form::close() !!}
    </div>
</header>
@endif
@if(!Auth::user()->isAdmin())
<header>
    <div class="headerInr">
        <p class="logo">
            @if ( \Schema::hasColumn('shops', 'shop_type') === false ) {{--portal--}}
            <a class="rendect-page" data-href="{{ route('admin.shop', ['shop_id' => Auth::user()->shop->id]) }}"><img src="{{ asset('img/header_logo.png') }}" alt="simple estimation system" width="183" height="31"></a>
            @else {{--general--}}
            <a class="rendect-page" data-href="{{ route('admin.shop', ['shop_id' => Auth::user()->shop->id]) }}"><img src="{{ asset('estimate/img/icon/h_logo.png') }}" alt="LIXIL administrator" width="124" height="67"></a>
            @endif
        </p>
        <!-- <p class="name">{{ Auth::user()->shop->{config('const.db.shops.NAME')} }}</p> -->
        <p class="name red">Management</p>
        <p class="logout"><a href="{{ route('admin.shop.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></p>

        {!! Form::open([
            'id' => 'logout-form',
            'route' => 'admin.shop.logout',
            'style' => 'display: none;',
        ]) !!}
        {!! Form::close() !!}
    </div>
</header>
@endif
<!-- /header/ -->
@endsection

@section('footer')
<!-- footer -->
<footer>
    <img src="{{ asset('img/footer_img.png') }}" alt="Copyright C LIXIL Corporation. All Rights Reserved." width="1000" height="32">
</footer>
<!-- /footer/ -->
@endsection

@section('script')
<script src="{{asset('js/app.js')}}" ></script>
@endsection
