<section class="shopGuideSec">
    <h2>店舗案内</h2>
    <div class="guideBox">
        <ul>
            <li>
                <dl>
                    <dt>店舗名</dt>
                    <dd>LIXIL簡易見積りシステム {{ $shop->{config('const.db.shops.NAME')} }}</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>法人名</dt>
                    <dd>{{ $shop->{config('const.db.shops.COMPANY_NAME')} }}</dd>
                </dl>
            </li>
            @isset ($shop->{config('const.db.shops.PRESIDENT_NAME')})
                <li>
                    <dl>
                        <dt>代表者名</dt>
                        <dd>{{ $shop->{config('const.db.shops.PRESIDENT_NAME')} }}</dd>
                    </dl>
                </li>
            @endisset
            @isset ($shop->{config('const.db.shops.PERSONNEL_NAME')})
                <li>
                    <dl>
                        <dt>担当者名</dt>
                        <dd>{{ $shop->{config('const.db.shops.PERSONNEL_NAME')} }}</dd>
                    </dl>
                </li>
            @endisset
            <li>
                <dl>
                    <dt>所在地</dt>
                    <dd>〒{{ $shop->{config('const.db.shops.ZIP1')} }}-{{ $shop->{config('const.db.shops.ZIP2')} }} {{ $shop->address() }}<a href="https://maps.google.co.jp/?q={{ $shop->{config('const.db.shops.LATITUDE')} }},{{ $shop->{config('const.db.shops.LONGITUDE')} }}" class="map" target="_blank">地図</a></dd>
                </dl>
            </li>
            @isset ($shop->{config('const.db.shops.SUPPORT_AREA')})
                <li>
                    <dl>
                        <dt>対応エリア</dt>
                        <dd>{{ $shop->{config('const.db.shops.SUPPORT_AREA')} }}</dd>
                    </dl>
                </li>
            @endisset
            @isset ($shop->{config('const.db.shops.LICENSE')})
                <li>
                    <dl>
                        <dt>許可番号</dt>
                        <dd>{!! nl2br($shop->{config('const.db.shops.LICENSE')}, false) !!}</dd>
                    </dl>
                </li>
            @endisset
            @isset ($shop->{config('const.db.shops.CERTIFICATE')})
                <li>
                    <dl>
                        <dt>資格</dt>
                        <dd>{!! nl2br($shop->{config('const.db.shops.CERTIFICATE')}, false) !!}</dd>
                    </dl>
                </li>
            @endisset
            @isset ($shop->{config('const.db.shops.COMPANY_START')})
                <li>
                    <dl>
                        <dt>創業・起業</dt>
                        <dd>{{ $shop->{config('const.db.shops.COMPANY_START')} }}年</dd>
                    </dl>
                </li>
            @endisset
            @isset ($shop->{config('const.db.shops.COMPANY_HISTORY')})
                <li>
                    <dl>
                        <dt>沿革</dt>
                        <dd>{!! nl2br($shop->{config('const.db.shops.COMPANY_HISTORY')}, false) !!}</dd>
                    </dl>
                </li>
            @endisset
        </ul>
        <ul>
            <li>
                <dl>
                    <dt>営業時間</dt>
                    <dd>{{ $shop->openingTime() }}&nbsp;{{ $shop->{config('const.db.shops.OTHER_TIME')} }}</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>定休日</dt>
                    <dd>{{ $shop->{config('const.db.shops.NORMALLY_CLOSE_DAY')} }}</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>TEL</dt>
                    <dd>{{ $shop->{config('const.db.shops.TEL')} }}</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>FAX</dt>
                    <dd>{{ $shop->{config('const.db.shops.FAX')} }}</dd>
                </dl>
            </li>
            @isset ($shop->{config('const.db.shops.EMPLOYEE_NUMBER')})
            <li>
                <dl>
                    <dt>従業員数</dt>
                    <dd>{{ $shop->{config('const.db.shops.EMPLOYEE_NUMBER')} }}人</dd>
                    </dl>
                </li>
            @endisset
            @isset ($shop->{config('const.db.shops.CAPITAL')})
                <li>
                    <dl>
                        <dt>資本金</dt>
                        <dd>
                            {{ number_format($shop->{config('const.db.shops.CAPITAL')}) }}万円
                        </dd>
                    </dl>
                </li>
            @endisset
            @isset ($shop->{config('const.db.shops.SITE_URL')})
                <li>
                    <dl>
                        <dt>ホームページ</dt>
                        <dd><a href="{{ $shop->{config('const.db.shops.SITE_URL')} }}" target="_blank">{{ $shop->{config('const.db.shops.SITE_URL')} }}</a></dd>
                    </dl>
                </li>
            @endisset
            @if (isset($shop->{config('const.db.shops.TWITTER')}) || isset($shop->{config('const.db.shops.FACEBOOK')}) )
                <li>
                    <dl>
                        <dt>SNS</dt>
                        <dd>
                            @isset ($shop->{config('const.db.shops.TWITTER')})
                                Twitter：<a href="https://twitter.com/{{ $shop->{config('const.db.shops.TWITTER')} }}" target="_blank">@ {{ $shop->{config('const.db.shops.TWITTER')} }}</a><br>
                            @endisset
                            @isset ($shop->{config('const.db.shops.FACEBOOK')})
                                Facebook：<a href="https://www.facebook.com/{{ $shop->{config('const.db.shops.FACEBOOK')} }}" target="_blank">https://www.facebook.com/{{ $shop->{config('const.db.shops.FACEBOOK')} }}</a><br>
                            @endisset
                        </dd>
                    </dl>
                </li>
            @endif
        </ul>
    </div>

    @isset ($shop->{config('const.db.shops.SUPPORT_DETAIL_LIST')})
        <h3><span>●</span> 取扱施工内容</h3>
        <ul class="constList">
            @foreach ($shop->{config('const.db.shops.SUPPORT_DETAIL_LIST')} as $detail)
                <li>{{ config('const.form.admin.shop.SUPPORT_DETAIL_LIST')[$detail] }}</li>
            @endforeach
        </ul>
    @endisset

    <ul class="iconList">
        @if ($shop->{config('const.db.shops.IS_MADO_MEISTER')} == config('const.common.ENABLE'))
            <li ontouchstart="">
                <img src="{{ asset('img/shop_icon_meister.png') }}" alt="窓マイスター">
                <p>窓マイスターとは、LIXILに認定される<br>窓リフォームのプロフェッショナルです。</p>
            </li>
        @endif
        @if ($shop->{config('const.db.shops.HAS_T_POINT')} == config('const.common.ENABLE'))
            <li ontouchstart="">
                <img src="{{ asset('img/shop_icon_tpoint.png') }}" alt="Tポイント提携店">
                <p>窓・玄関ドアのリフォームでお得な<br>Tポイントが貯まります！</p>
            </li>
        @endif
        @if ($shop->{config('const.db.shops.IS_NO_RATE')} == config('const.common.ENABLE'))
            <li ontouchstart="">
                <img src="{{ asset('img/shop_icon_nointerest.png') }}" alt="無金利リフォームローン">
                <p>LIXILの対象商品を採用すると金利0%・<br>最長60回の分割払い。</p>
            </li>
        @endif
        @if ($shop->{config('const.db.shops.CAN_PAY_BY_CREDIT_CARD')} == config('const.common.ENABLE'))
            <li ontouchstart="">
                <img src="{{ asset('img/shop_icon_credit.png') }}" alt="クレジットカード決済">
                <p>クレジットカードでのお支払いが可能です。</p>
            </li>
        @endif
    </ul>
</section>