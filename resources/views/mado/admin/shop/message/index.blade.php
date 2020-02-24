@extends('mado.admin.shop.template')

@section('title', '緊急メッセージ管理｜LIXIL簡易見積りシステム')

@section('main')
<main class="common">
    <h1 class="mainTtl">緊急メッセージ管理</h1>

    @include ('mado.admin.parts.notice_message')

    <p class="note">店舗TOPページのナビゲーションのすぐ下の位置に、緊急メッセージを登録することが可能です。<br>
    改行は利用できませんので、テキストで記載内容を入力してください。<br>
    緊急メッセージを登録しない場合は、「緊急メッセージを登録する」のチェックを外し、登録ボタンを押してください。</p>

    {!! Form::model($emergencyMessage, [
        'route' => ['admin.shop.message.edit', 'shop_id' => $emergencyMessage->{config('const.db.emergency_messages.SHOP_ID')}],
    ]) !!}
    <table class="formTbl">
        <tbody>
            <tr>
                <th>緊急メッセージ</th>
                <td>
                    <ul class="radioList">
                        <li>
                            {!! Form::hidden(config('const.db.emergency_messages.IS_PUBLISH'), '0') !!}
                            {!! Form::checkbox(config('const.db.emergency_messages.IS_PUBLISH'), '1', null, [
                                'id' => config('const.db.emergency_messages.IS_PUBLISH')
                            ]) !!}
                            {!! Form::label(config('const.db.emergency_messages.IS_PUBLISH'), '緊急メッセージを登録する', [
                                'id' => null,
                                'class' => null,
                            ]) !!}
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <th>メッセージ内容 <span class="require">※</span></th>
                <td>
                    {!! Form::textarea(
                        config('const.db.emergency_messages.TEXT'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                    <p class="errMsg">{{ $errors->first(config('const.db.emergency_messages.TEXT')) }}</p>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="btnBlock">
        <p>{!! Form::submit('登録', ['class' => 'button _submit']) !!}</p>
    </div>

    {!! Form::close() !!}
</main>
@endsection
