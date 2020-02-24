@extends('mado.admin.lixil.template')

@if ('admin.lixil.shop.complete' === \Route::currentRouteName())
    @section('title', '会員登録完了｜LIXIL簡易見積りシステム')
@elseif ('admin.lixil.shop.edit.complete' === \Route::currentRouteName())
    @section('title', '会員編集完了｜LIXIL簡易見積りシステム')
@endif

@section('main')
<main class="common shopComplete">
    <h1 class="mainTtl">
        @if ('admin.lixil.shop.complete' === \Route::currentRouteName())
            会員登録完了
        @elseif ('admin.lixil.shop.edit.complete' === \Route::currentRouteName())
            会員編集完了
        @endif
    </h1>

    <h2>会員の登録を完了しました</h2>

    <table class="formTbl">
        <tr>
            <th>会社名</th>
            <td>{{ $shop->{config('const.db.shops.NAME')} }}</td>
        </tr>
        <tr>
            <th>プラン</th>
            <td>{{ $shop->shopClass->{config('const.db.shop_classes.NAME')} }}プラン</td>
        </tr>
        <tr>
            <th>ログインID</th>
            <td>{{ $shop->user->{config('const.db.users.LOGIN_ID')} }}</td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td>{{ $shop->user->getDecryptedPassword() }}</td>
        </tr>
            <!-- プレビュー時のみ表示 -->
        @if ($shop->isStandardPreview())
            <tr>
                <th>プレビューURL</th>
                <td>
                    <p class="mb10"><a href="{{ $shop->siteUrl() }}" target="_blank">{{ $shop->siteUrl() }}</a></p>
                    <p>Basic認証は以下となります。<br>ID：{{ config('app.basic_authentication_id') }}<br>Pass：{{ config('app.basic_authentication_password') }}</p>
                </td>
            </tr>
        @endif
    </table>

    @if ('admin.lixil.shop.complete' === \Route::currentRouteName())
        <p>プレミアムの場合は、必ずサイトへリンクが正しく設定されているかを確認してください。</p>
    @endif

    <div class="btnBlock">
        <p><a href="{{ route('admin.lixil.shop') }}" class="button _submit">戻る</a></p>
    </div>
</main>

@endsection
