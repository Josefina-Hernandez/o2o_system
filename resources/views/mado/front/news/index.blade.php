@extends('mado.front.template')

@section('title', 'LIXILからのお知らせ｜LIXIL簡易見積りシステム')

@section('description', 'LIXIL簡易見積りシステムのお知らせ一覧ページです。LIXIL簡易見積りシステムは、窓とドアの専門店として、住まいの内と外をつなぐリフォームを通じて、豊かで心地よい空間創りをしてまいります。')

@section('frontcss')
    <link rel="stylesheet" href="{{ asset('css/news.css') }}">
@endsection

@section('main')

<main id="mainArea" class="news">
    <article>
        @include ('mado.static.news')
    </article>
</main>

@endsection
