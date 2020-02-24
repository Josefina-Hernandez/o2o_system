@extends('mado.admin.shop.template')

@if('admin.shop.blog.new' === \Route::currentRouteName())
    @section('title', '現場ブログ・イベントキャンペーン登録')
@elseif('admin.shop.blog.edit' === \Route::currentRouteName())
    @section('title', '現場ブログ・イベントキャンペーン編集')
@endif

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @parent
@endsection

@section('main')
<main class="common">

    <h1 class="mainTtl">
        @if('admin.shop.article.new' === \Route::currentRouteName())
            現場ブログ・イベントキャンペーン新規登録
        @elseif('admin.shop.article.edit' === \Route::currentRouteName())
            現場ブログ・イベントキャンペーン編集
        @endif
    </h1>
    <p class="note"><span class="require">※</span>は必須項目となります</p>

    @if ('admin.shop.article.new' === \Route::currentRouteName())
        {!! Form::model($standardArticle, [
            'route' => ['admin.shop.article.complete', 'shop_id' => $standardArticle->{config('const.db.standard_articles.SHOP_ID')}],
            'enctype' => 'multipart/form-data',
        ]) !!}

    @elseif ('admin.shop.article.edit' === \Route::currentRouteName())
        {!! Form::model($standardArticle, [
            'route' => ['admin.shop.article.edit.complete', 'shop_id' => $standardArticle->{config('const.db.standard_articles.SHOP_ID')}, 'article_id' => $standardArticle->{config('const.db.standard_articles.ID')}],
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif
        <div id="message-length">

            <table class="formTbl">
                <tr>
                    <th>カテゴリ <span class="require">※</span></th>
                    <td>
                        <ul class="radioList">
                            @foreach (config('const.form.admin.shop.standard_article.CATEGORY') as $value => $label)
                            <li>
                            {!! Form::radio(
                                config('const.db.standard_articles.CATEGORY'),
                                (string)$value,
                                null,
                                [
                                    'id' => config('const.db.standard_articles.CATEGORY') . '_' . $value,
                                ]
                            ) !!}
                            {!! Form::label(
                                config('const.db.standard_articles.CATEGORY') . '_' . $value,
                                $label,
                                [
                                    'id' => null,
                                    'class' => null,
                                ]
                            ) !!}
                            </li>
                            @endforeach
                        </ul>
                        <p class="errMsg">{{ $errors->first(config('const.db.standard_articles.CATEGORY')) }}</p>
                    </td>
                </tr>
                <tr>
                    <th>年月日 <span class="require">※</span></th>
                    <td>
                        <p>
                            {!! Form::text(
                                config('const.db.standard_articles.PUBLISHED_AT'),
                                null,
                                [
                                    'id' => 'timepicker',
                                    'class' => 'w150',
                                ]
                            ) !!}
                        </p>
                        <p class="errMsg">{{ $errors->first(config('const.db.standard_articles.PUBLISHED_AT')) }}</p>
                    </td>
                </tr>
                <tr>
                    <th>タイトル <span class="require">※</span></th>
                    <td>
                        <p>
                            {!! Form::text(
                                config('const.db.standard_articles.TITLE'),
                                null,
                                []
                            ) !!}
                        </p>
                        <p class="errMsg">{{ $errors->first(config('const.db.standard_articles.TITLE')) }}</p>
                    </td>
                </tr>
                <tr>
                    <th>メイン写真 <span class="require">※</span></th>
                    <td>
                        <p>
                            <file-upload name="{{ config('const.form.admin.shop.standard_article.MAIN_PICTURE') }}" image="{{ $mainPicture !== null ? "{$mainPicture}" : null }}" image-cls="shopPhoto"></file-upload>
                        </p>
                        <p class="errMsg">{{ $errors->first(config('const.form.admin.shop.standard_article.MAIN_PICTURE')) }}</p>
                    </td>
                </tr>
                <tr>
                    <th>概要 <span class="require">※</span></th>
                    <td>
                        <p>
                            {!! Form::textarea(
                                config('const.db.standard_articles.SUMMARY'),
                                null,
                                [
                                    'rows' => 2,
                                ]
                            ) !!}
                        </p>
                        <p class="errMsg">{{ $errors->first(config('const.db.standard_articles.SUMMARY')) }}</p>
                    </td>
                </tr>
                <tr>
                    <th>内容</th>
                    <td>
                        <p>
                            {!! Form::textarea(
                                config('const.db.standard_articles.TEXT'),
                                '<main id="mainArea" class="blog _detail" style="height:100%;"><article><div class="blogArea">'
                                     . old(config('const.db.standard_articles.TEXT'), $standardArticle->{config('const.db.standard_articles.TEXT')}) 
                                     . '</div></article></main>',
                                [
                                    'id' => 'tinymce-article',
                                    'class' => null,
                                    'rows' => 2,
                                ]
                            ) !!}
                        </p>
                        <p class="errMsg">{{ $errors->first(config('const.db.standard_articles.TEXT')) }}</p>
                    </td>
                </tr>
            </table>

            {!! Form::hidden(config('const.db.standard_photos.SHOP_ID'), $standardArticle->{config('const.db.standard_articles.SHOP_ID')}) !!}

            <div class="btnBlock">
                {!! Form::submit('登録', ['class' => 'button _submit']) !!}
            </div>
        </div>
    {!! Form::close() !!}
</main>
@endsection

@section('script')
    @parent

    {{-- timepicker --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript">
        flatpickr('#timepicker', {
            time_24hr: true,
        });
    </script>
@endsection
