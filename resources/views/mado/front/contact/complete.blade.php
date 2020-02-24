@extends('mado.front.template')

@section('title', 'お問い合わせ｜LIXIL簡易見積りシステム')

@section('frontcss')
<link rel="stylesheet" href="{{ asset('/css/shop.css') }}">
@endsection

@section('main')
<main id="mainArea" class="contact _complete">
    <article>
        @include ('mado.front.parts.breadcrumbs')
        <h1>お問い合わせ完了</h1>
        <h2>お問い合わせありがとうございます</h2>
        <p class="completeTxt">ご記入いただいた内容は、確認のため折り返しお客さまへメールをお送りしております。<br>
        後日、担当者より選択いただいた連絡方法にて、お返事させていただきますので、今しばらくお待ちください。</p>

        <div class="btnBlock">
            <a href="{{ route('front') }}" class="submitBtn _back">TOPに戻る</a>
        </div>
    </article>
</main>
@endsection
