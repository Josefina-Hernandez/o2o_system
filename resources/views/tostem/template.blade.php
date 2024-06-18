<!doctype html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name='csrf-token' content='{{ csrf_token() }}'>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{asset('css/app.css')}}" >
    <link rel="stylesheet" href="{{asset('tostem/common/css/tostem.css')}}">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3GJJXFF3HK"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-3GJJXFF3HK');
    </script>
    <!-- End Google tag (gtag.js) -->

    @yield('head')
</head>
<body class="@yield('class-body') language-{{app()->getLocale()}}" @yield('attr-body')> {{-- Add edit - BP_O2OQ-11 - HUNGLM - 20200924 --}}
@yield('after_open_body')

@yield('header')

@yield('main')

@yield('footer')
<div class="loader center" id="loading">
	<div class="img-loader">
		<div class="spinner-border"><span class="sr-only">Loading..</span></div>
	</div>

</div>
<script src="{{asset('js/app.js')}}" ></script>
<script>
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': _token
        }
    });
    var _base_app = '{{url('')}}';
    var lang = '{{str_replace('_', '-', app()->getLocale())}}';
    var _urlBaseLang;
    if (lang == 'en') {
        _urlBaseLang = _base_app;
    } else {
        _urlBaseLang = _base_app + '/' + lang;
    }
    var current_url = '{{url()->current()}}';
    var _loading = $('#loading');

    //active menu
    $('.navbar-collapse ul li').each(function(index, item) {
        var href_a = $(item).find('a').attr('href');
        if (href_a === current_url) {
            $(item).addClass('is-active')
        }
    });
</script>
<script src="{{asset('tostem/common/js/tostem.js')}}"></script>
@yield('script')
@yield('before_close_body')
</body>
</html>
