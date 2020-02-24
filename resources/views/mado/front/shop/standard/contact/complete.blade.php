@extends('mado.front.shop.standard.template')

@section('title', "お問い合わせ完了｜{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")
@section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」のお問い合わせ完了ページです。")

@section('main')
<main id="mainArea" class="contact _complete">
    @include('mado.front.shop.standard.parts.header')

    <article>
        @include ('mado.front.parts.breadcrumbs')
        <h1>お問い合わせ完了</h1>
        <h2>お問い合わせありがとうございます</h2>
        <p class="completeTxt">ご記入いただいた内容は、確認のため折り返しお客さまへメールをお送りしております。<br>
        後日、担当者より選択いただいた連絡方法にて、お返事させていただきますので、今しばらくお待ちください。</p>

        <div class="btnBlock">
            <a href="{{ route('front.shop.standard', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}" class="submitBtn _back">TOPに戻る</a>
        </div>
    </article>
</main>
@endsection
