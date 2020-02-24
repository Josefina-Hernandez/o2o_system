<header id="site-header">
	<div class="fixed-top">
		<div class="container">
			<div class="navbar navbar-default navbar-fixed-top">
				<div class="row block-language">
					<div class="container">
						<div class="col-xs-12 col-sm-12">
							<div class="pull-right">
								<ul class="language-chooser language-chooser-text qtranxs_language_chooser" id="qtranslate-chooser">
									<li class="lang-en active">
										<a href="/en/" hreflang="en" title="English (en)" class="qtranxs_text qtranxs_text_en"><span>EN</span></a>
									</li>
									<li class="lang-th">
										<a href="https://www.tostemthailand.com/th/" hreflang="th" title="Thai (th)" class="qtranxs_text qtranxs_text_th"><span>TH</span></a>
									</li>
									@if(\Auth::check())
										@php
											$user = Auth::user();
										@endphp
										<li>
											<span class="login-name"> {{ $user->name }}</span>
											<a class="logout" href="{{ route('tostem.front.logout') }}">Logout</a>
										</li>
									@endif
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="row block-header">
					<div class="container">
						<div class="col-xs-12 col-sm-3"><a href="{{ route('tostem.front.index') }}">
								<img src="https://www.tostemthailand.com/wp-content/themes/blankslate/img/logo.png" class="img img-responsive">
							</a></div>
					</div>
				</div>
				<div class="row block-menu">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<!--<a class="navbar-brand" href="#">Project name</a>-->
						</div>

						<div class="navbar-collapse collapse ">

							<ul class="nav navbar-nav">
								{!! HelpersFront::breadcrumbs() !!}
								<li class="is-active quotation-link"><a href="#">QUOTATION</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>