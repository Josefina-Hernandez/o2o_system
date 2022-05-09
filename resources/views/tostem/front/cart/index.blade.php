@extends("tostem.front.template")
@section('head')
    @parent
    <link rel="stylesheet" href="{{asset('tostem/front/cart/cart.css')}}">
    {{-- Add Start BP_O2OQ-7 hainp 20200727 --}}
    <style>
        .sub-price::after {
            content: " {{ __('screen-cart.THB') }}"!important;
        }
        .price::after {
            content: " {{ __('screen-cart.THB') }}"!important;
        }
        .p_end_geista_65 {
          padding-bottom: 3rem;
        }
        span.des_geista_65 {
          display: block
        }
    </style>
    {{-- Add End BP_O2OQ-7 hainp 20200727 --}}
    @if(isset($html_cart) == true)
        <style>
            body {
            }
            .totals .totals-item .totals-value .description {
                bottom: -1.3rem;
            }
            header {
                display: none;
            }
            main {
                margin-top: 0;
            }
            #site-main {
                margin-top: 0 !important;
                padding: 0 !important;
            }
            .pdf-view .product {
                display: -webkit-box !important;
                display: -webkit-flex !important;
                display: -moz-box !important;
                display: -moz-flex !important;
                display: -ms-flexbox !important;
                display: flex;

                -webkit-box-align: center;
                -ms-flex-align: center;
                -webkit-align-items: center;
                -moz-align-items: center;
                align-items: center;

                -webkit-box-pack: center;
                -ms-flex-pack: center;
                -webkit-justify-content: center;
                -moz-justify-content: center;
                justify-content: center;
            }

            /* Remove Start BP_O2OQ-4 hainp 20200605 */
            /* .search-quotation > div {
                float: right;

            } */
            /* Remove End BP_O2OQ-4 hainp 20200605 */

            /* Add Start BP_O2OQ-4 hainp 20200605 */
            .search-quotation .created-by-username {
                margin-top: unset;
            }
            /* Add End BP_O2OQ-4 hainp 20200605 */


            .pdf-view .product span {
                color: #000000 !important;
            }

            .v--modal-overlay {
                display: none;
            }
            .title-pate h1, .title-pate, .cart-header {
                margin-top: 0;
                padding-top: 0;
            }

            .cart-header .search-quotation div {
                margin-top: 0 !important;
            }
            .product .remove-product {
                padding: 7px 6px 5px 8px !important;
                vertical-align: bottom;
            }
            #header-pdf{
            	display: block !important;
            	margin-bottom: 20px;
            }
            .totals .send-mail a, .totals .download-pdf a, .totals .download-csv a{
            	font-size: 1.4rem;
            }
            .summary-text, select[name="quantity"], .reference-no {/*Edit BP_O2OQ-25 hainp 20210624*/
            	display: none;
            }
            .send-mail, .download-pdf, .product-removal{
            	visibility: hidden;
            }
            .quantity-label{
            	display: block !important;
            }

            /*Add Start BP_O2OQ-7 hainp 20200701*/
            .reference-no-label{
            	display: block !important;
            }
            /*Add End BP_O2OQ-7 hainp 20200701*/

            * {
            	overflow: visible !important;
            }

            .item-row {
            	page-break-inside: avoid !important;
            }

        </style>
        <style type="text/css" media="screen,print">
            .new-page {
                product product-end                /*page-break-before: always;*/
            }
        </style>
    @endif
