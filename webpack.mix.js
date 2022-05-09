let mix = require('laravel-mix');

mix.webpackConfig({devtool: "source-map"});

mix/*.js('resources/assets/js/app.js', 'public/js/')
    .sass('resources/assets/sass/app.scss', 'public/css/')

    .copyDirectory('resources/assets/tostem/fonts', 'public/tostem/fonts')

    .js('resources/assets/tostem/common/js/tostem.js', 'public/tostem/common/js/')
    .sass('resources/assets/tostem/common/scss/tostem.scss', 'public/tostem/common/css/')*/

    // ==> Start front <==
    .js('resources/assets/tostem/front/cart/cart.js', 'public/tostem/front/cart/')
    .sass('resources/assets/tostem/front/cart/cart.scss', 'public/tostem/front/cart/')


	//login
    .sass('resources/assets/tostem/front/login/login.scss', 'public/tostem/front/login')

    //quotation
    .sass('resources/assets/tostem/front/quotation_system/quotation.scss', 'public/tostem/front/quotation_system')
    .js('resources/assets/tostem/front/quotation_system/quotation.js', 'public/tostem/front/quotation_system/').vue() //Add add popup status New/Reform hainp 20200922
     
    //product
    .js('resources/assets/tostem/front/quotation_system/products/product.js', 'public/tostem/front/quotation_system/products')
    .js('resources/assets/tostem/front/quotation_system/products/product_giesta.js', 'public/tostem/front/quotation_system/products')
    .sass('resources/assets/tostem/front/quotation_system/products/product.scss', 'public/tostem/front/quotation_system/products')
     

    // == End front ==

    // ==> Start Admin <==
    // 
    .js('resources/assets/tostem/common/js/tostem_admin.js', 'public/tostem/common/js/')
    // User
   .sass('resources/assets/sass/users.scss', 'public/css')
   .js('resources/assets/js/users.js', 'public/js')
    //
     // Price maintenance
    .js('resources/assets/tostem/admin/pmaintenance/js/pmaintenance.js', 'public/tostem/admin/pmaintenance/js/')
    .js('resources/assets/tostem/admin/pmaintenance/js/jquery-ui.js', 'public/tostem/admin/pmaintenance/js/')
    .js('resources/assets/tostem/admin/pmaintenance/js/calendar.js', 'public/tostem/admin/pmaintenance/js/')
    .sass('resources/assets/tostem/admin/pmaintenance/scss/pmaintenance.scss', 'public/tostem/admin/pmaintenance/css/')
    .sass('resources/assets/tostem/admin/pmaintenance/scss/jquery-ui.scss', 'public/tostem/admin/pmaintenance/css/')
    //
    
    // Quotation Result
     .js('resources/assets/tostem/admin/quotationresult/js/quotationresult.js', 'public/tostem/admin/quotationresult/js/')
    .sass('resources/assets/tostem/admin/quotationresult/scss/quotationresult.scss', 'public/tostem/admin/quotationresult/css/')
    
    // 
    
    //Access Analysis
     .js('resources/assets/tostem/admin/accessanalysis/js/accessanalysis.js', 'public/tostem/admin/accessanalysis/js/')
    .sass('resources/assets/tostem/admin/accessanalysis/scss/accessanalysis.scss', 'public/tostem/admin/accessanalysis/css/')
    //
    
    .options({
        processCssUrls: false
    });


    // windows


    // == End Admin ==
    ;
