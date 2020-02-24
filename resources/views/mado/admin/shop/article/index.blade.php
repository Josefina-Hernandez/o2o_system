@extends('mado.admin.shop.template')

@section('title', '現場ブログ管理')

@section('main')
<main class="common">
    <h1 class="mainTtl">現場ブログ・イベントキャンペーン管理</h1>
    <p class="mb30">
        <a href="{{ route('admin.shop.article.new', ['shop_id' => $shop->{config('const.db.shops.ID')}]) }}" class="button">新規登録</a>
    </p>

    <div id="confirm-dialog">
        {!! Form::open([
            'route' => ['admin.shop.news', 'shop_id' => $shop->{config('const.db.shops.SHOP_ID')}],
            'v-on:submit.prevent' => 'onSubmit'
        ]) !!}

        <table class="defaultTbl">
            <thead>
                <tr>
                    <th>投稿年月日</th>
                    <th>カテゴリ</th>
                    <th>タイトル</th>
                    <th>概要</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($standardArticles as $standardArticle)
                    <tr>
                        <td width="100">{{ $standardArticle->getPublishedDate() }}</td>
                        <td>{{ $standardArticle->getCategoryName() }}</td>
                        <td>{{ $standardArticle->{config('const.db.standard_articles.TITLE')} }}</td>
                        <td>{{ $standardArticle->{config('const.db.standard_articles.SUMMARY')} }}</td>
                        <td class="btnCell clearfix">
                            <p><a href="{{ route('admin.shop.article.edit', ['shop_id' => $shop->{config('const.db.shops.ID')}, 'article_id' => $standardArticle->{config('const.db.standard_articles.ID')} ]) }}" class="button _edit">編集</a></p>
                            <p>
                                <confirm-dialog
                                action="{{ route('admin.shop.article.delete', ['shop_id' => $shop->{config('const.db.shops.ID')}, 'article_id' =>  $standardArticle->{config('const.db.standard_articles.ID')}]) }}"
                                message="{{ '以下の現場ブログ・イベントキャンペーンを削除します。' . "\n"
                                    . '削除してよければ「OK」ボタンを押してください。' . "\n"
                                    . $standardArticle->getPublishedDate() . "\n"
                                    .  $standardArticle->getCategoryName() . "\n"
                                    . $standardArticle->{config('const.db.standard_articles.TITLE')} }}"></confirm-dialog>
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {!! Form::close() !!}
    </div>
    
    {{ $standardArticles->links() }}

</main>
@endsection
