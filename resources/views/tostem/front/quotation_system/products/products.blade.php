@extends("tostem.front.template")
@section('head')
    @parent
    <link rel="stylesheet" href="{{asset('tostem/front/quotation_system/products/product.css')}}">
@endsection

@section('content')
	<div class="breadcrumb">
		<a href="{{ route('tostem.front.quotation_system') }}">{{ __('screen-select.quotation') }}</a> / <a href="{{ route('tostem.front.quotation_system.product', $ctg->slug_name) }}"><b>{{ $ctg->ctg_name }}</b></a>
	</div>
	<div class="page {{ $ctg->slug_name }}" id="page">
    	<div class="container">
    		<div class="row product_model">
    			<template id="list-product">
    				<div class="col-xs-12 col-sm-2">
    					<template id="product-process-2" v-if="ctg_id == 2">
    						<div class="product-list">
		    					<div class="product" v-for="(product, index) in products" :key="product.product_id">
									<button
										:class="[{'black' : product.spec1 === spec1}, 'c-btn large']"
										:data-product-id="product.product_id"
										@click="selectProductProcess2(product.product_id, product.product_name, product.spec1, product.spec_name)">
										@{{ product.spec_name }}
									</button>
                                    <template id="submenu-2" 
                                        v-if="typeof sub_menus[product.product_id+''+product.spec1] != 'undefined'"
                                    >
                                        <a class="product_link tooltip-wrapper tooltip-left" style="margin:0" :href="sub_menus[product.product_id+''+product.spec1].link_url" target="_blank">
                                            <div class="tooltip">
                                                <div class="tooltip-body">@{{ sub_menus[product.product_id+''+product.spec1].description }}</div>
                                            </div>
                                        </a>
                                    </template>
								</div>
		    				</div>
    					</template>
    					<template id="product-process-1" v-else>
    						<div class="product-list">
		    					<div class="product" v-for="(product, index) in products" :key="product.product_id">
                                    <template id="submenu-1" v-if="typeof sub_menus[product.product_id] != 'undefined'">
                                        <a class="product_link tooltip-wrapper tooltip-left" style="margin:0" :href="sub_menus[product.product_id].link_url" target="_blank">
                                            <div class="tooltip">
                                                <div class="tooltip-body">@{{ sub_menus[product.product_id].description }}</div>
                                            </div>
                                        </a>
                                    </template>
									<button
										:class="[{'black' : product.product_id == product_id}, 'c-btn large']"
										:disabled="product.readonly_flg == 1"
										:data-product-id="product.product_id"
										@click="selectProduct(product.product_id, product.product_name)">
										@{{ product.product_name }}
									</button>
                                </div>
		    				</div>
    					</template>
	    			</div>
    			</template>

    			<template id="model-list">
					<div class="col-xs-12 col-sm-10" id="slide">
						<div class="slick-carousel">
							<slick class="app-carousel" ref="carousel" :options="slickOptions">
								<div class="model-item" v-for="model in models">
									<a
										@click="selectModels(model.m_model_id, model.m_color_id_default)"
										:data-model-id="model.m_model_id"
										:class="{ active : model_id == model.m_model_id }"
										>
										<div><img :src="'/tostem/img/data/' + model.img_path + '/' + model.img_name" class="img-responsive"></div>
										<span class="model-name">@{{ model.model_name_display }}</span>
									</a>
								</div>
							</slick>
						</div>
					</div>
				</template>
    		</div>

			<div class="row select-area" v-show="Object.keys(data_options).length > 0">
    			<div class="col-xs-12">
    				<hr id="line">
    			</div>

    			<div class="col-xs-12">
    				<div class="d-flex">
	    				<div class="item">
	    					<div id="featured-img" v-show="featured_img">
			    				<div class="wrap">
			    					<div class="img-center {{ $ctg->ctg_id == 3 ? 'giesta' : '' }}">
										<img :src="getImageResultPath" class="img-responsive" style="display: inline-block;">
										@if($ctg->ctg_id == 3)
											<span class="giesta-img-description">{!! __('screen-select.giesta_img_description') !!}</span>
                                            <span :class="[{ 'show' : model_id == 65 }, 'geista_img_des_a01']">{!! __('screen-select.geista_img_des_a01') !!}</span>
										@endif
			    					</div>

			    				</div>
			    			</div>
	    				</div>

	    				<div class="item">
	    					<div class="col-right">

	    						@if($ctg->ctg_id == 3)
	    							@include('tostem.front.quotation_system.products.template-parts.giesta')
	    						@else
	    							@include('tostem.front.quotation_system.products.template-parts.normal')
	    						@endif

		    				</div>
		    			</div>
	    			</div>
    			</div>

    		</div>

    	</div>

    	<template id="cart">
    		<hr :class="{ hr_geista_img_des_a01 : model_id == 65 }">
	    	<div class="container" style="min-height: 4.2rem">
	    		<div class="row" id="result-selected">
	    			<div class="col-xs-12 col-sm-6 pull-right">
	    				<span v-show="show_total_price" class="total-price">
	    					<span class="price">@{{ totalPrice }}</span><span class="unit"> {{ __('screen-cart.THB') }}</span>{{-- Edit BP_O2OQ-7 hainp 20200727 --}}
	    				</span>
	    				<button class="btn btn-default c-btn large" id="add-to-cart" :disabled="checkDisabledAddToCart" v-on:click="add__cart" >{{ __('screen-select.add_to_cart') }}</button>
	    			</div>
	    		</div>
	    	</div>
    	</template>

    	<v-dialog :click-to-close="false"></v-dialog>
    </div>
@endsection
@section('script')
    @parent

    <script>
    	var slug_name = '{{ $ctg->slug_name }}',
    		ctg_id = '{{ $ctg->ctg_id }}',
    		lang = '{{str_replace('_', '-', app()->getLocale())}}',
    		app = null,
    		lang_text = {
    			'model_not_found': '{{ __('screen-select.model_not_found') }}',
			    'option_not_found': '{{ __('screen-select.option_not_found') }}',
			    'number_validate_msg': '{{ __('screen-select.number_validate_msg') }}',
			    'left_pict_msg': '{{ __('screen-select.left_pict_msg') }}',
			    'cancel': '{{ __('screen-select.cancel') }}',
			    'ok': '{{ __('screen-select.ok') }}',
			    'side_panel': '{{ __('screen-select.side_panel') }}',
			    'added_to_cart': '{{ __('screen-select.added_to_cart') }}',
			    'session_expired': '{{ __('messages.session_expired') }}'
    		}

            $('.tooltip-wrapper').on('touchstart',function(e) {
              $('.tooltip-wrapper').not(this).removeClass('hover');
              $(this).toggleClass('hover');
            });

        $(function(){
            var product_model_left = $(".product_model").offset().left;
            if ($(window).width() > 1025 && product_model_left < 160) {
                $(".product_model").css("margin-left", 160 - product_model_left + 'px');
                $(".product_model").css("margin-right", 160 - product_model_left + 'px');
            }
        });
    </script>

    @if($ctg->ctg_id == 3)
		<script src="{{asset('tostem/front/quotation_system/products/product_giesta.js')}}"></script>
	@else
		<script src="{{asset('tostem/front/quotation_system/products/product.js')}}"></script>
	@endif

@endsection