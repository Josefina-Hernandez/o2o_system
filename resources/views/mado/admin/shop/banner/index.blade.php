@extends('mado.admin.shop.template')

@section('title', 'バナー管理｜LIXIL簡易見積りシステム')

@section('main')
<main class="common staff">
    <h1 class="mainTtl">バナー管理</h1>

    {{-- 通知メッセージ --}}
    @include ('mado.admin.parts.notice_message')

    <p>バナー画像は横幅270px × 高さ120pxのサイズで投稿して下さい。</p>
    <p class="mb30">バナーの削除は、クリアボタンを押して登録情報を空にした状態で登録ボタンを押してください。</p>

    <div id="clear-banner">
    {!! Form::open([
        'route' => ['admin.shop.banner.edit', 'shop_id' => Request::route('shop_id')],
        'enctype' => 'multipart/form-data',
    ]) !!}

    @foreach ($banners as $banner)
        <div class="staffCnt">
            <div class="staffTitle">
                <span>バナー{{ $banner->{config('const.db.banners.RANK')} }}</span>
                {!! Form::button('クリア', [
                    'id' => null,
                    'class' => 'button',
                    'v-on:click' => 'onClick($event, ' . $banner->{config('const.db.banners.RANK')} . ')',
                ]) !!}
            </div>
        </div>

        <table class="formTbl">
            <tr>
                <th>バナー画像</th>
                <td>
                    <file-upload name="{{ config('const.form.admin.shop.banner.PICTURE') . '_' . $banner->{config('const.db.banners.RANK')} }}" image="{{ $banner->imageUrl() }}" ref="{{ $banner->{config('const.db.banners.RANK')} }}" image-cls="shopImge" image-width="200" image-height="150"></file-upload>
                    <p class="errMsg">{{ $errors->first(config('const.form.admin.shop.banner.PICTURE') . '_' . $banner->{config('const.db.banners.RANK')}) }}</p>
                </td>
            </tr>
            <tr>
                <th>URL</th>
                <td>
                    <p>
                        {!! Form::text(
                            config('const.db.banners.URL') . '_' . $banner->{config('const.db.banners.RANK')},
                            old(config('const.db.banners.URL') . '_' . $banner->{config('const.db.banners.RANK')}, $banner->{config('const.db.banners.URL')}), [
                                'id' => null,
                                'class' => null,
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.banners.URL') . '_' . $banner->{config('const.db.banners.RANK')}) }}</p>
                </td>
            </tr>
        </table>
    @endforeach

    <div class="btnBlock">
        <p>{!! Form::submit('登録', ['class' => 'button _submit']) !!}</p>
    </div>

    {!! Form::close() !!}
    </div>
</main>
@endsection
