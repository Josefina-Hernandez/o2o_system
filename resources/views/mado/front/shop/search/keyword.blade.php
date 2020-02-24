@extends('mado.front.template')

@section('title', '店舗検索｜LIXIL簡易見積りシステム')

@section('description', 'LIXIL簡易見積りシステムのサービスを取り扱う加盟店舗の検索結果一覧です。')

@section('frontcss')
<link rel="stylesheet" href="{{ asset('/css/search.css') }}">
@endsection

@section('main')
<main id="mainArea" class="search">
    <article>
        @include ('mado.front.parts.breadcrumbs')

        <div class="ttlBlock">
            <h1>
                @empty ($keywords)
                    LIXIL簡易見積りシステム一覧
                @else
                    「{{ $keywords }}」のLIXIL簡易見積りシステム一覧
                @endempty
            </h1>
        </div>

        {!! Form::open([
            'route' => ('front.shop.search.keyword'),
            'method' => 'get',
        ]) !!}
        <div class="searchBox">
            <dl class="purpose">
                <dt><i class="fas fa-search"></i>目的で絞り込む</dt>
                <dd>
                    <ul class="checkList">
                        @foreach (config('const.form.admin.shop.SUPPORT_DETAIL_LIST') as $value => $label)
                        <li>
                            <label>
                                {!! Form::checkbox(
                                    config('const.form.common.DETAIL') . '_' . $value,
                                    config('const.form.common.CHECKED'),
                                    null,
                                    [
                                        'id' => config('const.form.common.DETAIL') . '_' . $value,
                                    ]
                                ) !!}
                                {{ $label }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </dd>
            </dl>

            <dl class="word">
                <dt><i class="fas fa-search"></i>検索ワードで絞り込む</dt>
                <dd>
                    {!! Form::text(config('const.form.common.SEARCH_KEYWORDS'), $keywords, [
                        'placeholder' => '地域・その他の検索ワードを入れてください',
                    ]) !!}
                </dd>
            </dl>
            <button type="submit" class="searchBtn">検索</button>
        </div>
        {!! Form::close() !!}

        <div class="searchWrap">
            @if ($shops->isEmpty())
                <p class="img100"><img src="{{ ('/img/notfound.png') }}" alt="検索結果0件　該当するページは見つかりませんでした"></p>
            @else
                <!-- <p class="numberTxt">{{ $shops->total() }}ショップが該当しました</p> -->

                <ul class="searchList">
                    @foreach ($prefs as $pref)
                        {{-- 都道府県名 (件数) --}}
                        <!-- {{ $pref->name }}({{ array_get($countShopsInPref, $pref->id) }}件) -->
                        {{-- 都道府県に属するショップ一覧 --}}
                        @foreach (array_get($shopsByPref, $pref->code) as $shop)
                            @include ('mado.front.parts.shop_list')
                        @endforeach
                    @endforeach
                </ul>

                {{ $shops->appends($queryParams)->links() }}
            @endif
        </div>
    </article>
</main>
@endsection
