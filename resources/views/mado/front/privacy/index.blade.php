@extends('mado.front.shop.standard.template')

@section('title', 'LIXIL簡易見積りシステム プライバシーポリシー｜LIXIL簡易見積りシステム')

@section('description', 'LIXIL簡易見積りシステムサイトのプライバシーポリシーです。LIXIL簡易見積りシステムは、窓とドアの専門店として、住まいの内と外をつなぐリフォームを通じて、豊かで心地よい空間創りをしてまいります。')

@section('frontcss')
    <link rel="stylesheet" href="{{ asset('css/privacy.css') }}">
@endsection

@section('main')
<main id="mainArea" class="privacy">
    <article>
        @include ('mado.front.parts.breadcrumbs')

        <h1>LIXIL簡易見積りシステム プライバシーポリシー</h1>
        <div class="privacyBox">
        <!-- ここからblade -->
            @include ('mado.static.contact_privacy_policy')
        <!-- ここまでblade -->
        </div>
    </article>
</main>
@endsection
