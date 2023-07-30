<?php

use Illuminate\Support\Facades\Route;

// utils
Route::get('clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return 'Cash Cleared';
});
Route::get('optimize', function () {
    $exitCode = Artisan::call('optimize');
    return 'Cash optimize';
});
Route::get('config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'config:cache';
});
Route::get('route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return 'route:cache';
});  // Give error
Route::get('route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return 'route:clear';
});
Route::get('view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return 'view:clear';
});
// Route::get('storage-link', function() { $exitCode = Artisan::call('storage:link');return 'StorageLink'; });
// php artisan storage:link

// Route::get('admin_notification', 'Admin\AdminNotificationController@create')->name('admin.notification');
// Route::get('pusher_notification', 'Util\PusherNotificationController@send')->name('user.notification');


// Route::post('test','Front\TestController@test');


Route::post('pdf', 'Util\PdfController@getPdf');

// Admin Panel Area
Route::group([
    'namespace' => 'Admin',
    'middleware' => ['set.local'],
    'prefix' => 'admin/{locale?}',
], function ($router) {

    // Auth
    // Auth::routes(['register' => false , 'reset' => false , 'verify' => false]);
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\LoginController@login')->name('admin.login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');

    // admin.verifications
    Route::group([
        'prefix' => 'verifications',
    ], function () {
        Route::get('/', 'VerificationController@show')->name('admin.verifications.show');
        Route::post('/', 'VerificationController@check')->name('admin.verifications.check');
    });

    // admin.subscriptions
    Route::group([
        'prefix' => 'subscriptions_verify',
    ], function () {
        Route::get('/', 'SubscriptionController@show')->name('admin.subscriptionsverify.show');
        Route::post('/', 'SubscriptionController@check')->name('admin.subscriptionsverify.check');
    });


    Route::group([
        'middleware' => ['admin', 'admin.shares', 'prevent.back.history'],
    ], function ($router) {

        // admin
        Route::get('/', 'IndexController@index')->name('admin.home');
        Route::get('form', 'IndexController@form')->name('admin.form');

        // admin.categories
        Route::group([
            'prefix' => 'categories',
        ], function () {
            Route::get('/', 'CategoryController@index')->name('admin.categories.index');
            Route::post('/', 'CategoryController@index')->name('admin.categories.index');
            Route::get('create', 'CategoryController@create')->name('admin.categories.create');
            Route::post('store', 'CategoryController@store')->name('admin.categories.store');
            Route::get('{id}/edit', 'CategoryController@edit')->name('admin.categories.edit')->where('id', '[0-9]+');
            Route::post('{id}/edit', 'CategoryController@edit')->name('admin.categories.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'CategoryController@update')->name('admin.categories.update')->where('id', '[0-9]+');
            Route::post('{id}/store_trans', 'CategoryController@storeTrans')->name('admin.categories.store_trans')->where('id', '[0-9]+');
            Route::PUT('{id}/status', 'CategoryController@setActive')->name('admin.categories.status')->where('id', '[0-9]+');
        });

        // admin.items
        Route::group([
            'prefix' => 'items',
        ], function () {
            Route::get('/', 'ItemController@index')->name('admin.items.index');
            Route::post('/', 'ItemController@index')->name('admin.items.index');
            Route::get('air/', 'ItemController@indexAir')->name('admin.items.index_air');
            Route::post('air/', 'ItemController@indexAir')->name('admin.items.index_air');
            Route::get('transport/', 'ItemController@indexTransport')->name('admin.items.index_transport');
            Route::post('transport/', 'ItemController@indexTransport')->name('admin.items.index_transport');
            Route::get('create', 'ItemController@create')->name('admin.items.create');
            Route::post('store', 'ItemController@store')->name('admin.items.store');
            Route::get('{id}/edit', 'ItemController@edit')->name('admin.items.edit')->where('id', '[0-9]+');
            Route::post('{id}/edit', 'ItemController@edit')->name('admin.items.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'ItemController@update')->name('admin.items.update')->where('id', '[0-9]+');
            Route::post('{id}/store_trans', 'ItemController@storeTrans')->name('admin.items.store_trans')->where('id', '[0-9]+');
            Route::PUT('{id}/status', 'ItemController@setActive')->name('admin.items.status')->where('id', '[0-9]+');
            Route::DELETE('{id}', 'ItemController@destroy')->name('admin.items.delete')->where('id', '[0-9]+');
        });

        // admin.items
        Route::group([
            'prefix' => 'clients',
        ], function () {
            Route::get('/', 'ClientController@index')->name('admin.clients.index');
            Route::post('/', 'ClientController@index')->name('admin.clients.index');
            // Route::get('create', 'ClientController@create')->name('admin.clients.create');
            // Route::post('store', 'ClientController@store')->name('admin.clients.store');
            Route::get('{id}/edit', 'ClientController@edit')->name('admin.clients.edit')->where('id', '[0-9]+');
            Route::post('{id}/edit', 'ClientController@edit')->name('admin.clients.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'ClientController@update')->name('admin.clients.update')->where('id', '[0-9]+');
            Route::post('{id}/store_trans', 'ClientController@storeTrans')->name('admin.clients.store_trans')->where('id', '[0-9]+');
        });

        // admin.users
        Route::group([
            'prefix' => 'users',
        ], function () {
            Route::get('/', 'UserController@index')->name('admin.users.index');
            Route::post('/', 'UserController@index')->name('admin.users.index');
            Route::get('create', 'UserController@create')->name('admin.users.create');
            Route::post('store', 'UserController@store')->name('admin.users.store');
            Route::get('{id}/edit', 'UserController@edit')->name('admin.users.edit');
            Route::PUT('{id}', 'UserController@update')->name('admin.users.update');
            Route::PUT('{id}/status', 'UserController@setActive')->name('admin.users.status')->where('id', '[0-9]+');
            Route::get('{id}/subscriptions', 'UserController@showSubscriptions')->name('admin.users.subscriptions')->where('id', '[0-9]+');
            Route::get('{id}/orders', 'UserController@getUserOrders')->name('admin.users.orders')->where('id', '[0-9]+');
            Route::post('{id}/orders', 'UserController@getUserOrders')->name('admin.users.orders')->where('id', '[0-9]+');
        });


        // admin.roles
        Route::group([
            'prefix' => 'roles',
        ], function () {
            Route::get('/', 'RoleController@index')->name('admin.roles.index');
            Route::get('/create', 'RoleController@create')->name('admin.roles.create');
            Route::post('/store', 'RoleController@store')->name('admin.roles.store');
            Route::get('{id}/edit', 'RoleController@edit')->name('admin.roles.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'RoleController@update')->name('admin.roles.update')->where('id', '[0-9]+');
        });


        // admin.subscription_packages
        Route::group([
            'prefix' => 'subscription_packages',
        ], function () {
            Route::get('/', 'SubscriptionPackageController@index')->name('admin.subscriptionpackages.index');
            Route::post('/', 'SubscriptionPackageController@index')->name('admin.subscriptionpackages.index');
            Route::get('/create', 'SubscriptionPackageController@create')->name('admin.subscriptionpackages.create');
            Route::post('/store', 'SubscriptionPackageController@store')->name('admin.subscriptionpackages.store');
            Route::get('{id}/edit', 'SubscriptionPackageController@edit')->name('admin.subscriptionpackages.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'SubscriptionPackageController@update')->name('admin.subscriptionpackages.update')->where('id', '[0-9]+');
            Route::PUT('{id}/status', 'SubscriptionPackageController@setActive')->name('admin.subscriptionpackages.status')->where('id', '[0-9]+');
        });

        // admin.subscriptions
        Route::group([
            'prefix' => 'subscriptions',
        ], function () {
            Route::get('/', 'SubscriptionController@index')->name('admin.subscriptions.index');
            Route::post('/', 'SubscriptionController@index')->name('admin.subscriptions.index');
            Route::get('/create', 'SubscriptionController@create')->name('admin.subscriptions.create');
            Route::post('/store', 'SubscriptionController@store')->name('admin.subscriptions.store');
            Route::get('{id}/edit', 'SubscriptionController@edit')->name('admin.subscriptions.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'SubscriptionController@update')->name('admin.subscriptions.update')->where('id', '[0-9]+');
            Route::post('/store_many', 'SubscriptionController@storeMany')->name('admin.subscriptions.store_many');
            Route::PUT('{id}/status', 'SubscriptionController@setActive')->name('admin.subscriptions.status')->where('id', '[0-9]+');
        });


        // admin.delivery_charges
        Route::group([
            'prefix' => 'delivery_charges',
        ], function () {
            Route::get('/', 'DeliveryChargesController@index')->name('admin.deliverycharges.index');
            Route::post('/', 'DeliveryChargesController@index')->name('admin.deliverycharges.index');
            Route::get('/create', 'DeliveryChargesController@create')->name('admin.deliverycharges.create');
            Route::post('/store', 'DeliveryChargesController@store')->name('admin.deliverycharges.store');
            Route::get('{id}/edit', 'DeliveryChargesController@edit')->name('admin.deliverycharges.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'DeliveryChargesController@update')->name('admin.deliverycharges.update')->where('id', '[0-9]+');
        });


        // admin.car_brands
        Route::group([
            'prefix' => 'car_brands',
        ], function () {
            Route::get('/', 'CarBrandController@index')->name('admin.carbrands.index');
            Route::post('/', 'CarBrandController@index')->name('admin.carbrands.index');
            Route::get('/create', 'CarBrandController@create')->name('admin.carbrands.create');
            Route::post('/store', 'CarBrandController@store')->name('admin.carbrands.store');
            Route::get('{id}/edit', 'CarBrandController@edit')->name('admin.carbrands.edit')->where('id', '[0-9]+');
            Route::post('{id}/edit', 'CarBrandController@edit')->name('admin.carbrands.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'CarBrandController@update')->name('admin.carbrands.update')->where('id', '[0-9]+');
            Route::post('{id}/store_trans', 'CarBrandController@storeTrans')->name('admin.carbrands.store_trans')->where('id', '[0-9]+');
            Route::PUT('{id}/status', 'CarBrandController@setActive')->name('admin.carbrands.status')->where('id', '[0-9]+');
            Route::DELETE('{id}', 'CarBrandController@destroy')->name('admin.carbrands.destroy')->where('id', '[0-9]+');
        });

        // admin.countries
        Route::group([
            'prefix' => 'countries',
        ], function () {
            Route::get('/', 'CountryController@index')->name('admin.countries.index');
            Route::post('/', 'CountryController@index')->name('admin.countries.index');
            Route::get('/create', 'CountryController@create')->name('admin.countries.create');
            Route::post('/store', 'CountryController@store')->name('admin.countries.store');
            Route::get('{id}/edit', 'CountryController@edit')->name('admin.countries.edit')->where('id', '[0-9]+');
            Route::post('{id}/edit', 'CountryController@edit')->name('admin.countries.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'CountryController@update')->name('admin.countries.update')->where('id', '[0-9]+');
            Route::post('{id}/store_trans', 'CountryController@storeTrans')->name('admin.countries.store_trans')->where('id', '[0-9]+');
            Route::PUT('{id}/status', 'CountryController@setActive')->name('admin.countries.status')->where('id', '[0-9]+');
        });

        // admin.package_types
        Route::group([
            'prefix' => 'package_types',
        ], function () {
            Route::get('/', 'PackageTypeController@index')->name('admin.packagetypes.index');
            Route::post('/', 'PackageTypeController@index')->name('admin.packagetypes.index');
            Route::get('/create', 'PackageTypeController@create')->name('admin.packagetypes.create');
            Route::post('/store', 'PackageTypeController@store')->name('admin.packagetypes.store');
            Route::get('{id}/edit', 'PackageTypeController@edit')->name('admin.packagetypes.edit')->where('id', '[0-9]+');
            Route::post('{id}/edit', 'PackageTypeController@edit')->name('admin.packagetypes.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'PackageTypeController@update')->name('admin.packagetypes.update')->where('id', '[0-9]+');
            Route::post('{id}/store_trans', 'PackageTypeController@storeTrans')->name('admin.packagetypes.store_trans')->where('id', '[0-9]+');
            Route::PUT('{id}/status', 'PackageTypeController@setActive')->name('admin.packagetypes.status')->where('id', '[0-9]+');
        });

        // admin.settings
        Route::group([
            'prefix' => 'settings',
        ], function () {
            Route::get('/', 'SettingController@index')->name('admin.settings.index');
            Route::post('/', 'SettingController@index')->name('admin.settings.index');
            Route::PUT('update', 'SettingController@update')->name('admin.settings.update');
        });

        // admin.package_types
        Route::group([
            'prefix' => 'sliders',
        ], function () {
            Route::get('/', 'SliderController@index')->name('admin.sliders.index');
            Route::get('/create', 'SliderController@create')->name('admin.sliders.create');
            Route::post('/store', 'SliderController@store')->name('admin.sliders.store');
            Route::get('{id}/edit', 'SliderController@edit')->name('admin.sliders.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'SliderController@update')->name('admin.sliders.update')->where('id', '[0-9]+');
            Route::PUT('{id}/status', 'SliderController@setActive')->name('admin.sliders.status')->where('id', '[0-9]+');
        });

        // admin.orders
        Route::group([
            'prefix' => 'orders',
        ], function () {
            Route::get('/', 'OrderController@index')->name('admin.orders.index');
            Route::post('/', 'OrderController@index')->name('admin.orders.index');
            Route::get('{id}', 'OrderController@show')->name('admin.orders.show')->where('id', '[0-9]+');
        });

        // admin.languages
        Route::group([
            'prefix' => 'languages',
        ], function () {
            Route::get('/', 'LanguageController@index')->name('admin.languages.index'); // URL: admin/languages/index
        });


        // register in admin must be logged in not public
        // Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('admin.register');
        // Route::post('register', 'Auth\RegisterController@register');


        // less test or 404
        // Route::fallback(function(){
        //     return response()->json([
        //         'message' => 'Page Not Found. If error persists, contact us at info@.com'], 404);
        // });
    });
});
// End Admin Routes


//
//  //Solution ??????????????????????????????????????
// // 'prefix'     => 'admin/'.config()->get('app.locale_prefix') , // '{local}'
// // 'prefix'     => 'admin/'.CommonHelper::setLocal() , Solution ??????????????????????????????????????
//

Route::get('live_search/{crit}', 'Front\SearchController@liveSearch')->name('live.search');


// Web Routes
Route::group([
    'namespace' => 'Front',
    'middleware' => ['set.local', 'shares'], // no need the web groub it's applied by default on this file (web.route)
   / 'prefix' => '{locale?}',  // 'where' => ['lang' => '[a-zA-Z]{2}'],
], function ($router) {

    // Auth
    // Auth::routes();

    Route::get('search/{crit?}', 'SearchController@search')->name('front.search');

    Route::group([
        'middleware' => ['prevent.back.history']
    ], function ($router) {


        Route::get('register', 'UserController@showRegistrationForm')->name('front.register');
        Route::post('register', 'UserController@store');

        Route::get('login', 'UserController@showLoginForm')->name('front.login');
        Route::post('login', 'UserController@login')->name('front.login');
        Route::post('logout', 'UserController@logout')->name('front.logout');

        Route::get('reset_password', 'PasswordController@showResetPassword')->name('password.reset');
        Route::post('reset_password', 'PasswordController@resetPassword')->name('password.reset')->middleware('throttle:4,1');
        Route::get('verify_password', 'PasswordController@showVerifyPassword')->name('password.verify');
        Route::post('verify_password', 'PasswordController@verifyPasswordCode')->name('password.verify');
        Route::get('change_password', 'PasswordController@showChangePassword')->name('password.change');
        Route::post('change_password', 'PasswordController@changePassword')->name('password.change')->middleware('throttle:4,1');
        Route::post('resend_code', 'PasswordController@resendCode')->name('password.resend_code')->middleware('throttle:4,1');


// verifyPasswordCode

        Route::group([
            'prefix' => 'verifications',
        ], function () {
            Route::get('/', 'VerificationController@show')->name('front.verifications.show');
            Route::post('/', 'VerificationController@check')->name('front.verifications.check');
            Route::post('/resend_code', 'VerificationController@resendCode')->name('front.verifications.resend_code')->middleware('throttle:4,1');
        });

        Route::group([
            'middleware' => ['front'],
        ], function () {
            Route::get('/', 'IndexController@index')->name('front.home');
            Route::get('/offers', 'IndexController@getOffers')->name('front.offers');
            Route::get('/coupons', 'IndexController@getCoupons')->name('front.coupons');


            Route::group([
                'prefix' => 'items',
            ], function () {
                Route::get('{id}', 'ItemController@show')->name('items.show');
                Route::post('store', 'ItemController@store')->name('items.store');
                Route::get('{id}/edit', 'ItemController@edit')->name('items.edit');
                Route::put('{id}', 'ItemController@update')->name('items.update');
                Route::post('{id}/delete', 'ItemController@delete')->name('items.delete');
                Route::post('like', 'ItemController@storeLike')->name('items.like');
                Route::get('{id}/comments', 'ItemController@getComments')->name('items.comments')->where('id', '[0-9]+');
            });

            Route::group([
                'prefix' => 'comments',
            ], function () {
                Route::post('/', 'CommentController@store')->name('comments.add');
                Route::get('/{id}/childs', 'CommentController@getCommentChilds')->name('comments.childs')->where('id', '[0-9]+');
            });

            Route::group([
                'prefix' => 'users',
            ], function () {
                Route::get('{id}', 'UserController@show')->name('user.show')->where('id', '[0-9]+');
                Route::get('{id}/profile', 'UserController@edit')->name('user.profile')->where('id', '[0-9]+');
                Route::put('{id}/update', 'UserController@update')->name('user.update')->where('id', '[0-9]+');
                Route::get('{id}/offers', 'UserController@getOffers')->name('user.offers')->where('id', '[0-9]+');
                Route::get('{id}/coupons', 'UserController@getCoupons')->name('user.coupons')->where('id', '[0-9]+');
                Route::get('{id}/likes', 'UserController@getLikes')->name('user.likes')->where('id', '[0-9]+');
                Route::get('{id}/comments', 'UserController@getComments')->name('user.comments')->where('id', '[0-9]+');
                Route::get('{id}/images', 'UserController@getImages')->name('user.images')->where('id', '[0-9]+');
                Route::post('background', 'UserController@updateBackground')->name('user.background');
                Route::post('image', 'UserController@updateImage')->name('user.image');
            });


            Route::group([
                'prefix' => 'info',
            ], function () {
                Route::get('/customer_service', 'InfoController@customerService')->name('front.info.customer_service');
                Route::get('/contactus', 'InfoController@contactUs')->name('front.info.contactus');
                Route::post('/contactus', 'InfoController@contactUsPost')->name('front.info.contactusPost')->middleware('throttle:3,1');
                Route::get('/aboutus', 'InfoController@aboutUs')->name('front.info.aboutus');
                Route::get('/terms', 'InfoController@terms')->name('front.info.terms');
                Route::get('/privacy_policy', 'InfoController@terms')->name('front.info.privacy_policy');
                // Route::get('/qa', 'InfoController@qa')->name('front.info.qa');
                // Route::post('/qa', 'InfoController@qa')->name('front.info.qa');
            });


        });


    });
});
// // End Web Routes
