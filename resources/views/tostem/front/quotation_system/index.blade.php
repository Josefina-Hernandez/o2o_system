@extends("tostem.front.template")
@section('head')
    @parent
    <link rel="stylesheet" href="{{asset('tostem/front/quotation_system/quotation.css')}}">
@endsection

@section('content')
    <div class="page quotation-system" id="page">
    	<div class="main-img">
			<div class="container">
				<div class="wrap">
					<div class="list-category" >
						@foreach($categories as $category)
							<a href="{{route('tostem.front.quotation_system.product', $category->slug_name)}}">
								<div class="item">
									<button class="c-btn black" >
										{{ $category->ctg_name }}
									</button>
								</div>
							</a>
						@endforeach

						{{--<div class="item" v-for="item in items" :key="item.ctg_id">
							<button
								class="c-btn black"
								:data-id="item.ctg_id"
								v-on:click="selectItem">
								@{{ item.ctg_name }}
							</button>
						</div>--}}
					</div>
					<div class="background-img">
						<img src="{{ asset('tostem\img\data\House perspective.jpg') }}" class="img-responsive">
					</div>
				</div>
    		</div>

    	</div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
	var site_url = '{{ url('/') }}';
	var lang = '{{str_replace('_', '-', app()->getLocale())}}';
	/*var quotation_vue = new Vue({
        el: '#page',
        data: {
            items  : [],
            ctg_id : null
        },
        created: function () {
        	axios.get(site_url + '/quotation_system/fetch')
        		.then(function (response) {
				    quotation_vue.items = response.data;
				});
        },
        methods: {
        	selectItem: function(e){
				quotation_vue.ctg_id = e.target.getAttribute('data-id');
				axios.post(site_url + '/quotation_system/save/quotation', {
                    'ctg_id' : quotation_vue.ctg_id
                }).then(function () {
                	window.location.href = site_url + '/quotation_system/product';
                })
			},
        }
    });*/
</script>
@endsection