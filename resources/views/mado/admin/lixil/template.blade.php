@extends('mado.template')

@section('title', 'LIXIL Administrator')

@section('head')
<meta name="description" content="">
<meta name="keywords" content="">
<link rel="stylesheet" href="{{ asset('common/css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<meta name="robots" content="noindex,nofollow" >
{{-- TinyMCEの読み込み --}}
{{-- TinyMCEの読み込みは使用箇所の前でなければいけない --}}
<script src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
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
<header>
    <div class="headerInr">
        <p class="logo">
            @if ( \Schema::hasColumn('shops', 'shop_type') === false ) {{--portal--}}
            <a href="{{ route('admin.lixil') }}"><img src="{{ asset('img/header_logo.png') }}" alt="LIXIL administrator" width="183" height="31"></a>
            @else {{--general--}}
            <a href="{{ route('admin.lixil') }}"><img src="{{ asset('estimate/img/icon/h_logo.png') }}" alt="LIXIL administrator" width="124" height="67"></a>
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
