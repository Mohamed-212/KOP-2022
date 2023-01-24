<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'auth'], function () {
    Route::post('login/cashier', 'Api\AuthController@loginCashier');
    Route::post('login/google', 'Api\AuthController@loginWithGoogle');
    Route::post('login/facebook', 'Api\AuthController@loginWithFacebook');
});

Route::middleware('api')->group(function () {
    Route::group(['prefix' => 'offers', 'middleware' => 'auth.api'], function () {
        Route::get('/', 'Api\OffersController@index2')->name("offers.index2");
        Route::get('/discount/{offer}', 'Api\OffersController@get_discount2');
        Route::get('/{offer}', 'Api\OffersController@get');
    });

    Route::group(['middleware' => ['auth.api'], 'prefix' => 'orders'], function () {
        // list all orders
        Route::get('/', "Api\OrdersController@index")->name('api.orders.index2');
        Route::get('/order-history', "Api\OrdersController@order_history")->name('api.orders.order_history2');
        Route::get('/today-orders', "Api\OrdersController@today_orders")->name('api.orders.today_orders2');
        // create an order
        // Route::post('/', "Api\OrdersController@store")->name('api.orders.store');
        // reoder an order
        // Route::post('/reoder', "Api\OrdersController@re_order")->name('api.orders.reoder');

        // accept an order
        Route::put('/{order}/accept', "Api\OrdersController@acceptOrder")->name('api.orders.accept2');

        // reject an order
        Route::put('/{order}/reject', "Api\OrdersController@rejectOrder")->name('api.orders.reject2');

        // complete an order
        Route::put('/{order}/complete', "Api\OrdersController@completeOrder")->name('api.orders.complete2');

        // cancel an order
        Route::put('/{order}/cancel', "Api\OrdersController@cancelOrder2")->name('api.orders.cancel2');

        // get specific order by id
        Route::get('/{order}', "Api\OrdersController@getById2")->name('api.orders.getById2');

        Route::post('/branch', "Api\OrdersController@getBranch2")->name('api.orders.branch2');
    });

    Route::get('/get-user-orders', "Api\OrdersController@getUserOrders2")->name('api.getUserOrders2')->middleware('auth.api');
});

Route::get('/notifications', 'Api\GetNotificationLogs@getAllNotification')->name('notifications.all')->middleware('auth.api');





