@extends('mado.front.template')

@section('title', $title)
@section('description', $description)

@section('frontcss')
<link rel="stylesheet" href="{{ asset('/page_asset/css/' . $css_name) }}">
@endsection

@section('main')
<main id="mainArea" class="common_contents">
    {{-- 共通コンテンツのインクルード --}}
    @include($blade_path)

    {{-- サイドナビ --}}
    @if(View::exists($side_navi_path))
        @include($side_navi_path)
    @endif
    
</main>

@endsection
