    <li>
        <div class="shopBlock">
            <div class="shopOutline">
                <figure class="shopImg"><img src="{{ app()->make('image_get')->shopMainUrl($shop->{config('const.db.shops.ID')}, 's') }}" alt="{{ $shop->{config('const.db.shops.NAME')} }}の写真"></figure>
                <div class="shopOutlineBox">
                    <h3>
                            LIXIL簡易見積りシステム<br>
                            {{ $shop->{config('const.db.shops.NAME')} }}
                    </h3>
                    <p class="shopAddress">〒{{ $shop->{config('const.db.shops.ZIP1')} }}-{{ $shop->{config('const.db.shops.ZIP2')} }}&nbsp;{{ $shop->address() }}</p>
                    <p class="shopAddress">営業時間：{{ $shop->openingTime() }}&nbsp;{{ $shop->{config('const.db.shops.OTHER_TIME')} }}</p>
                    <p class="shopAddress">定休日：{{ $shop->{config('const.db.shops.NORMALLY_CLOSE_DAY')} }}</p>
                    <p class="shopTel"><a href="tel:{{ $shop->telWithoutHyphen() }}" class="telnum"><i class="fas fa-phone"></i>{{ $shop->{config('const.db.shops.TEL')} }}</a></p>
                </div>
            </div>
            <div class="btnList">
                @if ($shop->{config('const.db.shops.CAN_SIMULATE')} === config('const.common.ENABLE'))
                    <ul>
                        <li>
                            <a href="{{ $shop->siteUrlPortal() }}/window/step1" @if ($shop->isPremium()) target="_blank" @endif target="_blank">
                                <img src="{{ asset('img/btn_window.png') }}" width="160" alt="窓まわりの見積りシミュレーション">
                            </a>
                        </li>
                        <li>
                            <a href="{{ $shop->siteUrlPortal() }}/door/step1" @if ($shop->isPremium()) target="_blank" @endif target="_blank">
                                <img src="{{ asset('img/btn_door.png') }}" width="160" alt="玄関ドアの見積りシミュレーション">
                            </a>
                        </li>
                    </ul>
                @endif
                <ul>
                    <li>
                        <a href="{{ $shop->siteUrl() }}" @if ($shop->isPremium()) target="_blank" @endif>
                            <picture>
                                <source media="(max-width:767px)" srcset="{{ asset('img/btn_detail_sp.png') }}">
                                <img src="{{ asset('img/btn_detail_pc.png') }}" width="160" alt="店舗詳細">
                            </picture>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $shop->contactUrl() }}" @if ($shop->isPremium()) target="_blank" @endif>
                            <picture>
                                <source media="(max-width:767px)" srcset="{{ asset('img/btn_contact_sp.png') }}">
                                <img src="{{ asset('img/btn_contact_pc.png') }}" width="160" alt="24時間受付中　無料でご相談">
                            </picture>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="iconList">
            <ul class="iconMeister">
                @if ($shop->{config('const.db.shops.IS_MADO_MEISTER')} === config('const.common.ENABLE'))
                    <li><img src="{{ asset('img/icon_meister_mado.png') }}" alt="窓マイスター"></li>
                @endif
            </ul>
            <ul class="iconGeneral">
                @if ($shop->{config('const.db.shops.HAS_T_POINT')} === config('const.common.ENABLE'))
                    <li><img src="{{ asset('img/icon_tpoint.png') }}" alt="Tポイント提携店"></li>
                @endif
                @if ($shop->{config('const.db.shops.IS_NO_RATE')} === config('const.common.ENABLE'))
                    <li><img src="{{ asset('img/icon_nointerest.png') }}" alt="無金利リフォームローン"></li>
                @endif
                @if ($shop->{config('const.db.shops.CAN_PAY_BY_CREDIT_CARD')} === config('const.common.ENABLE'))
                    <li><img src="{{ asset('img/icon_credit.png') }}" alt="クレジットカード決済"></li>
                @endif
            </ul>
        </div>
    </li>
