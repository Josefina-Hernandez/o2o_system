<!doctype html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name='csrf-token' content='{{ csrf_token() }}'>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{asset('css/app.css')}}" >
    <link rel="stylesheet" href="{{asset('tostem/common/css/tostem.css')}}">
    @yield('head')
</head>
<body class="@yield('class-body')" @yield('attr-body')>
@yield('after_open_body')

@yield('header')

@yield('main')

@yield('footer')
<div class="loader center" id="loading">
    <img src="{{url('tostem/img/icon/Spinner-1s-200px.svg')}}" alt="loader" class="img-loader">
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
    var _loading = $('#loading');
</script>
<script src="{{asset('tostem/common/js/tostem.js')}}"></script>
@yield('script')
@yield('before_close_body')
</body>
</html>
