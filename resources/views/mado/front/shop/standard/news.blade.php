@extends('mado.front.shop.standard.template')

@section('title', "お知らせ一覧｜{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")

@section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」のお知らせ一覧ページです。")

@section('main')
<main id="mainArea" class="news">
    @include('mado.front.shop.standard.parts.header')

    <article>
        @include ('mado.front.parts.breadcrumbs')
        <h1>お知らせ</h1>

        <div class="newsWrap">
            @if ($standardNotices->isEmpty())
                準備中です
            @else
                <ul class="newsList">
                    @foreach ($standardNotices as $notice)
                        <li>
                            <dl>
                                <dt>{{ $notice->getPublishedDate() }}</dt>
                                <dd>{{ $notice->{config('const.db.standard_notices.TEXT')} }}</dd>
                            </dl>
                        </li>
                    @endforeach
                </ul>

                {{ $standardNotices->links() }}
            @endif
        </div>

        @include ('mado.front.shop.standard.parts.shop_contact')

        @include ('mado.front.shop.standard.parts.shop_guide')
    </article>
</main>
@endsection