Route::group(['prefix' => 'new'], function () {

    Route::get('unauthenticated', 'Api\AuthController@getUnAuth')->name('unauthenticated');

    Route::get('/home', 'Api\FrontController@getHomeSections')->middleware('authIfTokenFound')->name('home');

    // Authintication routes
    Route::group(['prefix' => 'auth'], function () {

        Route::post('login', 'Api\AuthController@login');
        Route::post('login/cashier', 'Api\AuthController@loginCashier');
        Route::post('register', 'Api\AuthController@register');
        Route::post('activate/{token}', 'Api\AuthController@signupActivate');
        Route::post('login/google', 'Api\AuthController@loginWithGoogle');
        Route::post('login/facebook', 'Api\AuthController@loginWithFacebook');

        Route::group(['prefix' => 'password'], function () {
            Route::post('create', 'Api\PasswordResetController@create');
            Route::get('find/{token}', 'Api\PasswordResetController@find');
            Route::post('reset', 'Api\PasswordResetController@createNewPassword')->name('reset');
            Route::view('/success', 'api.success')->name('api.success');
            Route::view('/faild', 'api.faild')->name('api.faild');
        });

        Route::post('resend-code', 'Api\AuthController@resendCode');
        /* for verification */
        Route::post('resend-verification-code', 'Api\AuthController@resendVerificationCode');
        Route::post('verify-account', 'Api\AuthController@setVerificationCode');

        Route::post('verify-user/{id}', 'Api\AuthController@activateUser')->name('verify-user');

        Route::group(['middleware' => ['auth.api', 'verifyTwilio']], function () {
            Route::get('user', 'Api\AuthController@getUser');
            Route::put('user', 'Api\AuthController@updateUser');
            Route::get('logout', 'Api\AuthController@logout');
        });
    });

    Route::get('get-branch-working-hours', 'Api\BranchesController@getBranchWorkingHours');

    Route::middleware('api')->group(function () {

        Route::group(['middleware' => ['auth.api']], function () {
            Route::get('get-user-points', 'Api\AuthController@getUserPoints');
            Route::post('change-user-points', 'Api\AuthController@changeUserPoints');
            Route::get('get-gifts', 'Api\GiftsController@getGifts');
            Route::post('buy-gifts', 'Api\GiftsController@buyGifts');
            Route::get('get-user-gifts-orders', 'Api\GiftsController@getUserGiftsOrders');
        });


        Route::group(['prefix' => 'cart'], function () {
            Route::get('get-cart', 'Api\CartController@getCart');
            Route::post('add-cart', 'Api\CartController@addCart');
            Route::post('delete-cart', 'Api\CartController@deleteCart');
            Route::post('update-quantity', 'Api\CartController@updateQuantity');
        });

        Route::group(['prefix' => 'banners'], function () {
            Route::get('', 'Api\BannerController@index');
        });
        Route::group(['prefix' => 'contacts'], function () {
            Route::post('create', 'Api\ContactController@store');
        });
        // branch routes
        Route::group(['prefix' => 'branches'], function () {
            Route::get('', 'Api\BranchesController@index');
            Route::Get('/{branch}', 'Api\BranchesController@show');
            Route::Get('/check/{branch}', 'Api\BranchesController@check');
        });


        Route::post('/set-push-token', "Api\NotificationController@setPushToken")->name('api.setPushToken');
        Route::post('/set-first-offer-flag', "Api\AuthController@setFirstOfferFlag")->name('api.setFirstOfferFlag');

        Route::get('/get-user-orders', "Api\OrdersController@getUserOrders")->name('api.getUserOrders')->middleware('auth.api');


        // orders routes
        Route::group(['middleware' => ['auth.api'], 'prefix' => 'orders'], function () {
            // list all orders
            Route::get('/', "Api\OrdersController@index")->name('api.orders.index');
            Route::get('/order-history', "Api\OrdersController@order_history")->name('api.orders.order_history');
            Route::get('/today-orders', "Api\OrdersController@today_orders")->name('api.orders.today_orders');
            // create an order
            Route::post('/', "Api\OrdersController@store")->name('api.orders.store');
            // reoder an order
            Route::post('/reoder', "Api\OrdersController@re_order")->name('api.orders.reoder');

            // accept an order
            Route::put('/{order}/accept', "Api\OrdersController@acceptOrder")->name('api.orders.accept');

            // reject an order
            Route::put('/{order}/reject', "Api\OrdersController@rejectOrder")->name('api.orders.reject');

            // complete an order
            Route::put('/{order}/complete', "Api\OrdersController@completeOrder")->name('api.orders.complete');

            // cancel an order
            Route::put('/{order}/cancel', "Api\OrdersController@cancelOrder")->name('api.orders.cancel');

            // get specific order by id
            Route::get('/{order}', "Api\OrdersController@getById")->name('api.orders.getById');

            Route::post('/branch', "Api\OrdersController@getBranch")->name('api.orders.branch');
        });

        Route::group(['middleware' => ['auth.api']], function () {
            Route::get('/points/history', 'Api\OrdersController@getPointsHistory')->name('points.history');
            Route::get('/points/screen', 'Api\OrdersController@getPointsScreen')->name('points.screen');
        });

        // get points table
        Route::get('/points/values', 'Api\OrdersController@pointValues')->name('points.table');

        //payment
        Route::post('/payment/complete', 'Api\OrdersController@orderPayed');


        Route::group(['prefix' => 'offers', 'middleware' => 'auth.api'], function () {
            Route::get('/', 'Api\OffersController@index')->name("offers.index");
            Route::get('/discount/{offer}', 'Api\OffersController@get_discount');
            Route::get('/{offer}', 'Api\OffersController@get');
        });
        // offers routes
        Route::group(['middleware' => ['auth.api'], 'prefix' => 'offers'], function () {
            Route::get('/check/{order_id}', 'Api\OffersController@check');
            Route::post('/delivery-offer/{address_id}', 'Api\OffersController@delivery_offer');
            Route::post('/takeway-offer/{branch_id}', 'Api\OffersController@takeway_offer');
        });

        // Address routes
        Route::group(['middleware' => ['auth.api']], function () {
            Route::resource('/address', 'Api\AddressesController');
            Route::post('/addressmaps', 'Api\AddressesController@sotreWithMaps');
            Route::post('/add-address', 'Api\AddressesController@sotre');
            Route::post('/check-location', 'Api\AddressesController@checkLocation');

            Route::put('/deactivate', 'Api\FrontController@deactivate');
        });
    });

    Route::get('/deactivation_reasons', 'Api\FrontController@deactivation_reasons');

    // Menu routes
    Route::group(['prefix' => 'menu', 'middleware' => ['authIfTokenFound']], function () {

        // categories 
        Route::get('/categories', 'Api\MenuController@getAllCategories');
        Route::post('/categories/{category}', 'Api\MenuController@getCategory');

        // items
        Route::post('/categories/{category}/items', 'Api\MenuController@getItems');

        Route::post('/categories/{item}/item', 'Api\MenuController@getItem');

        Route::post('/categories/{category}/getitems', 'Api\MenuController@getCategoryItems');

        // extras
        Route::get('/categories/{category}/extras', 'Api\MenuController@getExtras');
        // Route::get('/extras/{extra}/', 'Api\MenuController@getCategory');

        Route::get('/categories/{category}/withouts', 'Api\MenuController@getWithouts');

        Route::get('/recommended', 'Api\MenuController@getRecommendedItems');
    });
    Route::get('/payment/make-order', 'Api\OrdersController@make_order_payment')->name('api.make-order.payment');
    Route::get('/payment/{id}/{amount}/{hash}/{branch}', 'Api\PaymentController@index')->name('get.paymentMobile');
    Route::post('payment/save', 'Api\PaymentController@store_payment')->middleware('auth.api')->name('api.payment.store');

    Route::post('/payment/check/{hash}', 'Api\PaymentController@check')->middleware('auth.api')->name('check.paymentMobile');

    // helper endpoints
    Route::get('/cities', "Api\HelperController@getCities");
    Route::get('/cities/{city}/areas', "Api\HelperController@getAreas");
    Route::get('/v1/cities/search', 'Api\HelperController@search')
        ->name('api.cities.search');
    // Front routes
    Route::group(['prefix' => 'website'], function () {

        // aboutUS
        Route::get('/aboutUS', 'Api\FrontController@getAboutUS');
        // gallery
        Route::get('/gallery', 'Api\FrontController@getGallery');
        // media
        Route::get('/media/{videoID?}', 'Api\FrontController@getVideo');
        // news
        Route::get('/news', 'Api\FrontController@getAllNews');
        Route::get('/news/{newID}', 'Api\FrontController@getNew');
        // health info
        Route::get('/health-info', 'Api\FrontController@getAllHealthInfo');
        // careers
        Route::get('/careers', 'Api\FrontController@getAllJobs');
        Route::post('/careers/{id}', 'Api\FrontController@jobRequest');
    });
    Route::group(['middleware' => ['auth.api']], function () {
        Route::get('/payment/refund/{id}', 'Api\PaymentController@refund');
        Route::get('/payment/response', 'Api\PaymentController@paymentResponse');
        // Route::get('/payment/{amount}', 'Api\PaymentController@index')->name('get.paymentMobile');
        Route::post('payment/check', 'Api\PaymentController@get_payment')->name('do.paymentMobile');
    });

    Route::get('/notifications/logs/', 'Api\GetNotificationLogs')->name('notifications.logs')->middleware('auth.api');
    Route::get('/notifications', 'Api\GetNotificationLogs@getAllNotification')->name('notifications.all')->middleware('auth.api');


    Route::group(['middleware' => ['auth.api'], 'prefix' => 'favourites', 'as' => 'api.favourites.'], function () {
        require __DIR__ . '/favourites_routes.php';
    });
});

