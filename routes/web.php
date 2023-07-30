<?php

use Illuminate\Support\Facades\Route;

// utils
// Route::get('fcm/test', 'Admin\testController@index');
Route::get('send-notfication/{id}', 'Admin\testController@test');
Route::post('save-token', 'Admin\testController@saveToken');
Route::get('fcm/test', function () {
    // return 'this fot not';
    return view('firbase');
});
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
}); // Give error
Route::get('route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return 'route:clear';
});
Route::get('view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return 'view:clear';
});
Route::get('/register' ,function(){
    return view('admin.auth.register');
});
Route::get('/' ,function(){
    return view('welcome');
});
Route::post('/register', 'Admin\Auth\LoginController@register')->name('register');

// Route::get('storage-link', function() { $exitCode = Artisan::call('storage:link');return 'StorageLink'; });
// php artisan storage:link

// Route::get('admin_notification', 'Admin\AdminNotificationController@create')->name('admin.notification');
// Route::get('pusher_notification', 'Util\PusherNotificationController@send')->name('user.notification');

// Route::post('test','Front\TestController@test');

Route::post('test_upload_img', 'Front\IndexController@testUploadImg')->name('test.upload.image');

Route::post('pdf', 'Util\PdfController@getPdf');

Route::group([
    'namespace' => 'Util',
    'middleware' => ['set.local', 'admin.shares'], // ,'admin.shares' because logo take path from settings in it ??
    'prefix' => '{locale?}/password',
], function ($router) {

    Route::get('reset_mail', 'PasswordController@showEmailRequest')->name('password.email.request');
    Route::post('send_email', 'PasswordController@sendEmailReset')->name('password.email.send')->middleware('throttle:4,1');
    Route::get('verify_email/{token}', 'PasswordController@verifyEmail')->name('password.email.verify');
    Route::post('change_password', 'PasswordController@changePasswordEmail')->name('password.email.change_password')->middleware('throttle:4,1');

    // Route::get('reset_password', 'PasswordController@showResetPassword')->name('password.reset');
    // Route::post('reset_password', 'PasswordController@resetPassword')->name('password.reset')->middleware('throttle:4,1');
    // Route::get('verify_password', 'PasswordController@showVerifyPassword')->name('password.verify');
    // Route::post('verify_password', 'PasswordController@verifyPasswordCode')->name('password.verify');
    // Route::get('change_password', 'PasswordController@showChangePassword')->name('password.change');
    // Route::post('change_password', 'PasswordController@changePassword')->name('password.change')->middleware('throttle:4,1');
    // Route::post('resend_code', 'PasswordController@resendCode')->name('password.resend_code')->middleware('throttle:4,1');
});
// USER Panel Area
// Route::group([
//     'namespace' => 'Admin',
//     'middleware' => ['set.local', 'admin.shares'],
//     'prefix' => 'user/{locale?}',
// ], function ($router) {
//     Route::get('/', 'IndexController@index')->name('user.home');


