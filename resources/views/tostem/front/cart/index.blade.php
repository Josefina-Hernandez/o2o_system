@extends("tostem.front.template")
@section('head')
    @parent
    <link rel="stylesheet" href="{{asset('tostem/front/cart/cart.css')}}">
    @if(isset($pdf) == true)
        <style>
            .cart-header {
                display: none;
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
            .pdf-view .product span {
                color: #000000 !important;
            }
        </style>
    @endif
@endsection
@section('content')

    <div class="container cart {{isset($pdf)? 'pdf-view':''}}" id="cart-vue">
        @if(isset($pdf) == false)
        <div class="cart-header">
            <div class="title-pate">
                <h1>Quotation Summary</h1>
            </div>
            <div class="search-quotation">
                <div>
                    <input type="text" placeholder="Quotation No: XXXXXXXX">
                </div>
            </div>
        </div>

        <div class="shopping-cart">

            <div class="column-labels">
                <label class="product-no">No.</label>
                <label class="product-image">Item</label>

                <label class="product-series">Series</label>
                <label class="product-size">Size</label>
                <label class="product-color">Color</label>

                <label class="product-details">Description</label>
                <label class="product-price">Unit Price</label>
                <label class="product-quantity">Quantity</label>
                <label class="product-line-price">Total</label>
                <label class="product-removal">Remove</label>
            </div>


            <div class="product" v-for="item, itemObjKey in items" v-bind:key="'e_'+itemObjKey" v-bind:id="product_+item.id" v-cloak v-bind:data-itemKey="itemObjKey" >
                <div class="product-no">
                    <span>@{{itemObjKey + 1}}</span>
                </div>
                <div class="product-image">
                        <img v-bind:src="item.image" >
                </div>

                <div class="product-series">
                    <div>
                        <span>@{{ item.series_name }}</span> <br>
                        <span>@{{ item.series_description }}</span>
                    </div>
                </div>
                <div class="product-size">
                    <div>
                        <span>@{{ item.width }}</span> <br>
                        <span>@{{ item.height }}</span>
                    </div>
                </div>
                <div class="product-color">
                    <div>
                        <span>@{{ item.color }}</span>
                    </div>
                </div>


                <div class="product-details">
                    <div>
                        <span class="product-title">@{{ item.product_description }}</span>
                        <span class="product-description">@{{ item.product_description2 }}</span>
                    </div>
                </div>
                <div class="product-price"><span>@{{ formatPrice(item.price) }}</span></div>
                <div class="product-quantity">
                    <select name="quantity" id="" v-on:change="uploadQuantityItem(item.id, itemObjKey)" >
                        @for($i = 1; $i <= 99; $i++)
                            <option value="{{$i}}" v-text:selected="{{$i}}" v-if="item.quantity == {{$i}}" selected="selected" ></option>
                            <option value="{{$i}}" v-text:selected="{{$i}}" v-else></option>
                        @endfor

                    </select>

                </div>
                <div class="product-line-price"><span>@{{ formatPrice( item.price * item.quantity ) }}</span></div>
                <div class="product-removal">
                    <a href="javascript:void(0)" v-on:click="confirmRemove(item.id, itemObjKey)" class="remove-product">
                        &times;
                    </a>
                </div>
            </div>

            <div class="totals">
                <div class="totals-item">
                    <div class="send-mail">
                        <a href="javascript:void(0)" v-on:click="mail">Send By Mail</a>
                    </div>
                    <div class="download-pdf">
                        <a href="javascript:void(0)" v-on:click="downloadPdfCart">Download as PDF</a>
                    </div>
                    <div class="download-csv">
                        <a href="javascript:void(0)" v-on:click="downloadCsvCart">Download as CSV</a>
                    </div>
                    <div class="totals-value" id="cart-subtotal">
                        <span class="price">@{{ formatPrice(details.sub_total) }}</span> <br>
                        <span class="description">
                            Subtotal (Vat not included)
                        </span>
                    </div>
                </div>

            </div>
        </div>
        <modal name="remove-product" :width="300" :height="125">
            <div class="modal-body">
                <button type="button" class="close"  @click="$modal.hide('remove-product')">
                    <span aria-hidden="true">&times;</span>
                </button>
                <p>Are you sure to remove this product. </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" @click="removeItem">Remove</button>
                <button type="button" class="btn btn-secondary" @click="$modal.hide('remove-product')" >Close</button>
            </div>
        </modal>
        <modal name="send-mail" :width="380" :height="127">
            <div class="modal-body">
                <label>
                    Email:
                    <input type="text" name="email-send" id="email-send"
                           style="width: 218px; font-weight: 500; padding: 3px 7px">
                </label>
                <button type="button" class="btn btn-danger" @click="sendMail" style="margin-left: 20px;">Send</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="$modal.hide('send-mail')" >Close</button>
            </div>
        </modal>
        <modal name="notification" :width="380" :height="100">
            <div class="modal-body">
                @{{ message }}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="$modal.hide('notification')" >OK</button>
                </div>

            </div>

        </modal>
        @else
        {!! $html_cart !!}
        @endif
    </div>
@endsection

@section('script')
    @parent
    @if(isset($pdf) == false)
        <script src="{{asset('tostem/front/cart/cart.js')}}"></script>
    @endif
@endsection