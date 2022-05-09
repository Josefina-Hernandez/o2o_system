@extends('mado.admin.lixil.template')

@section('title', 'LIXIL Administrator')

@section('main')
<main class="mypage">
   <!--
    <h1 class="mainTtl">LIXIL管理者メニューTOP</h1>

    <section class="news">
        <h2>注意事項</h2>
        <dl class="newsList">
            <dd style="width: 100%;">会員を登録する際に、ステータスにご注意ください。必要項目が揃っていない場合は非公開設定にしてください。<br>必要項目がすべて揃ったのち、プレビューステータスに切替を行い、表示内容を確認してください。<br>※プレビューではサイトは公開されません。</dd>
        </dl>
        <dl class="newsList">
            <dd style="width: 100%;">ポータルのTOPページおよび会員管理画面のTOPページにそれぞれお知らせを掲載することが可能です。<br>お知らせ管理メニューより、Movable Typeにログインして記事を投稿してください。<br>
Movable Typeのログインアカウントは、この管理画面のログインID、パスワードと同一です。</dd>
        </dl>
    </section>
 -->
    <ul class="navList">
            <li><a class='rendect-page' data-href="{{ route('admin.lixil.users.users') }}" >Account</a></li>
            <li><a class='rendect-page' data-href="{{ route('admin.lixil.price-maintenance.index') }}">Price <br>Maintenance</a></li>
            <li><a class='rendect-page' data-href="{{ route('admin.lixil.quotation-result.index') }}">Quotation <br>Result</a></li>
	 		<li><a class='rendect-page' data-href="{{ route('admin.lixil.access-analysis.index') }}">Access <br>analysis</a></li>
    </ul>
</main>
@endsection
