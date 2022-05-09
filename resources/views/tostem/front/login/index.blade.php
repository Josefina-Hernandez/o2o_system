@extends("tostem.front.template")
@section('head')
    @parent
    <link rel="stylesheet" href="{{asset('tostem/front/login/login.css')}}">
@endsection

@section('content')
	<div class="page-login" id="page-login">
		<div class="form-center">
			<div class="form-wrap">

				<form @submit="checkForm" id="createAdministrator">
			    	<div class="top-part">
			    		<dl class="loginBlock text-center">
				    		<a href="{{ route('tostem.front.quotation_system') }}" class="btn-quotation">{{ __('screen-login.go_to_quotation') }}</a>
				    	</dl>

				    	<dl class="loginBlock">
					    	<a role="button" data-toggle="collapse" href="#collapse-content" aria-expanded="false" aria-controls="collapse-content">
					    		{{ __('screen-login.to_seller') }}
					    	</a>
					    </dl>
			    	</div>

			    	<div class="bottom-part">
			    		<div class="collapse-content collapse" id="collapse-content">
							<div class="content-form">
								<div class="col-md-12 text-center">
									<p>
										<span class="errors" style="color: red">@{{ error_auth }}</span>
									</p>
								</div>
								<div class="form-group row">
									<label for="login_id" class="col-sm-3 col-form-label" style="line-height: 231%;padding-left: 59px;">{{ __('screen-login.user') }}</label>
									<div class="col-sm-9">
										<input type="text" name="{{config('const.form.admin.lixil.login.LOGIN_ID')}}"
											   class="form-control" placeholder="{{ __('screen-login.id') }}" id="login_id">
										<p class="errors">@{{ errors.login_id }}</p>
									</div>
								</div>

								<div class="form-group row">
									<label for="inputPassword" class="col-sm-3 col-form-label" style="line-height: 231%;padding-left: 59px;">{{ __('screen-login.pass') }}</label>
									<div class="col-sm-9">
										<input type="password" class="form-control" id="password" placeholder="{{ __('screen-login.pass') }}" name="{{ config('const.form.admin.lixil.login.PASSWORD') }}">
										<p class="errors">@{{ errors.password }}</p>
									</div>
								</div>

								<div class="form-group row">
									<div class="text-right col-xs-12">
										{!! Form::submit( __('screen-login.go'), ['class' => 'loginBtn']) !!}
									</div>
								</div>
							</div>

				    	</div>
			    	</div>
				</form>

			</div>
		</div>
	</div>
	<div class="container">
		<div>
			<img style="float: right; padding: 0px 15px;" src="{{ asset('/tostem/img/Part of LIXIL/縲訓ART OF LIXIL縲阪Ο繧ｴ・医ョ繧ｸ繧ｿ繝ｫ逕ｨ・噂part_of_lixil_logo_primary_aw_rgb-140x100.png') }}" class="img img-responsive">
		</div>
	</div>
@endsection
@section('script')
	@parent
	<script>
		var login_vue = new Vue({
			el: '#page-login',
			mounted() {
				console.log('Component mounted.')
			},
			data: {
				errors: {
					login_id: '',
					password: ''
				},
				state: {
					login_id: '',
					password: ''
				},
				error_auth: ''
			},
			methods:{
				checkForm: function (e) {
					let _this = this;
					_this.error_auth = '';
					_this.errors.login_id = '';
					_this.errors.password = '';

					_this.login_id = $('#login_id').val();
					_this.password = $('#password').val();
					if (!_this.login_id) {
						_this.errors.login_id = '{{ __('screen-login.user_required') }}';
					}
					if (!_this.password) {
						_this.errors.password = '{{ __('screen-login.pass_required') }}';
					}

					if (_this.login_id && _this.password) {
						let $data_form = {
							_token: _token,
							'login_id': $('#login_id').val(),
							'password': $('#password').val()
						};
						axios.post('/login', $data_form).then(function(response) {
							//window.location.href = response.request.responseURL;
							axios.get('/generate-token').then(function(response) {
								window.location.href = _urlBaseLang + '/quotation_system'
							})
						}, function(error) {
							console.log(error);
							_this.error_auth = '{{ __('screen-login.incorrect_user_pass') }}';
						});
					}

					e.preventDefault();
				}
			}
		});
	</script>
@endsection