// Route::get('unauthenticated', 'Api\AuthController@getUnAuth')->name('unauthenticated');

// Route::get('/home', 'Api\FrontController@getHomeSections')->middleware('authIfTokenFound')->name('home');

// // Authintication routes
// Route::group(['prefix' => 'auth'], function () {

//     Route::post('login', 'Api\AuthController@login');
//     Route::post('login/cashier', 'Api\AuthController@loginCashier');
//     Route::post('register', 'Api\AuthController@register');
//     Route::post('activate/{token}', 'Api\AuthController@signupActivate');
//     Route::post('login/google', 'Api\AuthController@loginWithGoogle');
//     Route::post('login/facebook', 'Api\AuthController@loginWithFacebook');

//     Route::group(['prefix' => 'password'], function () {
//         Route::post('create', 'Api\PasswordResetController@create');
//         Route::get('find/{token}', 'Api\PasswordResetController@find');
//         Route::post('reset', 'Api\PasswordResetController@createNewPassword')->name('reset');
//         Route::view('/success', 'api.success')->name('api.success');
//         Route::view('/faild', 'api.faild')->name('api.faild');
//     });

//     Route::post('resend-code', 'Api\AuthController@resendCode');
//     /* for verification */
//     Route::post('resend-verification-code', 'Api\AuthController@resendVerificationCode');
//     Route::post('verify-account', 'Api\AuthController@setVerificationCode');

