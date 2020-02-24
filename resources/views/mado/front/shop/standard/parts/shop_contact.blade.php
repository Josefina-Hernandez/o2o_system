<section class="contactSec">
    <h2>お気軽にお問い合わせください</h2>
    <div class="flexBlock">
        <dl class="tel">
            <dt>お電話でのお問い合わせ（営業時間内での受付）</dt>
            <dd><a href="tel:{{ $shop->telWithoutHyphen() }}" class="telnum"><i class="fas fa-phone"></i>{{ $shop->{config('const.db.shops.TEL')} }}</a></dd>
        </dl>
        <dl class="mail">
            <dt>メールでのお問い合わせ（24時間受付中）</dt>
            <dd>
                <a href="{{ route('front.shop.standard.contact', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}">
                <picture>
                    <source media="(max-width:767px)" srcset="{{ asset('img/contact_btn_sp.png') }}">
                    <img src="{{ asset('img/contact_btn_pc.png') }}" width="390" alt="お問い合わせフォーム">
                </picture>
                </a>
            </dd>
        </dl>
    </div>
</section>