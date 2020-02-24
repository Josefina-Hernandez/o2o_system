@extends("tostem.front.template")
@section('head')
    @parent
    <link rel="stylesheet" href="{{asset('tostem/front/quotation_system/products/product.css')}}">
@endsection

@section('content')
	<div class="page" id="page">
    	<div class="container">

    		<div class="row">
    			<template id="list-product">
    				<div class="col-xs-12 col-sm-2">
	    				<div class="product-list">
	    					<div class="product" v-for="(product, index) in products" :key="product.product_id">
								<button
									:class="[{'black' : product.product_id === product_id}, 'c-btn large']"
									:data-product-id="product.product_id"
									@click="selectProduct(product.product_id, product.product_name)">
									@{{ product.product_name }}
								</button>
							</div>
	    				</div>
	    			</div>
    			</template>

    			<template id="model-list">
					<div class="col-xs-12 col-sm-10" id="slide">
						<div class="slick-carousel">
							<slick class="app-carousel" ref="carousel" :options="slickOptions">
								<div class="model-item" v-for="model in models">
									<a
										@click="selectModels(model.m_model_id)"
										:data-model-id="model.m_model_id"
										:class="{ active : model_id == model.m_model_id }"
										><img :src="'/tostem/img/data/' + model.img_path + '/' + model.img_name" class="img-responsive">
									</a>
								</div>
							</slick>
						</div>
					</div>
				</template>
    		</div>

    		<template v-if="model_id">
    			<div class="row">

	    			<div class="col-xs-12">
	    				<hr>
	    			</div>

	    			<div class="col-xs-12 col-sm-6" id="featured-img" v-if="color_id">
	    				<img src="https://www.tostemthailand.com/wp-content/uploads/2018/01/9_Window4_Natural_Black.png" class="img-responsive">
	    			</div>

	    			<div class="col-xs-12 col-sm-6 pull-right">

	    				<div class="option-group" v-if="product_name" data-group-name="product_name">
	    					<button class="btn c-btn large black">@{{ product_name }}</button>
	    				</div>

	    				<template id="list-spec">
	    					<div class="option-group inline" v-for="(value, propertyName, index) in specs" :data-group-name="propertyName">
	    						<template v-if="value.data.length == 1">
	    							<button
			    						v-for="item in value.data"
			    						@click="selectSpec(propertyName, item)"
			    						:class="[{'black' : Object.keys(spec_selected).includes(propertyName) && spec_selected[propertyName] == item}, 'btn c-btn large']"
			    						:data-spec-id="item"
			    						:data-spec-code="propertyName"
			    						>@{{ list_spec_trans[item] }}
			    					</button>
	    						</template>

	    						<template v-else-if="value.data.length == 2">
	    							<button class="btn c-btn large black">Label of spec</button>
	    							<ul class="option">
	    								<li
				    						v-for="item in value.data"
				    						@click="selectSpec(propertyName, item)"
				    						:data-spec-id="item"
				    						:data-spec-code="propertyName"
				    						>
				    						<button :class="[{'black' : Object.keys(spec_selected).includes(propertyName) && spec_selected[propertyName] == item}, 'btn c-btn']">@{{ list_spec_trans[item] }}</button>
				    					</li>
	    							</ul>
	    						</template>

	    						<template v-else>
	    							<button class="btn c-btn large black">Label of spec</button>
		    						<ul class="option">
		    							<li>
		    								<select @change="selectSpecOnchange($event)" :data-spec-code="propertyName">
			    								<option value="">Choose</option>
			    								<option
			    									v-for="item in value.data"
						    						@click="selectSpec(propertyName, item)"
						    						:class="[{'black' : value.data.length == 1}, 'btn c-btn large']"
						    						:value="item"
						    						>@{{ list_spec_trans[item] }}
						    					</option>
			    							</select>
		    							</li>
		    						</ul>
	    						</template>
		    				</div>
	    				</template>

	    				<template id="list-color" v-if="colors">
	    					<div class="option-group">
		    					<button class="btn c-btn large black">Color <span v-if="color_name">- @{{ color_name }}</span></button>
		    					<ul class="option">
		    						<li v-for="color in colors" :key="color.m_color_id">
		    							<a @click="selectColor(color.m_color_id, color.color_name)">
		    								<img class="color-img" :src="'/tostem/img/data/Color/' + color.img_name">
		    							</a>
		    						</li>
		    					</ul>
		    				</div>
	    				</template>

	    				<template id="list-size">

	    				</template>

	    				<template id="list-option" v-if="Object.keys(spec_selected).length > 0">
	    					<div class="option-group inline" v-for="(value, propertyName, index) in options" :data-group-name="propertyName">
	    						<template v-if="value.data.length == 1">
	    							<button
			    						v-for="item in value.data"
			    						@click="selectSpecOption(propertyName, item)"
			    						:class="[{'black' : Object.keys(option_selected).includes(propertyName) && option_selected[propertyName] == item}, 'btn c-btn large']"
			    						:data-spec-id="item"
			    						:data-spec-code="propertyName"
			    						>@{{ list_spec_trans[item] }}
			    					</button>
	    						</template>

	    						<template v-else-if="value.data.length == 2">
	    							<button class="btn c-btn large black">Label of spec</button>
	    							<ul class="option">
	    								<li
				    						v-for="item in value.data"
				    						@click="selectSpecOption(propertyName, item)"
				    						:class="[{'black' : Object.keys(option_selected).includes(propertyName) && option_selected[propertyName] == item}, 'btn c-btn']"
				    						:data-spec-id="item"
				    						:data-spec-code="propertyName"
				    						>
				    						<button class="btn c-btn">@{{ list_spec_trans[item] }}</button>
				    					</li>
	    							</ul>
	    						</template>

	    						<template v-else>
	    							<button class="btn c-btn large black">Label of spec</button>
		    						<ul class="option">
		    							<li>
		    								<select @change="selectSpecOptionOnchange($event)">
			    								<option value="">Choose</option>
			    								<option
			    									v-for="item in value.data"
						    						:class="[{'black' : value.data.length == 1}, 'btn c-btn large']"
						    						:data-spec-code="propertyName"
						    						:value="item"
						    						>@{{ list_spec_trans[item] }}
						    					</option>
			    							</select>
		    							</li>
		    						</ul>
	    						</template>
		    				</div>
	    				</template>
	    			</div>
	    		</div>
    		</template>

    	</div>

    	<template id="cart" v-if="add_to_cart">
    		<hr>
	    	<div class="container">
	    		<div class="row" id="result-selected">
	    			<div class="col-xs-12 col-sm-6 pull-right">
	    				<div class="d-flex">
	    					<div class="item">
	    						<span class="price">12,450</span><span class="unit">THB</span>
	    					</div>
	    					<div class="item">
	    						<button class="btn btn-default c-btn large" id="add-to-cart">Add to cart</button>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
    	</template>
    </div>
@endsection
@section('script')
    @parent
    <script>
    	var slug_name = '{{ $ctg_slug }}';
    </script>
    <script src="{{asset('tostem/front/quotation_system/products/product.js')}}"></script>
@endsection