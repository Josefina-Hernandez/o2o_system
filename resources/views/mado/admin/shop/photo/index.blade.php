@extends('mado.admin.shop.template')

@section('title', '施工事例管理｜LIXIL簡易見積りシステム')

@section('main')
<main class="common">
    <h1 class="mainTtl">施工事例管理</h1>
    <p class="mb30">施工事例登録は、開口部リフォーム専門店として、窓・ドア・エクステリアの写真を中心に掲載しましょう！</p>
    <p class="mb30"><a href="{{ route('admin.shop.photo.new', ['shop_id' => $shop->{config('const.db.shops.ID')}]) }}" class="button">施工事例新規登録</a></p>


    <div id="confirm-dialog">
        {!! Form::open([
            'route' => ['admin.shop.news', 'shop_id' => $shop->{config('const.db.shops.SHOP_ID')}],
            'v-on:submit.prevent' => 'onSubmit'
        ]) !!}

        <table class="defaultTbl">
            <thead>
                <tr>
                    <th>投稿年月日</th>
                    <th>タイトル</th>
                    <th>概要</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($standardPhotos as $standardPhoto)
                    <tr>
                        <td width="100">{{ $standardPhoto->getCreatedDate() }}</td>
                        <td>{{ $standardPhoto->{config('const.db.standard_photos.TITLE')} }}</td>
                        <td>{{ $standardPhoto->{config('const.db.standard_photos.SUMMARY')} }}</td>
                        <td class="btnCell clearfix">
                            <p><a href="{{ route('admin.shop.photo.edit', ['shop_id' => $shop->{config('const.db.shops.ID')}, 'photo_id' => $standardPhoto->{config('const.db.standard_photos.ID')}]) }}" class="button _edit">編集</a></p>
                            <p><confirm-dialog
                                action="{{ route('admin.shop.photo.delete', ['shop_id' => $standardPhoto->{config('const.db.standard_notices.SHOP_ID')}, 'photo_id' => $standardPhoto->{config('const.db.standard_photos.ID')}]) }}"
                                message="{{ '以下の施工事例を削除します。' . "\n"
                                    . '削除してよければ「OK」ボタンを押してください。' . "\n"
                                    . $standardPhoto->getCreatedDate() . "\n"
                                    . $standardPhoto->{config('const.db.standard_photos.TITLE')} }}"></confirm-dialog>
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {!! Form::close() !!}
    </div>

    {{ $standardPhotos->links() }}

</main>
@endsection
