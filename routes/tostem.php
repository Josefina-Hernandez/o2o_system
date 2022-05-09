<?php

$locale = Request::segment(1);

if (in_array($locale, config('app.app_locale'))) {
    \App::setLocale($locale);

} else {
    $locale = null;
}

// Admin
Route::prefix('admin')->name('tostem.admin')->namespace('Tostem\Admin')->group(function () {
    Route::get('/', ['as' => '.index', 'uses' => 'DoorController@index']);
});


Route::prefix('admin')->name('admin')->namespace('Mado\Admin')->group(function () {
    // ログイン/ログアウト
    Route::get('/login', ['as' => '.login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('/login', ['as' => '.auth', 'uses' => 'LoginController@login']);
    Route::post('/logout', ['as' => '.logout', 'uses' => 'LoginController@logout']);
});


Route::middleware('auth', 'can:suitableShop,shop_id')->prefix('admin/shop/{shop_id}')->name('admin.shop')->group(function ($group) {

    Route::prefix('/users')->name('.users')->namespace('Mado\Admin\Lixil')->group(function () {

        Route::get('/', 'UsersController@index')->name('.usershop');
        Route::post('/save', 'UsersController@save')->name('.saveusershop');
        Route::post('/changepass', 'UsersController@changepass')->name('.changepassshop');

    });

    Route::prefix('/quotation-result')->name('.quotation-result')->namespace('Tostem\Admin')->group(function () {
        // 加盟店一覧
        Route::get('/', ['as' => '', 'uses' => 'QuotationResultController@index'])->name('.index');
        Route::get('/download-file', ['as' => '', 'uses' =>'QuotationResultController@downloadfile'])->name('.download');
        Route::post('/download-file', ['as' => '', 'uses' =>'QuotationResultController@checkAuth'])->name('.download');
        Route::get('/search-data', ['as' => '', 'uses' =>'QuotationResultController@searchdata'])->name('.searchdata');
        Route::post('/load-view-data', ['as' => '', 'uses' =>'QuotationResultController@loadviewdata'])->name('.viewdata');

    });



});

Route::middleware('auth', 'can:lixil')->prefix('admin/lixil')->name('admin.lixil')->namespace('Mado\Admin\Lixil')->group(function () {
    /**
     * Employee
     */
    Route::prefix('/employee')->name('.employee')->group(function () {

        // 加盟店一覧
        Route::get('/', ['as' => '', 'uses' => 'EmployeeController@index']);
    });

    Route::prefix('/users')->name('.users')->group(function () {


        Route::get('/', 'UsersController@index')->name('.users');
        Route::post('/save', 'UsersController@save')->name('.saveusers');
        Route::post('/delete', 'UsersController@delete')->name('.deleteuser');
        Route::post('/changepass', 'UsersController@changepass')->name('.changepass');
    });
});

Route::middleware('auth', 'can:lixil')->prefix('admin/lixil')->name('admin.lixil')->namespace('Tostem\Admin')->group(function () {

    /**
     * price maintenance
     */
    Route::prefix('/price-maintenance')->name('.price-maintenance')->group(function () {

        // 加盟店一覧
        Route::get('/', ['as' => '', 'uses' => 'PriceMaintenanceController@index'])->name('.index');
        Route::post('/file', ['as' => '', 'uses' =>'PriceMaintenanceController@upload_file'])->name('.upload');
        Route::post('/check-download-file', ['as' => '', 'uses' =>'PriceMaintenanceController@CheckdownloadFile'])->name('.checkdownload');
        Route::get('/download-file', ['as' => '', 'uses' =>'PriceMaintenanceController@DownloadFile'])->name('.download');
        Route::post('/search-data-time', ['as' => '', 'uses' =>'PriceMaintenanceController@searchdata'])->name('.searchdata');
        Route::post('/uploadstatus', ['as' => '', 'uses' =>'PriceMaintenanceController@upload_status'])->name('.uploadstatus');
        Route::post('/viewalldata', ['as' => '', 'uses' =>'PriceMaintenanceController@viewalldata'])->name('.viewalldata');
        Route::get('/downloadlog', ['as' => '', 'uses' =>'PriceMaintenanceController@downloadlog'])->name('.downloadlog');

    });


    Route::prefix('/quotation-result')->name('.quotation-result')->group(function () {

        // 加盟店一覧
        Route::get('/', ['as' => '', 'uses' => 'QuotationResultController@index'])->name('.index');
        Route::get('/download-file', ['as' => '', 'uses' =>'QuotationResultController@downloadfile'])->name('.download');
        Route::post('/download-file', ['as' => '', 'uses' =>'QuotationResultController@checkAuth'])->name('.download');
        Route::get('/search-data', ['as' => '', 'uses' =>'QuotationResultController@searchdata'])->name('.searchdata');
        Route::post('/load-view-data', ['as' => '', 'uses' =>'QuotationResultController@loadviewdata'])->name('.viewdata');

    });

    Route::prefix('/access-analysis')->name('.access-analysis')->group(function () {

        // 加盟店一覧
        Route::get('/', ['as' => '', 'uses' => 'AccessAnalysisController@index'])->name('.index');
        Route::get('/download-file', ['as' => '', 'uses' =>'AccessAnalysisController@downloadfile'])->name('.download');
        Route::post('/download-file', ['as' => '', 'uses' =>'AccessAnalysisController@checkAuth'])->name('.download');
        Route::get('/search-data', ['as' => '', 'uses' =>'AccessAnalysisController@searchdata'])->name('.searchdata');
       // Route::post('/load-view-data', ['as' => '', 'uses' =>'QuotationResultController@loadviewdata'])->name('.viewdata');

    });


});






Route::group(['prefix' => $locale, 'where' => ['locale' => '[a-zA-Z]{2}'], 'middleware' => ['front.tokenexpired', 'front.check_session_new_or_reform']], function() { //Add add popup status New/Reform hainp 20200924

	// fronted
	Route::name('tostem.front')->namespace('Tostem\Front')->group(function () {
	   Route::get('/', ['as' => '.index', 'uses' => 'LoginController@showLoginForm']);
	   Route::get('/check-token-expired', ['as' => '.check-token-expired', function (){
	   	return 'true';
	   }]);

       //Add add popup status New/Reform hainp 20200922
        Route::prefix('/check-session-new-or-reform')->name('.check_session_new_or_reform')->group(function () {
            Route::GET('/', ['as' => '', function () {
                return 'true';
            }]);
            Route::POST('/generate', ['as' => '.generate', function () {
                return 'true';
            }]);
        });
       //Add End popup status New/Reform hainp 20200922

	   Route::get('/generate-token', ['as' => '.generate-token', function (){
	   	\Session()->regenerateToken();
	   }]);

		Route::get('/get-size-limit/{product_id}', 'ProductController@getSizeLimit');

	    Route::prefix('/quotation_system')->name('.quotation_system')->group(function () {
            Route::get('/', ['as' => '', 'uses' => 'QuotationController@index']);
            //Route::get('/fetch', ['as' => '.fetch', 'uses' => 'QuotationController@fetchItemList']);
            Route::post('/save/{key}', ['as' => '.save', 'uses' => 'QuotationController@save']);
            //product
            Route::prefix('{slug_name}')->group(function () {
                Route::prefix('/product')->name('.product')->group(function () {
		    		Route::get('',                                      'ProductController@index')->name('.index');
		    		Route::get('/list',                                 'ProductController@get_products');
		    		Route::post('/get_models',                          'ProductController@get_models');
		    		Route::post('/get_options',                         'ProductController@fetchOptions');
		    		Route::post('/get_spec_stran',                      'ProductController@getSpecTrans');
		    		Route::get('/get_selling_spec',                     'ProductController@getDataSellingSpec');
		    		Route::post('/get_cornerfix_amount',                'ProductController@getCornerfixAmount');
		    		Route::post('/get_giesta_side_panel',               'ProductController@getGiestaSidePanel');
		    		Route::post('/get_giesta_hidden_data',              'ProductController@getGiestaHiddenData');
		    		Route::post('/get_giesta_handle_type',              'ProductController@getGiestaHandleType');
		    		Route::post('/get_celling_code_option',             'ProductController@getCellingCodeOption');
		    		Route::post('/get_config_stack_number',             'ProductController@getConficStackNumber');
		    		Route::post('/get-config-display-image-description','ProductController@getConfigDisplayImageDescription');
		    		Route::get('/get_config_alway_display_spec_item',   'ProductController@getConfigAlwayDisplaySpecItem');
		    		Route::get('/get_config_rule_compare_item_spec',    'ProductController@getConfigRuleCompareItemSpec');
		    		Route::post('/get_config_clone_option_at_product',  'ProductController@getConfigCloneOptionAtProudct');//Add edit 
                    Route::get('/get_submenu',                          'ProductController@getSubmenu');
                });
            });
	    });

        Route::prefix('cart')->name('.cart')->group(function (){
            Route::get('/', ['as' => '.index', 'uses' => 'CartController@index']);
            Route::post('/add-to-cart','CartController@add')->name('.add-to-cart');
            Route::post('/quotation','CartController@createQuotation')->name('.quotation');
            Route::post('/update_quantity','CartController@update_quantity')->name('.update_quantity');
            Route::post('/update_reference_no','CartController@update_reference_no')->name('.update_reference_no'); //Add BP_O2OQ-7 hainp 20200701
            Route::get('/details','CartController@details')->name('.details');
            Route::delete('/{id}','CartController@delete')->name('.delete');
            Route::match(['get', 'post'], '/get_quantity_cart', ['as' => '.get_quantity_cart', 'uses' => 'CartController@get_quantity_cart']);
            Route::post('/mail', ['as' => '.mail', 'uses' => 'CartController@mail']);
            Route::match(['get', 'post'],'/downloadpdf', ['as' => '.downloadpdf', 'uses' => 'CartController@downloadpdf']);
            Route::get('/downloadcsv', ['as' => '.zipFilesAndDownload', 'uses' => 'CartController@zipFilesAndDownload']);
        });


	    Route::get('/transition', ['as' => '.login', 'uses' => 'LoginController@showLoginForm']);
	    Route::post('/login', ['as' => '.auth', 'uses' => 'LoginController@login']);
	    Route::get('/logout', ['as' => '.logout', 'uses' => 'LoginController@logout']);

	});
});

//route::post('language/change', ['as' => 'language.change', 'uses' => 'LanguageConroller@change' ]);

use App\Lib\ImportDataDb;
Route::get('convert_txt', function () {
    $folder_path = storage_path() . DIRECTORY_SEPARATOR . 'import_data' . DIRECTORY_SEPARATOR . 'Excel' . DIRECTORY_SEPARATOR;
    $files = glob($folder_path . "[!~$]*.xlsx");
    $import = new ImportDataDb;
    $folder_save_txt = storage_path() . DIRECTORY_SEPARATOR . 'import_data' . DIRECTORY_SEPARATOR;
    if(count($files) == 0)
    {
        echo 'File excel not exists';
    }
    foreach ($files as $file) {
        if (file_exists($file)) {
            $txt_file = $import->export_txt($file, true);
            \File::move($txt_file,$folder_save_txt.pathinfo($txt_file, PATHINFO_FILENAME).'.txt');
            if ($txt_file != false) {
                echo 'File: ' . $txt_file . ' <span style="color:green; font-size: 24px">have converted!</span><br>';
            } else {
                echo 'File: ' . $txt_file . ' <span style="color:red; font-size: 24px">haven\'t converted!</span><br>';
            }
        } else {
            echo 'File not exists: ' . $file . '<br>';
        }
    }
});


Route::post('/check-user-login-admin', 'CheckLoginUserController@checkUserLoginAdmin')->name('.checkuserloginadmin');
Route::post('/check-user-login', 'CheckLoginUserController@checkUserLogin')->name('.checkuserlogin');