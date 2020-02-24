@extends('mado.admin.shop.template')

@section('title', 'お知らせ管理｜LIXIL簡易見積りシステム')

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @parent
@endsection

@section('main')
<main class="common">
    <h1 class="mainTtl">お知らせ管理</h1>

    @include ('mado.admin.parts.notice_message')

    <h2 class="subTtl">新規登録・編集</h2>
    <p class="note">お知らせを新規に登録する場合は、下記に年月日と内容を記載してください。<br>
    登録済みのお知らせを変更したい場合は、下のお知らせ一覧の編集ボタンを押すと、下記にお知らせの内容が表示されますので、内容を変更した後に登録ボタンを押してください。</p>

    {!! Form::model($standardNotice, [
        'route' => ['admin.shop.news.register', 'shop_id' => $standardNotice->{config('const.db.standard_notices.SHOP_ID')}],
    ]) !!}
    {!! Form::hidden(config('const.db.standard_notices.ID')) !!}
    <table class="formTbl">
        <tbody>
            <tr>
                <th>年月日 <span class="require">※</span></th>
                <td colspan="2">
                    {!! Form::text(
                        config('const.db.standard_notices.PUBLISHED_AT'),
                        null,
                        [
                            'id' => 'timepicker',
                            'class' => 'w150',
                        ]
                    ) !!}
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_notices.PUBLISHED_AT')) }}</p>
                </td>
            </tr>
            <tr>
                <th>内容 <span class="require">※</span></th>
                <td>
                    {!! Form::text(
                        config('const.db.standard_notices.TEXT'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_notices.TEXT')) }}</p>
                </td>
                <td class="btnCell clearfix" width="50">
                    <p>
                        {!! Form::submit('登録', [
                            'class' => 'button _edit',
                            'style' => 'width: 60px;'
                        ]) !!}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    {!! Form::close() !!}

    <h2 class="subTtl">お知らせ一覧</h2>
    <div id="confirm-dialog">
    {!! Form::open([
        'route' => ['admin.shop.news', 'shop_id' => $standardNotice->{config('const.db.standard_notices.SHOP_ID')}],
        'v-on:submit.prevent' => 'onSubmit'
    ]) !!}
    <table class="defaultTbl">
        <tbody>
            @foreach ($standardNoticesList as $standardNotice)
                <tr>
                    <td width="100">{{ $standardNotice->getPublishedDate() }}</td>
                    <td>{{ $standardNotice->{config('const.db.standard_notices.TEXT')} }}</td>
                    <td class="btnCell clearfix">
                        <p><a href="{{ route('admin.shop.news.edit', ['shop_id' => $standardNotice->{config('const.db.standard_notices.SHOP_ID')}, 'notice_id' => $standardNotice->{config('const.db.standard_notices.ID')}]) }}" class="button _edit">編集</a> </p>
                        <p>
                            <confirm-dialog
                            action="{{ route('admin.shop.news.delete', ['shop_id' => $standardNotice->{config('const.db.standard_notices.SHOP_ID')}, 'notice_id' => $standardNotice->{config('const.db.standard_notices.ID')}]) }}"
                            message="{{ '以下のお知らせを削除します。' . "\n"
                                    . '削除してよければ「OK」ボタンを押してください。' . "\n"
                                    . $standardNotice->getPublishedDate() . "\n"
                                    . $standardNotice->{config('const.db.standard_notices.TEXT')} }}"></confirm-dialog>
                        </p>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! Form::close() !!}
    </div>
</main>
@endsection

@section('script')
    {{-- timepicker --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript">
        flatpickr('#timepicker', {
            time_24hr: true,
        });
    </script>

    @parent
@endsection
