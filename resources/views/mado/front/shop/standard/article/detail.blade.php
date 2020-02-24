@extends('mado.front.shop.standard.template')

@if('front.shop.standard.blog' === \Route::currentRouteName())
    @section('title', "｜現場ブログ｜{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")
    @section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」の現場ブログページです。")
@elseif('front.shop.standard.event' === \Route::currentRouteName())
    @section('title', "｜イベントキャンペーン｜{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")
    @section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」のイベントキャンペーンページです。")
@endif

@section('head')
    @parent
@endsection

@section('main')
<main id="mainArea" class="blog _detail">
    @include('mado.front.shop.standard.parts.header')

    <article>
        @include ('mado.front.parts.breadcrumbs')

        <div class="ttlBlock">
            <h1>{{ $standardArticle->{config('const.db.standard_articles.TITLE')} }}</h1>
            <p class="date">{{ $standardArticle->getPublishedDate() }}</p>
        </div>

        <div class="blogArea">
            {!! $standardArticle->{config('const.db.standard_articles.TEXT')} !!}
        </div>

        @include ('mado.front.shop.standard.parts.shop_contact')

        @include ('mado.front.shop.standard.parts.shop_guide')
    </article>
</main>
@endsection
