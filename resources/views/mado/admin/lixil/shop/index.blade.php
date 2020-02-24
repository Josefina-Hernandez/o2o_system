@extends('mado.admin.lixil.template')

@if('admin.lixil.shop' === \Route::currentRouteName())
    @section('title', '会員一覧｜LIXIL簡易見積りシステム')
@elseif('admin.lixil.shop.search' === \Route::currentRouteName())
    @section('title', '会員検索｜LIXIL簡易見積りシステム')
@endif

@section('main')
<main class="common">
    <h1 class="mainTtl">
        @if('admin.lixil.shop' === \Route::currentRouteName())
            会員一覧
        @elseif('admin.lixil.shop.search' === \Route::currentRouteName())
            会員検索
        @endif
    </h1>

    {!! Form::open([
        'route' => ('admin.lixil.shop.search'),
        'method' => 'get',
    ]) !!}
    <section class="searchIndex">
        <h2>検索</h2>
        <div class="searchTxt">
            <p>
                {!! Form::text(config('const.form.common.SEARCH_KEYWORDS'), '', []) !!}
            </p>
            <p class="note mb0">※住所、会社名、電話番号から検索可能です</p>
        </div>
        <ul class="searchCheck">
            <li>
                {!! Form::checkbox(config('const.form.common.PREMIUM'), config('const.form.common.CHECKED'), false, [
                'id' => config('const.form.common.PREMIUM'),
            ]) !!}
                {!! Form::label(config('const.form.common.PREMIUM'), 'プレミアム', []) !!}
            </li>
            <li>
                {!! Form::checkbox(config('const.form.common.STANDARD'), config('const.form.common.CHECKED'), false, [
                'id' => config('const.form.common.STANDARD'),
            ]) !!}
                {!! Form::label(config('const.form.common.STANDARD'), 'スタンダード', []) !!}
            </li>
        </ul>
        <div class="searchSubmit">
            <p>
                {!! Form::submit('検索', ['class' => 'button _submit']) !!}
            </p>
        </div>
    </section>
    {!! Form::close() !!}

    <div id="confirm-dialog">
        {!! Form::open([
            'v-on:submit.prevent' => 'onSubmit'
        ]) !!}

        <table class="defaultTbl">
            <thead>
                <tr>
                    <th>店名</th>
                    <th>住所</th>
                    <th>電話番号</th>
                    <th>プラン</th>
                    <th>公開ステータス</th>
                    <th>サイト</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shops as $shop)
                    <tr>
                        <td>{{ $shop->{config('const.db.shops.NAME')} }}</td>
                        <td>{{ $shop->address() }}</td>
                        <td>{{ $shop->{config('const.db.shops.TEL')} }}</td>
                        <td>{{ $shop->shopClass->{config('const.db.shop_classes.NAME')} }}</td>
                        <td>{{ $shop->publishStatus() }}</td>
                        <td><a href="{{ $shop->siteUrl() }}" target="_blank">{{ $shop->sitePath() }}</a></td>
                        <td class="btnCell clearfix">
                            <p><a href="{{ route('admin.lixil.shop.edit', ['shop_id' => $shop->{config('const.db.shops.ID')}]) }}" class="button _edit">編集</a></p>
                            <p><confirm-dialog
                                 action="{{ route('admin.lixil.shop.delete', ['shop_id' => $shop->{config('const.db.shops.ID')}]) }}"
                                 message="{{ '以下の会員を削除します。' . "\n"
                                        . '削除してよければ「OK」ボタンを押してください。' . "\n"
                                        . $shop->{config('const.db.shops.NAME')} . "\n"
                                        . $shop->address() }}"></confirm-dialog></p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {!! Form::close() !!}
    </div>


    @if ('admin.lixil.shop' === \Route::currentRouteName())
        {{ $shops->links() }}
    @elseif ('admin.lixil.shop.search' === \Route::currentRouteName())
        {{ $shops->appends($queryParams)->links() }}
    @endif
</main>
@endsection