@endsection
@section('content')
	<div id="header-pdf" style="display: none;" class="container text-right">
		<div style="margin-right: 15px"><img src="{{ asset('tostem/img/TOSTEM/tostem_logo_final.png') }}" style="max-width: 170px"></div>
	</div>
    <div class="container cart {{isset($html_cart)? 'pdf-view':''}}" id="cart-vue"> {{--warp-customize--}}

        <div class="cart-header">
            <div class="title-pate">
                <h1>{{ __('screen-cart.Quotation Summary') }}</h1>
            </div>
            <div class="search-quotation">
                <div>
                    @if(isset($html_cart) == false)
                        <span>{{ __('screen-cart.Quotation no') }} @{{quotation_no}}</span>
                    @else
                        <span>{{ __('screen-cart.Quotation no') }} {{$input_value}}</span>
                    @endif
                </div>
                {{-- Add Start BP_O2OQ-4 hainp 20200605 --}}
                @if(isset($html_cart) == false)
                    <div v-if="user_name !== null" class="created-by-username">
                        <span>{{ __('screen-cart.Created by') }} @{{user_name}}</span>
                    </div>
                @elseif (!is_null($value_user_name))
                    <div class="created-by-username">
                        <span>{{ __('screen-cart.Created by') }} {{$value_user_name}}</span>
                    </div>
                @endif
                {{-- Add End BP_O2OQ-4 hainp 20200605 --}}
            </div>
        </div>
        <div class="clearfix"></div>
        @if(isset($html_cart) == false)
            <div class="cart-content shopping-cart" id="cart-content">

                <div class="column-labels">
                    <label class="product-no">{{ __('screen-cart.No.') }}</label>
                    <label class="product-reference-no">{{ __('screen-cart.Reference No.') }}</label>{{-- Add BP_O2OQ-7 hainp 20200701 --}}
                    <label class="product-image">{{ __('screen-cart.Design') }}</label>

                    {{-- Edit Start BP_O2OQ-7 hainp 20200701 --}}
                    <label class="product-quantity">{{ __('screen-cart.Quantity') }}</label>
                    <label class="product-color">{{ __('screen-cart.Color') }}</label>
                    <label class="product-size">{!! __('screen-cart.Size(Width×Height) BR') !!}</label> {{-- Edit BP_O2OQ-7 hainp 20200701 --}}
                    <label class="product-details">{{ __('screen-cart.Description') }}</label>
                    <label class="product-series">{{ __('screen-cart.Series') }}</label>
                    <label class="product-order_no">{{ __('screen-cart.Order code') }}</label>
                    <label class="product-price">{{ __('screen-cart.Unit Price') }}</label>
                    {{-- Edit End BP_O2OQ-7 hainp 20200701 --}}
                    <label class="product-line-price">{{ __('screen-cart.Total') }}</label>
                    <label class="product-removal">Remove</label>
                </div>

                 <div v-for="item, itemObjKey in items" class="item-row">
                       <div v-bind:key="'e_'+itemObjKey" :class='{product:true, product_exterior: item.options_display.length > 1 }'
                          v-bind:id="product_+item.id" v-cloak v-bind:data-itemKey="itemObjKey">

                              <div class="product-no">
                                  <span>@{{itemObjKey + 1}}</span>
                              </div>

                              {{-- Edit Start BP_O2OQ-25 hainp 20210621 --}}
                              <div class="product-reference-no">
                                <!-- <select name="reference-no" id="" v-on:change="uploadRefenceNo(item.id, itemObjKey)">
                                    @for($i = 1; $i <= 99; $i++)
                                        <option value="{{$i}}" v-text:selected="{{$i}}" v-if="item.reference_no == {{$i}}" selected="selected"></option>
                                        <option value="{{$i}}" v-text:selected="{{$i}}" v-else></option>
                                    @endfor
                                </select> -->
                                <input
                                    class="reference-no"
                                    style="width: 100%;"
                                    type="text"
                                    :maxlength="length_reference_no"
                                    @input="uploadRefenceNo($event, item.id, itemObjKey)"
                                    v-model="item.reference_no"
                                />
                                <span class="reference-no-label" style="display: none">@{{item.reference_no}}</span>
                              </div>
                              {{-- Edit End BP_O2OQ-25 hainp 20210621 --}}

                              <div class="product-image">
                                  <img v-bind:src="_base_app+'/tostem/img/data/'+item.featured_img" {{--:error="onImgError()"--}}>
                              </div>

                              {{-- Edit Start BP_O2OQ-7 hainp 20200701 --}}
                              <div class="product-quantity">
                                <select name="quantity" id="" v-on:change="uploadQuantityItem(item.id, itemObjKey)">
                                    @for($i = 1; $i <= 99; $i++)
                                        <option value="{{$i}}" v-text:selected="{{$i}}" v-if="item.quantity == {{$i}}"
                                                selected="selected"></option>
                                        <option value="{{$i}}" v-text:selected="{{$i}}" v-else></option>
                                    @endfor

                                </select>
                                <span class="quantity-label" style="display: none">@{{item.quantity}}</span>

                              </div>
                              <div class="product-color">
                                <div>
                                    <span>@{{ item.color_name }}</span>
                                </div>
                              </div>
                              <div class="product-size">
                                <div>
                                    {{-- <span>@{{ item.size.join('×') }}<br></span> --}} {{-- Remove BP_O2OQ-4 hainp 20200608 --}}
                                    <span v-html="item.size"></span> {{-- Add BP_O2OQ-4 hainp 20200608 --}}
                                </div>
                              </div>
                              <div class="product-details">
                                <div>
                                <span v-for="des, itemObjKey in item.description">
                                    <span v-if="itemObjKey == 'undefined'">
                                        <span v-for="item_des in des">@{{ 'Label not found'+ ' : ' + item_des }}<br></span>
                                    </span>
                                    {{-- Add Start BP_O2OQ-4 hainp 20200608 --}}
                                    <span v-else-if="item.product_id == {{config('const.front.cart.PRODUCT_ID_GIESTA')}} && itemObjKey === '{{ __('screen-cart.Frame Type') }}'">
                                        @{{ itemObjKey+ ' : ' }}<b><u>@{{ des }}</u></b>
                                        <br>
                                    </span>
                                    {{-- Add End BP_O2OQ-4 hainp 20200608 --}}
                                    <span v-else>@{{ itemObjKey+ ' : ' + des }}<br></span>
                                </span>
                                <span v-show="item.louver_description_extra">@{{ item.louver_description_extra }}</span>
                                </div>
                              </div>
                              <div class="product-series">
                                  <div v-for="series_name in _.uniq(_.map(item.options_display, 'series_name'))" class="series-name" >{{-- Edit End BP_O2OQ-7 hainp 20200714 --}}
                                      <span>
                                          @{{ series_name }}{{-- Edit End BP_O2OQ-7 hainp 20200714 --}}
                                      </span>
                                  </div>
                              </div>
                              <div class="product-order_no">
                                <div v-if="item.display_detail_cart"> {{-- Add BP_O2OQ-4 hainp 20200608 --}}
                                  <div v-for="option in item.options_display" class="order-no">
                                  <span>
                                      @{{ option.order_no}}
                                  </span>
                                  </div>
                                </div> {{-- Add BP_O2OQ-4 hainp 20200608 --}}
                              </div>

                              <div class="product-price">
                                <div v-if="item.display_detail_cart"> {{-- Add BP_O2OQ-4 hainp 20200608 --}}
                                  <div v-for="option in item.options_display" class="price-item">
                                      <span>@{{ formatPrice(option.unit_price) }}</span>
                                  </div>
                                </div> {{-- Add BP_O2OQ-4 hainp 20200608 --}}
                              </div>
                              {{-- Edit End BP_O2OQ-7 hainp 20200701 --}}

                              <div class="product-line-price">
                                <div v-if="item.display_detail_cart"> {{-- Add BP_O2OQ-4 hainp 20200608 --}}
                                  <div v-for="option in item.options_display" class="total-item">
                                      <span>@{{ formatPrice(option.unit_price * item.quantity ) }}</span>
                                  </div>
                                </div> {{-- Add BP_O2OQ-4 hainp 20200608 --}}
                                {{-- Add Start BP_O2OQ-4 hainp 20200609 --}}
                                <div v-else>
                                    <span>@{{ formatPrice(item.subtotal * item.quantity) }}</span>
                                </div>
                                {{-- Add End BP_O2OQ-4 hainp 20200609 --}}
                              </div>
                              <div class="product-removal">
                                  <a href="javascript:void(0)" v-on:click="confirmRemove(item.id, itemObjKey)"
                                     class="remove-product">
                                      &times;
                                  </a>
                              </div>
                     </div>

                     <div class="image-description giesta" v-if="item.ctg_id == 3">
                        <span>{!! __('screen-select.giesta_img_description') !!}</span>
                        <span v-if="item.model_id == 65" class="des_geista_65">{!! __('screen-select.geista_img_des_a01') !!}</span>
                     </div>

                     <div class="image-description pitch" v-if="item.display_pitch_list">
                     	<span>{!! __('screen-cart.pitch_list_description') !!}</span>
                     </div>


                      <div :class="[{ 'p_end_geista_65' : item.model_id == 65 }, 'product product-end']">
                                  <div class="product-end-line-price">
                                           <span class="sub-price">@{{ formatPrice(item.subtotal * item.quantity ) }}</span>
                                           <br>
                                            <span class="description">
                                              {{ __('screen-cart.Subtotal (Vat not included)') }}
                                            </span>
                                  </div>
                      </div>
                </div>





                <div class="totals">
                    <div class="totals-item" v-if="items.length > 0">
                        <div class="send-mail">
                            <a href="javascript:void(0)" :class="{'disabled': disable_button}" v-on:click="mail">{{ __('screen-cart.send_by_mail') }}</a> <!-- Add BP_O2OQ-25 hainp 20210625 -->
                        </div>
                        <div class="download-pdf">
                            <a href="javascript:void(0)" :class="{'disabled': disable_button}" v-on:click="downloadPdfCart">{{ __('screen-cart.Download as PDF') }}</a> <!-- Add BP_O2OQ-25 hainp 20210625 -->
                        </div>
                        {{-- <div class="download-csv">
                            <a href="javascript:void(0)" v-on:click="downloadCsvCart">{{ __('screen-cart.Download as CSV') }}</a>
                        </div> --}}
                        <div class="totals-value" id="cart-subtotal">
                            <span class="price">@{{ formatPrice(details.sub_total) }}</span> <br>
                            <span class="description">
                               {{ __('screen-cart.Total (Vat not included)') }}

                        </span>
                        </div>
                    </div>
                    <div class="totals-item" v-else>
                        <div class="send-mail">
                            <a href="javascript:void(0)" class="disabled">{{ __('screen-cart.send_by_mail') }}</a>
                        </div>
                        <div class="download-pdf">
                            <a href="javascript:void(0)" class="disabled">{{ __('screen-cart.Download as PDF') }}</a>
                        </div>
                        {{-- <div class="download-csv">
                            <a href="javascript:void(0)" class="disabled">{{ __('screen-cart.Download as CSV') }}</a>
                        </div> --}}
                        <div class="totals-value" id="cart-subtotal">
                            <span class="price">@{{ formatPrice(details.sub_total) }}</span> <br>
                            <span class="description">
                            {{ __('screen-cart.Total (Vat not included)') }}
                        </span>
                        </div>
                    </div>

                </div>
            </div>
            <modal name="remove-product" :width="300" :height="125">
                <div class="modal-body">
                    <button type="button" class="close" @click="$modal.hide('remove-product')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p>{{ __('screen-cart.p_message') }}</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="removeItem">{{ __('screen-cart.b_remove') }}</button>
                    <button type="button" class="btn btn-secondary" @click="$modal.hide('remove-product')">{{ __('screen-cart.b_close') }}
                    </button>
                </div>
            </modal>
            <modal name="send-mail" :width="380" :height="135">
                <div class="modal-body" style="padding: 20px 15px">
                    <label>
                        {{ __('screen-cart.Email') }}:
                        <input type="text" name="email-send" id="email-send"
                               style="width: 218px; font-weight: 500; padding: 3px 7px">
                    </label>
                    <button type="button" class="btn btn-danger" @click="sendMail" style="margin-left: 20px;">{{ __('screen-cart.Send') }}
                    </button>
                    <a v-if="validate_mail != null" style="float: left;margin: -1% 22%; color: #ff1f1f;">{{ __('screen-cart.mes_email_error') }}</a>
                </div>
                <div class="modal-footer" style="padding: 10px 15px;">
                    <button type="button" class="btn btn-secondary" @click="$modal.hide('send-mail')">{{ __('screen-cart.m_close') }}</button>
                </div>
            </modal>
            <modal name="notification" :width="380" :height="100">
                <div class="modal-body">
                    @{{ message }}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="$modal.hide('notification')">{{ __('screen-cart.ok') }}</button>
                    </div>

                </div>

            </modal>
        @else
            <div class="cart-content shopping-cart" id="cart-content">
                {!! $html_cart !!}
            </div>
            <div id="test-pdf">

            </div>
        @endif

	    <v-dialog :click-to-close="false"></v-dialog>

    </div>
