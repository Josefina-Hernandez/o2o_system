@extends('mado.admin.shop.template')

@section('title', 'スタッフ管理｜LIXIL簡易見積りシステム')

@section('main')
<main class="common staff">
    <h1 class="mainTtl">スタッフ管理</h1>

    {{-- 通知メッセージ --}}
    @include ('mado.admin.parts.notice_message')

    <p class="mb30">スタッフの削除は、クリアボタンを押して登録情報を空にした状態で登録ボタンを押してください</p>

    <div id="clear-staff">
    {!! Form::open([
        'route' => ['admin.shop.staff.edit', 'shop_id' => Request::route('shop_id')],
        'enctype' => 'multipart/form-data',
    ]) !!}

    @foreach ($staffs as $staff)
        <div class="staffCnt">
            <div class="staffTitle">
                <span>{{ $staff->{config('const.db.staffs.RANK')} }}人目</span>
                {!! Form::button('クリア', [
                    'id' => null,
                    'class' => 'button',
                    'v-on:click' => 'onClick($event, ' . $staff->{config('const.db.staffs.RANK')} . ')',
                ]) !!}
            </div>
        </div>

        <table class="formTbl">
            <tr>
                <th>役職</th>
                <td>
                    <p>
                        {!! Form::text(
                            config('const.db.staffs.POST') . '_' . $staff->{config('const.db.staffs.RANK')},
                            old(config('const.db.staffs.POST') . '_' . $staff->{config('const.db.staffs.RANK')}, $staff->{config('const.db.staffs.POST')}), [
                                'id' => null,
                                'class' => null,
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.staffs.POST') . '_' . $staff->{config('const.db.staffs.RANK')}) }}</p>
                </td>
            </tr>
            <tr>
                <th>名前</th>
                <td>
                    <p>
                        {!! Form::text(
                            config('const.db.staffs.NAME') . '_' . $staff->{config('const.db.staffs.RANK')},
                            old(config('const.db.staffs.NAME') . '_' . $staff->{config('const.db.staffs.RANK')}, $staff->{config('const.db.staffs.NAME')}), [
                                'id' => null,
                                'class' => null,
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.staffs.NAME') . '_' . $staff->{config('const.db.staffs.RANK')}) }}</p>
                </td>
            </tr>
            <tr>
                <th>メッセージ</th>
                <td>
                    <p>
                        {!! Form::textarea(
                            config('const.db.staffs.MESSAGE') . '_' . $staff->{config('const.db.staffs.RANK')},
                            old(config('const.db.staffs.MESSAGE') . '_' . $staff->{config('const.db.staffs.RANK')}, $staff->{config('const.db.staffs.MESSAGE')}), [
                                'id' => null,
                                'class' => null,
                                'placeholder' => '自己紹介（担当業務内容等）とともに仕事に関する価値観が伝わる内容のメッセージを掲載しましょう！',
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.staffs.MESSAGE') . '_' . $staff->{config('const.db.staffs.RANK')}) }}</p>
                </td>
            </tr>
            <tr>
                <th>写真</th>
                <td>
                    <file-upload name="{{ config('const.form.admin.shop.staff.PICTURE') . '_' . $staff->{config('const.db.staffs.RANK')} }}" image="{{ $staff->imageUrl() }}" ref="{{ $staff->{config('const.db.staffs.RANK')} }}" image-cls="shopImge" image-width="200" image-height="150"></file-upload>
                    <p class="errMsg">{{ $errors->first(config('const.form.admin.shop.staff.PICTURE') . '_' . $staff->{config('const.db.staffs.RANK')}) }}</p>
                </td>
            </tr>
            <tr>
                <th>資格</th>
                <td>
                    <p>
                        {!! Form::textarea(
                            config('const.db.staffs.CERTIFICATE') . '_' . $staff->{config('const.db.staffs.RANK')},
                            old(config('const.db.staffs.CERTIFICATE') . '_' . $staff->{config('const.db.staffs.RANK')}, $staff->{config('const.db.staffs.CERTIFICATE')}), [
                                'id' => null,
                                'class' => null,
                                'placeholder' => '資格情報をご記入ください',
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.staffs.CERTIFICATE') . '_' . $staff->{config('const.db.staffs.RANK')}) }}</p>
                </td>
            </tr>
            <tr>
                <th>趣味</th>
                <td>
                    <p>
                        {!! Form::textarea(
                            config('const.db.staffs.HOBBY') . '_' . $staff->{config('const.db.staffs.RANK')},
                            old(config('const.db.staffs.HOBBY') . '_' . $staff->{config('const.db.staffs.RANK')}, $staff->{config('const.db.staffs.HOBBY')}), [
                                'id' => null,
                                'class' => null,
                                'placeholder' => '趣味をご記入ください。お客さまに共感していただけるような表現にしましょう！ 例）休日のウッドデッキで楽しむ「おうちカフェ」と「オープンダイニング」',
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.staffs.HOBBY') . '_' . $staff->{config('const.db.staffs.RANK')}) }}</p>
                </td>
            </tr>
            <tr>
                <th>代表施工事例</th>
                <td>
                    <p>
                        {!! Form::textarea(
                            config('const.db.staffs.CASE') . '_' . $staff->{config('const.db.staffs.RANK')},
                            old(config('const.db.staffs.CASE') . '_' . $staff->{config('const.db.staffs.RANK')}, $staff->{config('const.db.staffs.CASE')}), [
                                'id' => null,
                                'class' => null,
                                'placeholder' => '施工した代表的な施工現場の名称をご記入ください。 例）〇〇市役所・〇〇分譲地等',
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.staffs.CASE') . '_' . $staff->{config('const.db.staffs.RANK')}) }}</p>
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