//     Route::post('verify-user/{id}', 'Api\AuthController@activateUser')->name('verify-user');

//     Route::group(['middleware' => ['auth.api', 'verifyTwilio']], function () {
//         Route::get('user', 'Api\AuthController@getUser');
//         Route::put('user', 'Api\AuthController@updateUser');
//         Route::get('logout', 'Api\AuthController@logout');
//     });
// });

// Route::get('get-branch-working-hours', 'Api\BranchesController@getBranchWorkingHours');

// Route::middleware('api')->group(function () {

//     Route::group(['middleware' => ['auth.api']], function () {
//         Route::get('get-user-points', 'Api\AuthController@getUserPoints');
//         Route::post('change-user-points', 'Api\AuthController@changeUserPoints');
//         Route::get('get-gifts', 'Api\GiftsController@getGifts');
//         Route::post('buy-gifts', 'Api\GiftsController@buyGifts');
//         Route::get('get-user-gifts-orders', 'Api\GiftsController@getUserGiftsOrders');
//     });


//     Route::group(['prefix' => 'cart'], function () {
//         Route::get('get-cart', 'Api\CartController@getCart');
//         Route::post('add-cart', 'Api\CartController@addCart');
//         Route::post('delete-cart', 'Api\CartController@deleteCart');
//         Route::post('update-quantity', 'Api\CartController@updateQuantity');
//     });

//     Route::group(['prefix' => 'banners'], function () {
//         Route::get('', 'Api\BannerController@index');
//     });
//     Route::group(['prefix' => 'contacts'], function () {
//         Route::post('create', 'Api\ContactController@store');
//     });
//     // branch routes
//     Route::group(['prefix' => 'branches'], function () {
//         Route::get('', 'Api\BranchesController@index');
//         Route::Get('/{branch}', 'Api\BranchesController@show');
//         Route::Get('/check/{branch}', 'Api\BranchesController@check');
//     });


//     Route::post('/set-push-token', "Api\NotificationController@setPushToken")->name('api.setPushToken');
//     Route::post('/set-first-offer-flag', "Api\AuthController@setFirstOfferFlag")->name('api.setFirstOfferFlag');

//     Route::get('/get-user-orders', "Api\OrdersController@getUserOrders")->name('api.getUserOrders')->middleware('auth.api');


//     // orders routes
//     Route::group(['middleware' => ['auth.api'], 'prefix' => 'orders'], function () {
//         // list all orders
//         Route::get('/', "Api\OrdersController@index")->name('api.orders.index');
//         Route::get('/order-history', "Api\OrdersController@order_history")->name('api.orders.order_history');
//         Route::get('/today-orders', "Api\OrdersController@today_orders")->name('api.orders.today_orders');
//         // create an order
//         Route::post('/', "Api\OrdersController@store")->name('api.orders.store');
//         // reoder an order
//         Route::post('/reoder', "Api\OrdersController@re_order")->name('api.orders.reoder');

//         // accept an order
//         Route::put('/{order}/accept', "Api\OrdersController@acceptOrder")->name('api.orders.accept');

//         // reject an order
//         Route::put('/{order}/reject', "Api\OrdersController@rejectOrder")->name('api.orders.reject');

//         // complete an order
//         Route::put('/{order}/complete', "Api\OrdersController@completeOrder")->name('api.orders.complete');

//         // cancel an order
//         Route::put('/{order}/cancel', "Api\OrdersController@cancelOrder")->name('api.orders.cancel');

//         // get specific order by id
//         Route::get('/{order}', "Api\OrdersController@getById")->name('api.orders.getById');

//         Route::post('/branch', "Api\OrdersController@getBranch")->name('api.orders.branch');
//     });

//     Route::group(['middleware' => ['auth.api']], function () {
//         Route::get('/points/history', 'Api\OrdersController@getPointsHistory')->name('points.history');
//         Route::get('/points/screen', 'Api\OrdersController@getPointsScreen')->name('points.screen');
//     });

//     // get points table
//     Route::get('/points/values', 'Api\OrdersController@pointValues')->name('points.table');

//     //payment
//     Route::post('/payment/complete', 'Api\OrdersController@orderPayed');