@endsection

@section('script')

	<script type="text/javascript">
		var lang_text = {
			ok: '{{ __('screen-cart.ok') }}',
			email: '{{ __('screen-cart.Email') }}',
			send: '{{ __('screen-cart.Send') }}',
			close: '{{ __('screen-cart.m_close') }}',
			remove: '{{ __('screen-cart.b_remove') }}',
			mes_email_error: '{{ __('screen-cart.mes_email_error') }}',
			mes_send_success: '{{ __('screen-cart.mes_send_success') }}',
			mes_email_send_error: '{{ __('screen-cart.mes_email_send_error') }}',
            mes_reference_no_input_error: '{{ __('screen-cart.mes_reference_no_input_error') }}', // Add BP_O2OQ-25 hainp 20210625
			session_expired: '{{ __('messages.session_expired') }}'
		}
	</script>

    @if(isset($html_cart) == false)
        @parent
        <script src="{{asset('tostem/front/cart/cart.js')}}"></script>
    @else
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script type="text/javascript">

            /**
             * .after()
             *
             * $(target).after(contentToBeInserted)
             */
            (function ($) {
                var originalAfter = $.fn.after;
                $.fn.after = function(par) {
                    if (arguments.length >= 1 && typeof par == 'object') {
                        //console.log('>> after with element '+par[0].id);
                        this[0].parentNode.insertBefore(par[0], this[0].nextSibling);
                        return this;
                    }
                    return originalAfter.call(this, par);
                };

                // cut page
                var cutPagePdf = function() {
                    var rows_cart = $('#cart-content > div'); //$('.shopping-cart').children();
                    var $height_max = 1500;
                    var fix_height_page = $('.title-pate').offset().top;

                    rows_cart.each(function (key, element) {
                        var _element = $(element);
                        var _prev_element = _element.prev();
                        //var offset_top = $(element).offset().top /* + $(element).outerHeight( true )*/;
                        var offset_button = _element.offset().top + _element.outerHeight(true);
                        //var height_check = offset_top - fix_height_page;
                        var bottom_check = offset_button - fix_height_page;

                        if (_element.hasClass('product_exterior')) { // fix also I don't know why
                            $height_max = 2100;
                        }
                        if ( bottom_check  > $height_max) {

                            _prev_element.after($('<div class="new-page"></div>'));
                            _prev_element.after($('<div class="clearfix"></div>'));
                            var cut_page_at = _prev_element.offset().top + _prev_element.outerHeight(true);
                            /*var debug_element = "<div>"
                                +"<div><span>--: "+key+"--</span></div>"
                                +"<div><span>top: "+_element.offset().top+"</span></div>"
                                +"<div><span>height: "+_element.outerHeight(true)+"</span></div>"
                                +"<div><span>bottom_check (offset_button - fix_height_page): "+bottom_check+"</span></div>"
                                +"<div><span>$height_max: "+$height_max+"</span></div>"
                                +"<div><span>fix_height_page: "+fix_height_page+"</span></div>"
                                +"<div><span>cut_page_at: "+cut_page_at+"</span></div>"
                                +"<div><span>_prev_element: "+_prev_element.attr('id')+"--</span></div>"
                                +"<div><span>_element: "+_element.attr('id')+"--</span></div>"
                                +"<div><span>--: "+key+"--</span></div>"
                                +" </div>";
                            $('#test-pdf').after($(debug_element));*/
                            fix_height_page = cut_page_at;//_element.offset().top;
                            $height_max = 1111;
                        }
                    });
                };


                setTimeout(function () {
                	//NOTE: tính toán cut page sử dụng js và cách đều phần header của mỗi page (đang bị lỗi cắt vào text nên đã comment css cho new page)
                    cutPagePdf();
                },100)

            })(jQuery);


        </script>
    @endif

@endsection