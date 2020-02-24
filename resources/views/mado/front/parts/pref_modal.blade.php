<!doctype html>
<html lang='ja'>
    <head>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
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
        })(window,document,'script','dataLayer','GTM-TTNGHNG');</script>
        <!-- End Google Tag Manager -->

        <meta charset='utf-8'>
        <meta name='csrf-token' content='{{ csrf_token() }}'>
        <link rel="stylesheet" href="{{ asset('/common/css/reset.css') }}">
        <link rel="stylesheet" href="{{ asset('/common/css/common.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/modal.css') }}">
        <title>お近くの店舗を探す｜LIXIL簡易見積りシステム</title>
        <meta name="description" content="お近くのLIXIL簡易見積りシステムのサービスを取り扱う加盟店舗を検索できます。">
    </head>
    <body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PJDXMB"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    @include ('mado.front.parts.japan_map')

    <script src="{{ asset('js/app.js') }}" ></script>
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
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TTNGHNG"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    </body>
</html>
