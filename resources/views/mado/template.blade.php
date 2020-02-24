<!doctype html>
<html lang='ja'>
    <head>
        <meta charset='utf-8'>
        <meta name='csrf-token' content='{{ csrf_token() }}'>
        @yield('head')

        <title>@yield('title')</title>
        {{-- GAタグ --}}
        @if ( Schema::hasColumn('shops', 'shop_type') === false )
	        <!-- Google Tag Manager -->
	        <script>
	            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	            })(window,document,'script','dataLayer','GTM-PFSZP52');
	        </script>
	        <!-- End Google Tag Manager -->
	        <!-- Google Tag Manager -->
	        <script>
	            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	            })(window,document,'script','dataLayer','GTM-PJDXMB');</script>
	            <!-- End Google Tag Manager -->
	            <!-- Google Tag Manager -->
	            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	            })(window,document,'script','dataLayer','GTM-TTNGHNG');
	        </script>
	        <!-- End Google Tag Manager -->
        @endif
    </head>

    @yield('body')
    {{-- GAタグ --}}
    @if ( Schema::hasColumn('shops', 'shop_type') === false )
    <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PJDXMB"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PFSZP52"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif
    @yield('header')

    @yield('main')

    @yield('footer')

    @yield('script')

    {{-- GAタグ --}}
    <script type="text/javascript">
      (function () {
        var tagjs = document.createElement("script");
        var s = document.getElementsByTagName("script")[0];
        tagjs.async = true;
        tagjs.src = "//s.yjtag.jp/tag.js#site=kFbBZFJ";
        s.parentNode.insertBefore(tagjs, s);
      }());
    </script>
    <noscript>
      <iframe src="//b.yjtag.jp/iframe?c=kFbBZFJ" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
    </noscript>
    @if ( Schema::hasColumn('shops', 'shop_type') === false )
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TTNGHNG"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
	@endif
    </body>
</html>
