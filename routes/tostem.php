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

    });

});






Route::group(['prefix' => $locale, 'where' => ['locale' => '[a-zA-Z]{2}']], function() {
	// fronted
	Route::name('tostem.front')->namespace('Tostem\Front')->group(function () {
	    Route::get('/', ['as' => '.index', function() {
            return view('tostem.front.index');
        }]);

	    Route::prefix('/quotation_system')->name('.quotation_system')->group(function () {
            Route::get('/', ['as' => '', 'uses' => 'QuotationController@index']);
            //Route::get('/fetch', ['as' => '.fetch', 'uses' => 'QuotationController@fetchItemList']);
            Route::post('/save/{key}', ['as' => '.save', 'uses' => 'QuotationController@save']);
                //product
            Route::prefix('{slug_name}')->group(function () {
                Route::prefix('/product')->name('.product')->group(function () {
                    Route::get('', ['as' => '', 'uses' => 'ProductController@index']);
                    Route::get('/list', ['as' => '.get_products', 'uses' => 'ProductController@get_products']);

                    Route::post('/get_models', ['as' => '.get_models', 'uses' => 'ProductController@get_models' ]);
                    Route::post('/get_colors', ['as' => '.get_colors', 'uses' => 'ProductController@fetchColors' ]);
	    		Route::post('/get_options', ['as' => '.get_options', 'uses' => 'ProductController@fetchOptions' ]);
	    		Route::post('/get_spec_stran', ['as' => '.get_spec_stran', 'uses' => 'ProductController@getSpecTrans' ]);
	    		Route::get('/get_selling_spec', ['as' => '.get_selling_spec', 'uses' => 'ProductController@getDataSellingSpec' ]);

                });
            });
	    });

        Route::prefix('cart')->name('.cart')->group(function (){
            Route::get('/', ['as' => '.index', 'uses' => 'CartController@index']);
            Route::post('/','CartController@add')->name('.add');
            Route::post('/update_quantity','CartController@update_quantity')->name('.update_quantity');
            Route::get('/details','CartController@details')->name('.details');
            Route::delete('/{id}','CartController@delete')->name('.delete');
            Route::post('/mail', ['as' => '.mail', 'uses' => 'CartController@mail']);
            Route::match(['get', 'post'],'/downloadpdf', ['as' => '.downloadpdf', 'uses' => 'CartController@downloadpdf']);
            Route::get('/downloadcsv', ['as' => '.downloadcsv', 'uses' => 'CartController@downloadcsv']);
        });


	    Route::get('/transition', ['as' => '.login', 'uses' => 'LoginController@showLoginForm']);
	    Route::post('/login', ['as' => '.auth', 'uses' => 'LoginController@login']);
	    Route::get('/logout', ['as' => '.logout', 'uses' => 'LoginController@logout']);

	});
});

use App\Lib\ImportDataDb;
Route::get('convert_txt', function () {
    $folder_path = storage_path() . DIRECTORY_SEPARATOR . 'import_data' . DIRECTORY_SEPARATOR;
    echo $folder_path;
    $files = glob($folder_path . "[!~$]*.xlsx");
    $import = new ImportDataDb;

    foreach ($files as $file) {
        if (file_exists($file)) {
            $txt_file = $import->export_txt($file, true);
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
