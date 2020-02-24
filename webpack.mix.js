let mix = require('laravel-mix');


mix/*.js('resources/assets/js/app.js', 'public/js/')
    .sass('resources/assets/sass/app.scss', 'public/css/')


    .js('resources/assets/tostem/common/js/tostem.js', 'public/tostem/common/js/')
    .sass('resources/assets/tostem/common/scss/tostem.scss', 'public/tostem/common/css/')*/

    // ==> Start front <==
    .js('resources/assets/tostem/front/cart/cart.js', 'public/tostem/front/cart/')
    .sass('resources/assets/tostem/front/cart/cart.scss', 'public/tostem/front/cart/')


	//login
    .sass('resources/assets/tostem/front/login/login.scss', 'public/tostem/front/login')

    //quotation
    .sass('resources/assets/tostem/front/quotation_system/quotation.scss', 'public/tostem/front/quotation_system')

    //product
    .js('resources/assets/tostem/front/quotation_system/products/product.js', 'public/tostem/front/quotation_system/products')
    .sass('resources/assets/tostem/front/quotation_system/products/product.scss', 'public/tostem/front/quotation_system/products')


    // == End front ==

    // ==> Start Admin <==
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

    .options({
        processCssUrls: false
    });


    // windows


    // == End Admin ==
    ;