//     Route::group(['prefix' => 'offers', 'middleware' => 'auth.api'], function () {
//         Route::get('/', 'Api\OffersController@index')->name("offers.index");
//         Route::get('/discount/{offer}', 'Api\OffersController@get_discount');
//         Route::get('/{offer}', 'Api\OffersController@get');
//     });
//     // offers routes
//     Route::group(['middleware' => ['auth.api'], 'prefix' => 'offers'], function () {
//         Route::get('/check/{order_id}', 'Api\OffersController@check');
//         Route::post('/delivery-offer/{address_id}', 'Api\OffersController@delivery_offer');
//         Route::post('/takeway-offer/{branch_id}', 'Api\OffersController@takeway_offer');
//     });

//     // Address routes
//     Route::group(['middleware' => ['auth.api']], function () {
//         Route::resource('/address', 'Api\AddressesController');
//         Route::post('/addressmaps', 'Api\AddressesController@sotreWithMaps');
//         Route::post('/add-address', 'Api\AddressesController@sotre');
//         Route::post('/check-location', 'Api\AddressesController@checkLocation');

//         Route::put('/deactivate', 'Api\FrontController@deactivate');
//     });
// });

// Route::get('/deactivation_reasons', 'Api\FrontController@deactivation_reasons');

// // Menu routes
// Route::group(['prefix' => 'menu', 'middleware' => ['authIfTokenFound']], function () {

//     // categories 
//     Route::get('/categories', 'Api\MenuController@getAllCategories');
//     Route::post('/categories/{category}', 'Api\MenuController@getCategory');

//     // items
//     Route::post('/categories/{category}/items', 'Api\MenuController@getItems');

//     Route::post('/categories/{item}/item', 'Api\MenuController@getItem');

//     Route::post('/categories/{category}/getitems', 'Api\MenuController@getCategoryItems');

//     // extras
//     Route::get('/categories/{category}/extras', 'Api\MenuController@getExtras');
//     // Route::get('/extras/{extra}/', 'Api\MenuController@getCategory');

//     Route::get('/categories/{category}/withouts', 'Api\MenuController@getWithouts');

//     Route::get('/recommended', 'Api\MenuController@getRecommendedItems');
// });
// Route::get('/payment/make-order', 'Api\OrdersController@make_order_payment')->name('api.make-order.payment');
// Route::get('/payment/{id}/{amount}/{hash}/{branch}', 'Api\PaymentController@index')->name('get.paymentMobile');
// Route::post('payment/save', 'Api\PaymentController@store_payment')->middleware('auth.api')->name('api.payment.store');

// Route::post('/payment/check/{hash}', 'Api\PaymentController@check')->middleware('auth.api')->name('check.paymentMobile');

// // helper endpoints
// Route::get('/cities', "Api\HelperController@getCities");
// Route::get('/cities/{city}/areas', "Api\HelperController@getAreas");
// Route::get('/v1/cities/search', 'Api\HelperController@search')
//     ->name('api.cities.search');
// // Front routes
// Route::group(['prefix' => 'website'], function () {

//     // aboutUS
//     Route::get('/aboutUS', 'Api\FrontController@getAboutUS');
//     // gallery
//     Route::get('/gallery', 'Api\FrontController@getGallery');
//     // media
//     Route::get('/media/{videoID?}', 'Api\FrontController@getVideo');
//     // news
//     Route::get('/news', 'Api\FrontController@getAllNews');
//     Route::get('/news/{newID}', 'Api\FrontController@getNew');
//     // health info
//     Route::get('/health-info', 'Api\FrontController@getAllHealthInfo');
//     // careers
//     Route::get('/careers', 'Api\FrontController@getAllJobs');
//     Route::post('/careers/{id}', 'Api\FrontController@jobRequest');
// });
// Route::group(['middleware' => ['auth.api']], function () {
//     Route::get('/payment/refund/{id}', 'Api\PaymentController@refund');
//     Route::get('/payment/response', 'Api\PaymentController@paymentResponse');
//     // Route::get('/payment/{amount}', 'Api\PaymentController@index')->name('get.paymentMobile');
//     Route::post('payment/check', 'Api\PaymentController@get_payment')->name('do.paymentMobile');
// });

// Route::get('/notifications/logs/', 'Api\GetNotificationLogs')->name('notifications.logs')->middleware('auth.api');
// Route::get('/notifications', 'Api\GetNotificationLogs@getAllNotification')->name('notifications.all')->middleware('auth.api');


// Route::group(['middleware' => ['auth.api'], 'prefix' => 'favourites', 'as' => 'api.favourites.'], function () {
//     require __DIR__ . '/favourites_routes.php';
// });
