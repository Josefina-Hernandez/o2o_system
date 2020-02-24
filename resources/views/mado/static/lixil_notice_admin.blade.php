<section class="news">
    <h2>LIXILからのお知らせ</h2>

    <dl class="newsList">

        @if ( \Schema::hasColumn('shops', 'shop_type') === false ) {{--portal--}}
        <dt>2019年05月07日</dt>
        <dd>サイトを公開しました。店舗写真およびスタッフ紹介、店舗からのメッセージの登録をお願いいたします。</dd>
        @else {{--general--}}
        <span>2019/11/15に公開しました。</span>
        @endif
    </dl>

</section>