// });
// Admin Panel Area
Route::group([
    'namespace' => 'Admin',
    'middleware' => ['set.local', 'admin.shares'],
    'prefix' => 'admin/{locale?}',
], function ($router) {
    
    Route::prefix('markets')->group(function(){
        Route::get('/', '\App\Http\Controllers\Admin\MarketController@getAll')->name("admin.markets.index");        
        
        Route::get('/test', '\App\Http\Controllers\Admin\MarketController@testing')->name("markets.testing");
        Route::get('/get/{id}', '\App\Http\Controllers\Admin\MarketController@getById')->name("markets.getById");
        Route::get('/add', '\App\Http\Controllers\Admin\MarketController@add')->name("markets.add");;
        Route::post('/create', '\App\Http\Controllers\Admin\MarketController@create')->name("markets.create");
        Route::get('/edit/{id}', '\App\Http\Controllers\Admin\MarketController@edit')->name("markets.edit");
        Route::post('/update/{id}', '\App\Http\Controllers\Admin\MarketController@update')->name("markets.update");
        Route::get('/remove/{id}', '\App\Http\Controllers\Admin\MarketController@remove')->name("markets.remove");
    
    });
    // Auth
    // Auth::routes(['register' => false , 'reset' => false , 'verify' => false]);
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\LoginController@login')->name('admin.login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
    Route::post('/user/logout', 'Auth\LoginController@logout')->name('logout');
  // register in admin must be logged in not public
//   Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('admin.register');
//   Route::post('register', 'Auth\RegisterController@register')->name('register');

    Route::delete('delete', 'SettingController@delete')->name('admin.delete');
    // admin.verifications
    Route::group([
        'prefix' => 'verifications',
    ], function () {
        Route::get('/', 'VerificationController@show')->name('admin.verifications.show');
        Route::post('/', 'VerificationController@check')->name('admin.verifications.check');
        Route::get('resend_code', 'VerificationController@show')->name('admin.verifications.resend_code'); // ->middleware('throttle:4,1');

    });

    // Route::group([
    //     'prefix' => 'employees',
    // ], function () {
    //     Route::match(['GET', 'POST'], '/type/{type_id}', 'EmployeeController@getEmployeesByType')->name('admin.employees.index_type')->where('type_id', '[0-9]+');
    //     Route::get('create', 'EmployeeController@create')->name('admin.employees.create');
    //     Route::post('store', 'EmployeeController@store')->name('admin.employees.store');
    //     Route::get('{id}/edit', 'EmployeeController@edit')->name('admin.employees.edit')->where('id', '[0-9]+');
    //     Route::PUT('{id}', 'EmployeeController@update')->name('admin.employees.update')->where('id', '[0-9]+');
    //     Route::PUT('{id}/status', 'EmployeeController@updateActiveStatus')->name('admin.employees.status')->where('id', '[0-9]+');
    //     // Route::post('fcm_web', 'EmployeeController@updateFcmWeb')->name('admin.users.fcm_web');
    // });

    // admin.subscriptions
    // Route::group([
    //     'prefix' => 'subscriptions_verify',
    // ], function () {
    //     Route::get('/', 'SubscriptionController@show')->name('admin.subscriptionsverify.show');
    //     Route::post('/', 'SubscriptionController@check')->name('admin.subscriptionsverify.check');
    //     Route::get('resend_code', 'SubscriptionController@show')->name('admin.subscriptionsverify.resend_code'); // ->middleware('throttle:4,1');
    // });

    Route::group([
        'middleware' => ['admin', 'prevent.back.history'],
    ], function ($router) {

        // admin
        Route::get('/', 'IndexController@index')->name('admin.home');
        Route::get('order_chart', 'IndexController@order_chart')->name('admin.order_chart');
        Route::get('form', 'IndexController@form')->name('admin.form');

        Route::get('chat/{id}', 'FirebaseController@getChat')->name('admin.chat.order');
        Route::get('admin_chat/{id}', 'FirebaseController@getAdminChat')->name('admin.chat.users');

        Route::get('bad_words', 'BadWordsController@index')->name('admin.badwords.index');
        Route::put('bad_words/{id}', 'BadWordsController@update')->name('admin.badwords.update');


        Route::get('profile','UserController@edit_profile')->name('admin.profile.edit');
        Route::post('profile_update','UserController@update_profile')->name('admin.profile.update');
        //admin.categories
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
            Route::delete('{id}/delete', 'CategoryController@delete')->name('admin.categories.delete')->where('id', '[0-9]+');

        });

        Route::group([
            'prefix' => 'orders',
        ], function () {
            Route::get('/status/{type}', 'OrderController@index')->name('admin.orders.index');
            Route::post('/status/{type}', 'OrderController@index')->name('admin.orders.index');
            Route::delete('delete', 'OrderController@deleteOrders')->name('admin.orders.deleteOrders');
            Route::get('{id}', 'OrderController@show')->name('admin.orders.show')->where('id', '[0-9]+');
            Route::get('pdf/{id}', 'OrderController@pdf')->name('admin.orders.pdf')->where('id', '[0-9]+');
            Route::get('{id}/rate', 'OrderController@rate')->name('admin.orders.rate')->where('id', '[0-9]+');
            Route::POST('{id}/cancel', 'OrderController@cancel')->name('admin.orders.cancel')->where('id', '[0-9]+');
            Route::POST('{id?}/complete', 'OrderController@complete')->name('admin.orders.complete')->where('id', '[0-9]+');
            Route::POST('{id?}/accept', 'OrderController@accept')->name('admin.orders.accept')->where('id', '[0-9]+');
            Route::POST('{id?}/onway', 'OrderController@OrderOnway')->name('admin.orders.onway')->where('id', '[0-9]+');
        });
        // Route::prefix('markets')->group(function(){
        //     Route::get('/', '\App\Http\Controllers\Admin\MarketController@getAll')->name("markets.getAll");
        //     Route::get('/get/{id}', '\App\Http\Controllers\Admin\MarketController@getById')->name("markets.getById");
        //     Route::get('/add', '\App\Http\Controllers\Admin\MarketController@add')->name("markets.add");;
        //     Route::post('/create', '\App\Http\Controllers\Admin\MarketController@create')->name("markets.create");
        //     Route::get('/edit/{id}', '\App\Http\Controllers\Admin\MarketController@edit')->name("markets.edit");
        //     Route::post('/update/{id}', '\App\Http\Controllers\Admin\MarketController@update')->name("markets.update");
        //     Route::get('/remove/{id}', '\App\Http\Controllers\Admin\MarketController@remove')->name("markets.remove");

        // });
        Route::group([
            'prefix' => 'bank_accounts',
        ], function () {
            Route::get('/', 'BankAccountsController@index')->name('admin.bank_account.index');
            Route::post('/create', 'BankAccountsController@create')->name('admin.bank_account.create');
            Route::delete('/delete/{id}', 'BankAccountsController@delete')->name('admin.bank_account.delete');
            Route::post('/update/{id}', 'BankAccountsController@update')->name('admin.bank_account.update');
        });

        Route::group([
            'prefix' => 'commission',
        ], function () {
            Route::get('/', 'CommissionController@index')->name('admin.commission.index');
            Route::post('/', 'CommissionController@index')->name('admin.commission.index');
            Route::get('/paid', 'CommissionController@paid')->name('admin.commission.paid');
            Route::post('/paid', 'CommissionController@paid')->name('admin.commission.paid');
            Route::get('/not_paid', 'CommissionController@not_paid')->name('admin.commission.not_paid');
            Route::post('/not_paid', 'CommissionController@not_paid')->name('admin.commission.not_paid');

            Route::get('/requests', 'CommissionController@requests')->name('admin.commission.requests');
            Route::post('/requests', 'CommissionController@requests')->name('admin.commission.requests');
            Route::get('/accept/{id}', 'CommissionController@accept')->name('admin.commission.accept');
            Route::get('/cancel/{id}', 'CommissionController@cancel')->name('admin.commission.cancel');

        });

        Route::group([
            'prefix' => 'how_to_use',
        ], function () {
            Route::get('/', 'HowToUseController@index')->name('admin.how_to_use.index');
            Route::post('/', 'HowToUseController@index')->name('admin.how_to_use.index');
            Route::post('/create', 'HowToUseController@create')->name('admin.how_to_use.create');
            Route::delete('/delete/{id}', 'HowToUseController@delete')->name('admin.how_to_use.delete');
            Route::post('/update/{id}', 'HowToUseController@update')->name('admin.how_to_use.update');
        });

        Route::group([
            'prefix' => 'products',
            'as' => 'admin.products.',

        ], function () {
            Route::get('/', 'ProductsController@index')->name('index');
            Route::get('/getChild', 'ProductsController@getChild')->name('getChild');
            Route::post('/', 'ProductsController@index')->name('index');
            Route::post('/create', 'ProductsController@create')->name('create');
            Route::delete('/delete/{id}', 'ProductsController@delete')->name('delete');
            Route::post('/update/{id}', 'ProductsController@update')->name('update');
        });

        Route::group([
            'prefix' => 'coupons',
        ], function () {
            Route::get('/', 'CouponsController@index')->name('admin.coupons.index');
            Route::post('/', 'CouponsController@index')->name('admin.coupons.index');
            Route::post('/create', 'CouponsController@create')->name('admin.coupons.create');
            Route::delete('/delete/{id}', 'CouponsController@delete')->name('admin.coupons.delete');
            Route::post('/update/{id}', 'CouponsController@update')->name('admin.coupons.update');
            Route::get('/users/{coupon}', 'UserController@coupon')->name('admin.coupons.users');
        });

        Route::group([
            'prefix' => 'offers',
        ], function () {
            Route::get('/', 'OffersController@index')->name('admin.offers.index');
            Route::post('/', 'OffersController@index')->name('admin.offers.index');
            Route::post('/create', 'OffersController@create')->name('admin.offers.create');
            Route::delete('/delete/{id}', 'OffersController@delete')->name('admin.offers.delete');
            Route::get('/delete_image/{id}/{index}', 'OffersController@delete_image')->name('admin.offers.delete_image');
            Route::get('/edit/{id}', 'OffersController@edit')->name('admin.offers.edit');
            Route::post('/edit/{id}', 'OffersController@edit')->name('admin.offers.edit');
            Route::post('/update/{id}', 'OffersController@update')->name('admin.offers.update');

            Route::group([
                'prefix' => 'details',
            ], function () {
                Route::post('/create/{offer_id}', 'OffersController@create_details')->name('admin.offers.details.create');
                Route::delete('/delete/{id}', 'OffersController@delete_details')->name('admin.offers.details.delete');
                Route::get('/edit/{id}', 'OffersController@edit_details')->name('admin.offers.details.edit');
                Route::post('/edit/{id}', 'OffersController@edit_details')->name('admin.offers.details.edit');
                Route::get('/delete_image/{id}/{index}', 'OffersController@delete_image_details')->name('admin.offers.details.delete_image');
                Route::post('/update/{id}', 'OffersController@update_details')->name('admin.offers.details.update');
            });

        });

        // admin.items
        // Route::group([
        //     'prefix' => 'items',
        // ], function () {
        //     Route::get('/', 'ItemController@index')->name('admin.items.index'); // test datatable paginate
        //     // Route::post('/', 'ItemController@index')->name('admin.items.index');
        //     Route::get('/{id}/edit', 'ItemController@edit')->name('admin.items.edit')->where('id', '[0-9]+');
        //     Route::get('coupons', 'ItemController@indexCoupons')->name('admin.items.index_coupons');
        //     Route::post('coupons', 'ItemController@indexCoupons')->name('admin.items.index_coupons');
        //     Route::get('offers', 'ItemController@indexOffers')->name('admin.items.index_offers');
        //     Route::post('offers', 'ItemController@indexOffers')->name('admin.items.index_offers');
        //     Route::get('most/{type}', 'ItemController@getMost')->name('admin.items.get_most');
        //     Route::post('most/{type}', 'ItemController@getMost')->name('admin.items.get_most');
        //     Route::PUT('{id}/status', 'ItemController@setActive')->name('admin.items.status')->where('id', '[0-9]+');
        //     Route::DELETE('{id}', 'ItemController@destroy')->name('admin.items.delete')->where('id', '[0-9]+');
        //     Route::DELETE('/{id}/destroy_file/{file_id}', 'ItemController@destroyFile')->name('admin.items.destroy_file')->where(['id', '[0-9]+', 'file_id', '[0-9]+']);
        // });

        // admin.items
        // Route::group([
        //     'prefix' => 'comments',
        // ], function () {
        //     Route::get('/', 'CommentController@index')->name('admin.comments.index');
        //     Route::post('/', 'CommentController@index')->name('admin.comments.index');
        //     Route::PUT('{id}/comment', 'CommentController@updateComment')->name('admin.comments.update_comment')->where('id', '[0-9]+');
        //     Route::PUT('{id}/status', 'CommentController@setActive')->name('admin.comments.status')->where('id', '[0-9]+');
        //     Route::DELETE('{id}', 'CommentController@destroy')->name('admin.comments.delete')->where('id', '[0-9]+');
        // });

        // admin.items
        Route::group([
            'prefix' => 'clients',
            'as' => 'admin.clients.',
        ], function () {
            Route::get('/', 'UserController@clients')->name('index');
            //Route::post('/', 'UserController@clients')->name('index');
            Route::get('create', 'UserController@createClient')->name('create');
            Route::post('store', 'UserController@store')->name('store');
            Route::get('{id}/edit', 'UserController@edit')->name('edit')->where('id', '[0-9]+');
            Route::get('{id}/wallet', 'UserController@wallet')->name('wallet');
            Route::post('charge_wallet', 'UserController@charge_wallet')->name('charge_wallet');

            //Route::post('{id}/edit', 'UserController@edit')->name('edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'UserController@update')->name('update')->where('id', '[0-9]+');
            Route::PUT('{id}/status', 'UserController@setActive')->name('status')->where('id', '[0-9]+');
            Route::delete('{id}/delete', 'UserController@deleteUser')->name('delete')->where('id', '[0-9]+');
            Route::get('{id}/orders', 'OrderController@getClientOrders')->name('orders')->where('id', '[0-9]+');
            Route::post('{id}/orders', 'OrderController@getClientOrders')->name('orders')->where('id', '[0-9]+');
            Route::get('{id}/rate', 'UserController@rate')->name('rate')->where('id', '[0-9]+');
            Route::post('notify', 'NotificationsController@notifyAll')->name('notify');
            Route::post('notifyUser/{id}', 'NotificationsController@notifyUser')->name('notifyUser');


        });

        Route::group([
            'prefix' => 'shippers',
            'as' => 'admin.shippers.',
        ], function () {
            Route::get('/', 'UserController@shippers')->name('index');
            //Route::post('/', 'UserController@shippers')->name('index');
            Route::get('create', 'UserController@createShipper')->name('create');
            Route::post('store', 'UserController@store')->name('store');
            Route::get('{id}/edit', 'UserController@edit')->name('edit')->where('id', '[0-9]+');
            //Route::post('{id}/edit', 'UserController@edit')->name('edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'UserController@update')->name('update')->where('id', '[0-9]+');
            Route::PUT('{id}/status', 'UserController@setActive')->name('status')->where('id', '[0-9]+');
            Route::PUT('{id}/approved', 'UserController@setApproved')->name('approved')->where('id', '[0-9]+');
            Route::delete('{id}/delete', 'UserController@deleteUser')->name('delete')->where('id', '[0-9]+');
            Route::get('{id}/orders', 'OrderController@getShippertOrders')->name('orders')->where('id', '[0-9]+');
            Route::post('{id}/orders', 'OrderController@getShippertOrders')->name('orders')->where('id', '[0-9]+');
            Route::get('{id}/rate', 'UserController@rate')->name('rate')->where('id', '[0-9]+');
            Route::get('getCities', 'UserController@getCities')->name('cities');
            Route::post('notify', 'NotificationsController@notifyAll')->name('notify');
            Route::post('notifyUser/{id}', 'NotificationsController@notifyUser')->name('notifyUser');

        });
        Route::group([
            'prefix' => 'traders',
            'as' => 'admin.traders.',
        ], function () {
            Route::get('/', 'UserController@traders')->name('index');
            //Route::post('/', 'UserController@shippers')->name('index');
            Route::get('create', 'UserController@createTrader')->name('create');
            Route::post('store', 'UserController@store')->name('store');
            Route::get('edit', 'UserController@edit')->name('edit')->where('id', '[0-9]+');
            //Route::post('{id}/edit', 'UserController@edit')->name('edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'UserController@update')->name('update')->where('id', '[0-9]+');
            Route::PUT('status', 'UserController@setActive')->name('status')->where('id', '[0-9]+');
            Route::PUT('{id}/approved', 'UserController@setApproved')->name('approved')->where('id', '[0-9]+');
            Route::delete('delete', 'UserController@deleteUser')->name('delete')->where('id', '[0-9]+');
            Route::get('{id}/orders', 'OrderController@getShippertOrders')->name('orders')->where('id', '[0-9]+');
            Route::post('{id}/orders', 'OrderController@getShippertOrders')->name('orders')->where('id', '[0-9]+');
            Route::get('{id}/rate', 'UserController@rate')->name('rate')->where('id', '[0-9]+');
            Route::get('getCities', 'UserController@getCities')->name('cities');
            Route::post('notify', 'NotificationsController@notifyAll')->name('notify');
            Route::post('notifyUser/{id}', 'NotificationsController@notifyUser')->name('notifyUser');

        });
        Route::group([
            'prefix' => 'messages',
            'as' => 'admin.messages.',
        ], function () {
             Route::get('all', 'FirebaseController@messages')->name('all');
             Route::get('user/{id}', 'FirebaseController@user')->name('user');
        });

        Route::group([
            'prefix' => 'admins',
            'as' => 'admin.admins.',
        ], function () {
            Route::get('/', 'UserController@admins')->name('index');
            Route::post('/', 'UserController@admins')->name('index');
            Route::get('create', 'UserController@createAdmin')->name('create');
            Route::post('store', 'UserController@store')->name('store');
            Route::get('{id}/edit', 'UserController@edit')->name('edit')->where('id', '[0-9]+');
            Route::post('{id}/edit', 'UserController@edit')->name('edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'UserController@update')->name('update')->where('id', '[0-9]+');
            Route::PUT('{id}/status', 'UserController@setActive')->name('status')->where('id', '[0-9]+');
            Route::delete('{id}/delete', 'UserController@deleteUser')->name('delete')->where('id', '[0-9]+');

        });

        // admin.users
        Route::group([
            'prefix' => 'users',
        ], function () {
            Route::get('/', 'UserController@index')->name('admin.users.index'); // canceled
            Route::post('/', 'UserController@index')->name('admin.users.index'); // canceled
            Route::get('/type/{id}', 'UserController@getUsersByType')->name('admin.users.type')->where('id', '[0-9]+');
            Route::post('/type/{id}', 'UserController@getUsersByType')->name('admin.users.type')->where('id', '[0-9]+');
            Route::get('create', 'UserController@create')->name('admin.users.create');
            // Route::get('create_client', 'UserController@createClient')->name('admin.users.create_client');
            Route::post('store', 'UserController@store')->name('admin.users.store');
            // Route::post('save-token', 'UserController@saveToken')->name('admin.users.saveToken');
            Route::get('{id}/edit', 'UserController@edit')->name('admin.users.edit');
            Route::PUT('{id}', 'UserController@update')->name('admin.users.update');
            Route::PUT('{id}/status', 'UserController@setActive')->name('admin.users.status')->where('id', '[0-9]+');
            //Route::get('{id}/subscriptions', 'UserController@showSubscriptions')->name('admin.users.subscriptions')->where('id', '[0-9]+');
            //Route::get('{id}/orders', 'UserController@getUserOrders')->name('admin.users.orders')->where('id', '[0-9]+');
            //Route::post('{id}/orders', 'UserController@getUserOrders')->name('admin.users.orders')->where('id', '[0-9]+');
            Route::post('fcm_web', 'UserController@updateFcmWeb')->name('admin.users.fcm_web');
            Route::get('notification_readed', 'UserController@notification_readed')->name('admin.users.notification_readed');
            Route::get('notification_readed_by_user_id/{id}', 'UserController@notification_readed')->name('admin.users.notification_readed_by_user_id');

            Route::delete('{id}/delete', 'UserController@deleteUser')->name('admin.users.delete')->where('id', '[0-9]+');

        });

        // admin.roles
        Route::group([
            'prefix' => 'roles',
        ], function () {
            Route::get('/', 'RoleController@index')->name('admin.roles.index');
            Route::get('/create', 'RoleController@create')->name('admin.roles.create');
            Route::post('/store', 'RoleController@store')->name('admin.roles.store');
            Route::delete('/delete/{id}', 'RoleController@delete')->name('admin.roles.delete');
            Route::get('{id}/edit', 'RoleController@edit')->name('admin.roles.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'RoleController@update')->name('admin.roles.update')->where('id', '[0-9]+');
            Route::post('set_current_role', 'RoleController@setCurrentRole')->name('admin.roles.set_current_role')->where('id', '[0-9]+');;

        });

        // admin.conditions
        // Route::group([
        //     'prefix' => 'conditions',
        // ], function () {
        //     Route::get('/', 'ConditionController@index')->name('admin.conditions.index');
        //     Route::post('/', 'ConditionController@index')->name('admin.conditions.index');
        //     // Route::get('/create', 'RoleController@create')->name('admin.roles.create');
        //     // Route::post('/store', 'RoleController@store')->name('admin.roles.store');
        //     // Route::get('{id}/edit', 'RoleController@edit')->name('admin.roles.edit')->where('id', '[0-9]+');
        //     Route::PUT('{id}', 'ConditionController@update')->name('admin.conditions.update')->where('id', '[0-9]+');
        // });

        //admin.countries
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
            Route::delete('{id}/delete', 'CountryController@delete')->name('admin.countries.delete')->where('id', '[0-9]+');

        });

        // admin.settings
        Route::group([
            'prefix' => 'settings',
        ], function () {
            Route::get('/', 'SettingController@index')->name('admin.settings.index');
            Route::post('/', 'SettingController@index')->name('admin.settings.index');
            Route::PUT('update', 'SettingController@update')->name('admin.settings.update');
            Route::post('/add_msg_type', 'SettingController@addMsgType')->name('admin.settings.add_msg_type');
            Route::post('/update_msg_type/{id}', 'SettingController@updateMsgType')->name('admin.settings.update_msg_type');
        });

        // admin.notifications
        Route::group([
            'prefix' => 'notifications',
        ], function () {
            Route::get('/', 'NotificationsController@index')->name('admin.notifications.index');
            Route::post('/', 'NotificationsController@index')->name('admin.notifications.index');

        });

        // admin.package_types
        Route::group([
            'prefix' => 'sliders',
        ], function () {
            Route::get('/', 'SliderController@index')->name('admin.sliders.index');
            Route::get('{id}/edit', 'SliderController@edit')->name('admin.sliders.edit')->where('id', '[0-9]+');
            Route::get('/create', 'SliderController@edit')->name('admin.sliders.create');
            Route::PUT('{id}', 'SliderController@update')->name('admin.sliders.update')->where('id', '[0-9]+');
            Route::delete('{id}/{imageIndex}', 'SliderController@delete')->name('admin.sliders.delete')->where('id', '[0-9]+');
            Route::PUT('{id}/status', 'SliderController@setActive')->name('admin.sliders.status')->where('id', '[0-9]+');
        });



        Route::group([
            'prefix' => 'mktn',
            'as' => 'admin.mktn.',

        ], function () {
            Route::get('/', 'MktnController@index')->name('index');
            Route::get('/souq/shops/{id}', 'MktnController@getShopsBySouqId')->name('shops');
            Route::get('/getChild', 'MktnController@getChild')->name('getChild');
            // Route::post('/', 'MktnController@index')->name('index');
            Route::get('/add', 'MktnController@add')->name('add');
            Route::post('/create', 'MktnController@create')->name('store');
            
            Route::get('/edit/{id}', 'MktnController@edit')->name('edit')->where('id', '[0-9]+');
            Route::post('/update/{id}', 'MktnController@update')->name('update')->where('id', '[0-9]+');
            Route::get('/delete/{id}', 'MktnController@remove')->name('delete')->where('id', '[0-9]+');
        });

        Route::group([
            'prefix' => 'shops',
            'as' => 'admin.shops.',

        ], function () {
            Route::get('/', 'ShopController@getAll')->name('index');
            Route::get('/shop/products/{id}', 'ShopController@getProductsOFShop')->name('products');
            Route::get('/getChild', 'ShopController@getChild')->name('getChild');
            Route::get('/shop/user', 'ShopController@getByUserId')->name('user');
            Route::get('/shop/status/{id}/{status}', 'ShopController@changeShopStatus')->name('status');

            Route::get('/add', 'ShopController@add')->name('add');
            Route::post('/create', 'ShopController@create')->name('store');
            
            Route::get('/edit/{id}', 'ShopController@edit')->name('edit')->where('id', '[0-9]+');
            Route::post('/update/{id}', 'ShopController@update')->name('update')->where('id', '[0-9]+');
            Route::get('/delete/{id}', 'ShopController@remove')->name('delete')->where('id', '[0-9]+');
        });

        Route::group([
            'prefix' => 'souqProducts',
            'as' => 'admin.souqProducts.',

        ], function () {
            Route::get('/', 'SouqProductsController@getAll')->name('index');
            Route::get('/add', 'SouqProductsController@add')->name('add');
            Route::post('/create', 'SouqProductsController@create')->name('store');
            
            Route::get('/edit/{id}', 'SouqProductsController@edit')->name('edit')->where('id', '[0-9]+');
            Route::post('/update/{id}', 'SouqProductsController@update')->name('update')->where('id', '[0-9]+');
            Route::get('/delete/{id}', 'SouqProductsController@remove')->name('delete')->where('id', '[0-9]+');
        });

        Route::group([
            'prefix' => 'meat',
            'as' => 'admin.meat.',

        ], function () {
            Route::get('/', 'MeatController@getAll')->name('index');
            Route::get('/orders/{type}', 'MeatController@getAllMeatOrders')->name('orders');
            Route::get('/add', 'MeatController@add')->name('add');
            Route::get('/edit/{id}', 'MeatController@edit')->name('edit')->where('id', '[0-9]+');
        });

        Route::group([
            'prefix' => 'water',
            'as' => 'admin.water.',

        ], function () {
            Route::get('/', 'WaterController@getAll')->name('index');
            Route::get('/orders/{type}', 'WaterController@getAllWaterOrders')->name('orders');
            Route::get('/add', 'WaterController@add')->name('add');
            Route::get('/edit/{id}', 'WaterController@edit')->name('edit')->where('id', '[0-9]+');
        });
        Route::group([
            'prefix' => 'fazaa',
            'as' => 'admin.fazaa.',

        ], function () {
            // Route::get('/', 'FazaaController@getAll')->name('index');
            Route::get('/orders/{type}', 'FazaaController@getAllFazaaOrders')->name('index');

            Route::get('/delete/{id}', 'FazaaController@remove')->name('delete')->where('id', '[0-9]+');
        });
        Route::group([
            'prefix' => 'gas',
            'as' => 'admin.gas.',

        ], function () {
            // Route::get('/', 'FazaaController@getAll')->name('index');
            Route::get('/', 'GasController@getAll')->name('index');
            Route::get('/add', 'GasController@add')->name('add');
            Route::get('/edit/{id}', 'GasController@edit')->name('edit')->where('id', '[0-9]+');
            Route::get('/orders/{type}', 'GasController@getAllGasOrders')->name('orders');
            Route::get('/delete/{id}', 'FazaaController@remove')->name('delete')->where('id', '[0-9]+');
        });
        Route::group([
            'prefix' => 'trader',
            'as' => 'admin.trader.',

        ], function () {
            Route::get('/add/my/products' ,'TraderController@addMyProducts')->name('addMine');
            Route::get('/move/ownership/view/{id}' ,'TraderController@moveOwnershipView')->name('ownership')->where('id', '[0-9]+');
            Route::post('move/ownership/{id?}' ,'TraderController@moveOwnership')->name('move')->where('id', '[0-9]+');
            Route::get('/add/my/products' ,'TraderController@addMyProducts')->name('addMine');
            Route::get('/my/orders/{id?}' ,'TraderController@getOrdersOFTrader')->name('orders');
            Route::post('/my/orders/{id?}', 'TraderController@getOrdersOFTrader')->name('orders');

            // Route::get('/recieve', 'MeatController@OrderMeatRecieved')->name('recieve');
            // Route::post('/delete', 'MeatController@OrderMeatDelete')->name('delete');
            
        });
        // admin.settings
        // Route::group([
        //     'prefix' => 'adv_periods',
        // ], function () {
        //     Route::get('/', 'AdvPeriodsController@index')->name('admin.adv_periods.index');
        //     // Route::post('/', 'SettingController@index')->name('admin.settings.index');
        //     Route::post('/', 'AdvPeriodsController@store')->name('admin.adv_periods.store');
        //     Route::put('/{id}/update', 'AdvPeriodsController@update')->where('id', '[0-9]+')->name('admin.adv_periods.update');
        // });

        // admin.languages
        Route::group([
            'prefix' => 'languages',
        ], function () {
            Route::get('/', 'LanguageController@index')->name('admin.languages.index'); // URL: admin/languages/index
        });

        // admin.conditions
        Route::group([
            'prefix' => 'faqs',
        ], function () {
            Route::get('/', 'FaqController@index')->name('admin.faqs.index');
            Route::post('/', 'FaqController@index')->name('admin.faqs.index');
            // Route::get('/create', 'RoleController@create')->name('admin.roles.create');
            Route::post('/store', 'FaqController@store')->name('admin.faqs.store');
            // Route::get('{id}/edit', 'RoleController@edit')->name('admin.roles.edit')->where('id', '[0-9]+');
            Route::PUT('{id}', 'FaqController@update')->name('admin.faqs.update')->where('id', '[0-9]+');
            Route::delete('delete/{id}', 'FaqController@destroy')->name('admin.faqs.delete')->where('id', '[0-9]+');
        });

        Route::group([
            'prefix' => 'contacts',
        ], function () {
            Route::get('/', 'ContactUsController@index')->name('admin.contacts.index');
            Route::get('/{id}/details', 'ContactUsController@getDetails')->name('admin.contacts.details');
            // Route::get('/comments', 'CommentController@index')->name('admin.comments.index');
            Route::get('/create', 'ContactUsController@create')->name('admin.contacts.create');
            Route::post('/', 'ContactUsController@store')->name('admin.contacts.store');
        });

      
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

Route::get('live_search/{crit}', 'Front\SearchController@liveSearch')->name('live.search')->middleware('Core');

// Web Routes
Route::group([
    'namespace' => 'Front',
    'middleware' => ['set.local', 'Core', 'shares'], // no need the web groub it's applied by default on this file (web.route)
    'prefix' => '{locale?}', // 'where' => ['lang' => '[a-zA-Z]{2}'],
], function ($router) {

    // Route::view('/', 'welcome');
    Route::view('/', 'welcome')->name('front.home');

    Route::get('search/{crit?}', 'SearchController@search')->name('front.search');

    // Route::group([
    //     'middleware' => ['prevent.back.history'],
    // ], function ($router) {

    //     Route::get('register', 'UserController@showRegistrationForm')->name('front.register');
    //     Route::post('register', 'UserController@store');

    //     Route::get('login', 'UserController@showLoginForm')->name('front.login');
    //     Route::post('login', 'UserController@login')->name('front.login');
    //     Route::post('logout', 'UserController@logout')->name('front.logout');

    //     Route::get('reset_password', 'PasswordController@showResetPassword')->name('password.reset');
    //     Route::post('reset_password', 'PasswordController@resetPassword')->name('password.reset')->middleware('throttle:4,1');
    //     Route::get('verify_password', 'PasswordController@showVerifyPassword')->name('password.verify');
    //     Route::post('verify_password', 'PasswordController@verifyPasswordCode')->name('password.verify');
    //     Route::get('change_password', 'PasswordController@showChangePassword')->name('password.change');
    //     Route::post('change_password', 'PasswordController@changePassword')->name('password.change')->middleware('throttle:4,1');
    //     Route::post('resend_code', 'PasswordController@resendCode')->name('password.resend_code')->middleware('throttle:4,1');

    //     // verifyPasswordCode

    //     Route::group([
    //         'prefix' => 'verifications',
    //     ], function () {
    //         Route::get('/', 'VerificationController@show')->name('front.verifications.show');
    //         Route::post('/', 'VerificationController@check')->name('front.verifications.check');
    //         Route::post('/resend_code', 'VerificationController@resendCode')->name('front.verifications.resend_code')->middleware('throttle:4,1');
    //     });

    //     Route::group([
    //         'middleware' => ['front', 'PreventBadWords'],
    //     ], function () {
    //         Route::get('/offers', 'IndexController@getOffers')->name('front.offers');
    //         Route::get('/coupons', 'IndexController@getCoupons')->name('front.coupons');

    //         Route::group([
    //             'prefix' => 'items',
    //         ], function () {
    //             Route::get('{id}', 'ItemController@show')->name('items.show');
    //             Route::post('store', 'ItemController@store')->name('items.store');
    //             Route::get('{id}/edit', 'ItemController@edit')->name('items.edit');
    //             Route::put('{id}', 'ItemController@update')->name('items.update');
    //             Route::post('{id}/delete', 'ItemController@delete')->name('items.delete');
    //             Route::post('like', 'ItemController@storeLike')->name('items.like');
    //             Route::get('{id}/comments', 'ItemController@getComments')->name('items.comments')->where('id', '[0-9]+');
    //             Route::DELETE('{id}/delete_file/{file_id}', 'ItemController@destroyFile')->name('front.items.destroy_file')->where(['id', '[0-9]+', 'file_id', '[0-9]+']);
    //         });

    //         Route::group([
    //             'prefix' => 'comments',
    //         ], function () {
    //             Route::post('/', 'CommentController@store')->name('comments.add');
    //             Route::get('/{id}/childs', 'CommentController@getCommentChilds')->name('comments.childs')->where('id', '[0-9]+');
    //         });

    //         Route::group([
    //             'prefix' => 'users',
    //         ], function () {
    //             Route::get('{id}', 'UserController@show')->name('user.show')->where('id', '[0-9]+');
    //             Route::get('{id}/profile', 'UserController@edit')->name('user.profile')->where('id', '[0-9]+');
    //             Route::put('{id}/update', 'UserController@update')->name('user.update')->where('id', '[0-9]+');
    //             Route::get('{id}/offers', 'UserController@getOffers')->name('user.offers')->where('id', '[0-9]+');
    //             Route::get('{id}/coupons', 'UserController@getCoupons')->name('user.coupons')->where('id', '[0-9]+');
    //             Route::get('{id}/likes', 'UserController@getLikes')->name('user.likes')->where('id', '[0-9]+');
    //             Route::get('{id}/comments', 'UserController@getComments')->name('user.comments')->where('id', '[0-9]+');
    //             Route::get('{id}/images', 'UserController@getImages')->name('user.images')->where('id', '[0-9]+');
    //             Route::post('background', 'UserController@updateBackground')->name('user.background');
    //             Route::post('image', 'UserController@updateImage')->name('user.image');
    //         });

    //         Route::group([
    //             'prefix' => 'info',
    //         ], function () {
    //             Route::get('/customer_service', 'InfoController@customerService')->name('front.info.customer_service');
    //             Route::get('/contactus', 'InfoController@contactUs')->name('front.info.contactus');
    //             Route::post('/contactus', 'InfoController@contactUsPost')->name('front.info.contactusPost')->middleware('throttle:3,1');
    //             Route::get('/aboutus', 'InfoController@aboutUs')->name('front.info.aboutus');
    //             Route::get('/terms', 'InfoController@terms')->name('front.info.terms');
    //             Route::get('/privacy_policy', 'InfoController@terms')->name('front.info.privacy_policy');
    //             // Route::get('/qa', 'InfoController@qa')->name('front.info.qa');
    //             // Route::post('/qa', 'InfoController@qa')->name('front.info.qa');
    //         });

    //         Route::PUT('notifications/{id}/readed', 'NotificationController@updateReadAt')->name('front.notifications.readed')->where('id', '[0-9]+');
    // });
    // });

});

// ["admin.categories.index","admin.categories.create","admin.categories.store","admin.categories.edit","admin.categories.update",
// "admin.categories.store_trans","admin.categories.status","admin.countries.index","admin.countries.create","admin.countries.store",
// "admin.countries.status","admin.settings.index","admin.settings.update","admin.sliders.index","admin.sliders.edit","admin.sliders.update",
// "admin.faqs.index","admin.faqs.store","admin.faqs.update","admin.faqs.delete","admin.contacts.index","admin.contacts.details","admin.settings.index",
// "admin.sliders.index","admin.categories.index","admin.sliders.delete","admin.orders.index","admin.chat.order","admin.orders.show","admin.orders.index",
// "admin.orders.deleteOrders","admin.bank_account.index","admin.bank_account.create","admin.bank_account.delete","admin.bank_account.update",
// "admin.how_to_use.index","admin.how_to_use.create","admin.how_to_use.update","delete","admin.orders.index","admin.orders.index","admin.orders.index",
// "admin.orders.index","admin.orders.index","admin.coupons.index","admin.coupons.create","admin.coupons.update","admin.coupons.delete","admin.offers.index",
// "admin.offers.edit","admin.offers.create","admin.offers.details.create","admin.offers.delete","admin.offers.details.delete","admin.offers.update",
// "admin.offers.delete_image","admin.offers.details.update","admin.offers.details.delete_image","admin.offers.details.edit","admin.commission.index",
// "admin.commission.not_paid","admin.commission.paid","admin.clients.index","admin.clients.status","admin.clients.create","admin.clients.store",
// "admin.clients.edit","admin.clients.update","admin.clients.index","admin.clients.orders","admin.clients.delete","admin.shipper.index","admin.shippers.create",
// "admin.shippers.store","admin.shippers.index","admin.shippers.orders","admin.shippers.status","admin.shippers.edit","admin.shippers.update",
// "admin.shippers.delete","admin.admins.","admin.admins.create","admin.admins.store","admin.admins.index","admin.admins.status","admin.admins.edit",
// "admin.admins.update","admin.admins.delete","admin.roles.index","admin.roles.create","admin.roles.store","admin.roles.edit","admin.roles.update",
// "admin.clients.create","admin.clients.store","admin.verify.show","admin.verify.check","admin.home","admin.settings.add_msg_type",
// "admin.settings.update_msg_type","admin.roles.set_current_role"]
