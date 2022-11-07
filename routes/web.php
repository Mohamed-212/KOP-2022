<?php

use App\Http\Controllers\Website\OrdersController;



Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['forceHttps', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () { 
    // Authentication Routes
    Route::group(['prefix' => 'admin'], function () {
        Auth::routes(['register' => false]);
    });
    Route::get('/categories/{category}', 'Admin\ItemController@getCategory')->name('categoryitems');
    Route::get('admin/deal-of-week', 'Admin\ItemController@dealOfWeekItem')->name('admin.itemDealOfWeek')->middleware('auth');
    Route::get('/deal-of-week/status/{itemID}', 'Admin\ItemController@dealOfWeekStatus')->name('itemDealOfWeekStatus');

    // Admin Panel
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'], function () {
        // employees managment
        Route::resource('user', 'UserController')->middleware('role:admin');

        // roles and permision managment
        Route::resource('roles', 'RoleController')->middleware('role:admin');

        // Branches
        Route::resource('branch', 'BranchController')->middleware('role:admin');
        Route::resource('Anoucement', 'AnoucementController')->middleware('role:admin');
        Route::resource('notification', 'MessageController')->middleware('role:admin');
        Route::get('/show-gifts-orders', 'GiftController@showGiftsOrders')->name('showGiftsOrders')->middleware('role:admin');
        Route::get('/show-points-transactions', 'GiftController@showPointsTransactions')->name('showPointsTransactions')->middleware('role:admin');
        Route::resource('gift', 'GiftController')->middleware('role:admin');

        Route::resource('points', 'PointController')->middleware('role:admin,cashier');
        // Route::post('/points-value-post', 'PointController@pointsValuePost')->name('pointsValuePost')->middleware('role:admin,cashier');
        // Route::resource('/points', 'PointController')->middleware('role:admin,cashier');
        // Admin Dashboard
        Route::get('/home', 'HomeController@index')->name('home')->middleware('role:admin,cashier');
        Route::get('/', 'HomeController@index')->name('dashboard')->middleware('role:admin,cashier');

        Route::resource('hero', 'HeroController');

        Route::resource('customer', 'CustomerController')->middleware('role:admin,cashier');
        Route::resource('category', 'CategoryController')->middleware('role:admin,cashier');

        //homeitem
        Route::get('homeitem', 'ItemController@Homeitem')->name('homeitem.index')->middleware('role:admin');
        Route::get('homeitem/create', 'ItemController@Create_Homeitem')->name('homeitem.create')->middleware('role:admin');
        Route::post('homeitem/store', 'ItemController@Store_Homeitem')->name('homeitem.store')->middleware('role:admin');
        Route::get('homeitem/edit/{homeitem}', 'ItemController@Edit_Homeitem')->name('homeitem.edit')->middleware('role:admin');
        Route::post('homeitem/update/{homeitem}', 'ItemController@Update_Homeitem')->name('homeitem.update')->middleware('role:admin');
        Route::delete('homeitem/destroy/{homeitem}', 'ItemController@Destroy_Homeitem')->name('homeitem.destroy')->middleware('role:admin');
        //=======================================================================

        // item
        Route::resource('item', 'ItemController')->middleware('role:admin');
        Route::put('item/{item}/recommended', 'ItemController@recommend')->name('item.recommend')->middleware('role:admin');
        Route::delete('item/{item}/recommended', 'ItemController@unRecommend')->name('item.unrecommend')->middleware('role:admin');
        Route::resource('extra', 'ExtraController')->middleware('role:admin');
        Route::resource('without', 'WithoutController')->middleware('role:admin');
        Route::resource('order', 'OrderController')->middleware('role:admin');
        Route::resource('offer', 'OfferController')->middleware('role:admin');
        Route::put('offer/main/{offer}', 'OfferController@setAsMain')->name('offer.main')->middleware('role:admin');
        Route::delete('offer/main/{offer}', 'OfferController@removeFromMain')->name('offer.unmain')->middleware('role:admin');
        Route::resource('banner', 'BannerController')->middleware('role:admin');
        Route::resource('contact', 'ContactController')->middleware('role:admin');

        Route::resource('dough', 'DoughTypeController')->middleware('role:admin');

        // reports
        Route::group(['prefix' => 'reports', 'as' => 'report.', 'middleware' => 'role:admin'], function () {
            Route::get('customer', 'ReportController@getCustomer')->name('customer');
            Route::get('order', 'ReportController@getOrder')->name('order');
            Route::get('item', 'ReportController@getItem')->name('item');
            Route::get('extra', 'ReportController@getExtra')->name('extra');
            Route::get('order-status', 'ReportController@getOrderStatus')->name('order-status');
            Route::get('order-customer', 'ReportController@getOrderCustomer')->name('order-customer');
            Route::get('income', 'ReportController@getIncome')->name('income');
            Route::get('order-item', 'ReportController@getOrderItems')->name('order-item');
            Route::get('payments', 'ReportController@getPayments')->name('payments');
            Route::get('payments/{id}', 'ReportController@getOnePayment')->name('payments.one');
        });

        //healthinfo
        Route::group(['prefix' => 'healthinfo', 'as' => 'healthinfo.', 'middleware' => 'role:admin'], function () {
            Route::get('', 'HealthInfoController@index')->name('index');
            Route::get('create', 'HealthInfoController@create')->name('create');
            Route::post('store', 'HealthInfoController@store')->name('store');
            Route::patch('update/{id}', 'HealthInfoController@update')->name('update');
            Route::get('edit/{id}', 'HealthInfoController@edit')->name('edit');
            Route::get('show/{id}', 'HealthInfoController@show')->name('show');
            Route::delete('delete/{id}', 'HealthInfoController@delete')->name('delete');
        });

        //news
        Route::group(['prefix' => 'news', 'as' => 'news.', 'middleware' => 'role:admin'], function () {
            Route::get('', 'NewsController@index')->name('index');
            Route::get('create', 'NewsController@create')->name('create');
            Route::post('store', 'NewsController@store')->name('store');
            Route::patch('update/{id}', 'NewsController@update')->name('update');
            Route::get('edit/{id}', 'NewsController@edit')->name('edit');
            Route::get('show/{id}', 'NewsController@show')->name('show');
            Route::delete('delete/{id}', 'NewsController@delete')->name('delete');
        });

        //careers
        Route::group(['prefix' => 'careers', 'as' => 'careers.', 'middleware' => 'role:admin'], function () {
            Route::get('', 'CareersController@index')->name('index');
            Route::get('create', 'CareersController@create')->name('create');
            Route::post('store', 'CareersController@store')->name('store');
            Route::patch('update/{id}', 'CareersController@update')->name('update');
            Route::get('edit/{id}', 'CareersController@edit')->name('edit');
            Route::get('show/{id}', 'CareersController@show')->name('show');
            Route::get('{id}', 'CareersController@changestatus')->name('changestatus');
            Route::get('/{id}/applications', 'CareersController@GetApplications')->name('getapp');
            Route::delete('delete/{id}', 'CareersController@delete')->name('delete');
        });

        // AboutUS
        Route::resource('aboutUS', 'AboutUsController')->middleware('role:admin');
        // Gallery
        Route::resource('gallery', 'GalleryController')->middleware('role:admin');
        // Media
        Route::resource('media', 'MediaController')->middleware('role:admin');

        Route::resource('role', 'RoleController')->middleware('role:admin');
        Route::get('/permission/{id}', 'RoleController@permission')->middleware('role:admin')->name('get.permission');
        Route::patch('/permissions/{id}', 'RoleController@asignPermission')->middleware('role:admin')->name('asign.permission');
    });


    // Front routes
    Route::group(['namespace' => 'Website'], function () {

        // home
        Route::get('/', 'HomeController@homePage')->name('home.page');
        // aboutUS
        Route::get('/about-us', 'AboutUSController@aboutUSPage')->name('aboutUS.page');
        // gallery
        Route::get('/gallery', 'GalleryController@galleryPage')->name('gallery.page');
        // video
        Route::get('/video/{videoID?}', 'VideoController@videoPage')->name('video.page');
        // menu
        Route::get('/menu', 'MenuController@menuPage')->name('menu.page');
        // search
        Route::get('/search/item/', 'MenuController@searchItem')->name('search.page');


        Route::get('/careers/', [\App\Http\Controllers\Website\CareersControllers::class, 'AllJobs'])->name('careers.all');
        Route::get('/get-career/{id}', [\App\Http\Controllers\Website\CareersControllers::class, 'GetJob'])->name('get.career');
        Route::get('/apply-form/{id}', [\App\Http\Controllers\Website\CareersControllers::class, 'ApplyJobForm'])->name('apply.form');
        Route::post('/career-request', [\App\Http\Controllers\Website\CareersControllers::class, 'CareerRequest'])->name('career.request');

        Route::get('/whats-new/', [\App\Http\Controllers\Website\NewsController::class, 'AllBlogs'])->name('news.all');
        Route::get('/whats-new/{year}/{month}', [\App\Http\Controllers\Website\NewsController::class, 'blogsArchive'])->name('news.archive');
        Route::get('/whats-new/{id}', [\App\Http\Controllers\Website\NewsController::class, 'Blog'])->name('get.new');
        Route::get('/health-infos/', [\App\Http\Controllers\Website\HealthInfo::class, 'Infos'])->name('health-infos.all');
        Route::get('/health-infos/{id}', [\App\Http\Controllers\Website\HealthInfo::class, 'show'])->name('health-infos.show');
        Route::get('/health-infos/{year}/{month}', [\App\Http\Controllers\Website\HealthInfo::class, 'infosArchive'])->name('health-infos.archive');

        Route::get('/get-sign-in', [\App\Http\Controllers\Website\AuthController::class, 'get_login'])->name('get.login');
        Route::post('/signin', [\App\Http\Controllers\Website\AuthController::class, 'login'])->name('sign.in');

        Route::get('/signup', [\App\Http\Controllers\Website\AuthController::class, 'get_sign_up'])->middleware('web')->name('get.sign.up');
        Route::post('/get-sign-up', [\App\Http\Controllers\Website\AuthController::class, 'sign_up'])->name('sign.up'); //auth routes

        /* for verification */
        // Route::group(['middleware' => ['auth']], function() {
            Route::get('/verification-code', 'AuthController@get_code')->name('verifyCode.page');
            Route::post('resend-verification-code', 'AuthController@resendVerificationCode')->name('verifyCode.resend');
            Route::post('verify-account', 'AuthController@setVerificationCode')->name('verifyCode.save');
        // });

        /*********** Auth Routes ***********/


        Route::group(['middleware' => ['auth']], function () {
            //for all ordering route needs branch_id
            Route::group(['middleware' => 'service'], function () {
                // menu
                Route::get('/item/{category_id}/{item_id}', 'MenuController@itemPage')->name('item.page');

                //cart Route
                Route::post('/cart', 'CartController@addCart')->name('add.cart');
                Route::get('/get-cart/', [\App\Http\Controllers\Website\CartController::class, 'get_cart'])->name('get.cart');
                Route::get('/get-cart-res/', [\App\Http\Controllers\Website\CartController::class, 'get_cart_res'])->name('get.cart-res');
                Route::post('/delete-cart/', [\App\Http\Controllers\Website\CartController::class, 'delete_cart'])->name('delete.cart');
                Route::post('/update-quantity/', [\App\Http\Controllers\Website\CartController::class, 'update_quantity'])->name('update.quantity');
                Route::get('/get-check/', [\App\Http\Controllers\Website\CartController::class, 'get_check'])->name('get.check');


                // offers
                Route::get('/offers', 'OffersController@get_offers')->name('offers');
                Route::get('/offers/{oferID}', 'OffersController@offerItems')->name('offer.item');

                // payment
                Route::get('/payment', 'PaymentController@index')->name('get.payment');

                Route::post('/payment', 'PaymentController@index')->name('payment');
                Route::post('payment/order', 'PaymentController@get_payment')->name('do.payment');
                Route::post('payment/save', 'PaymentController@store_payment')->name('payment.store');
                Route::get('/payment/make-order', 'OrdersController@make_order_payment')->name('make-order.payment');
                Route::get('/payment/refund/{id}', 'PaymentController@refund')->name('get.refund');

                /*****************Begin Checkout And Orders Routes ****************/
                Route::post('get-checkout/', [\App\Http\Controllers\Website\CartController::class, 'get_checkout'])->name('checkout');
                Route::get('get-checkout-payment/', [\App\Http\Controllers\Website\CartController::class, 'get_checkout'])->name('payment.checkout');
                Route::post('make-order/', [\App\Http\Controllers\Website\OrdersController::class, 'make_order'])->name('make_order');
                /*****************End Checkout And Orders Routes ****************/
            });

            //my orders
            Route::get('my-orders/', [\App\Http\Controllers\Website\OrdersController::class, 'my_orders'])->name('get.orders');
            Route::get('order-details/{id}/{order?}', [\App\Http\Controllers\Website\OrdersController::class, 'my_orders_details'])->name('order.details');
            Route::get('re-order/{id}', [\App\Http\Controllers\Website\OrdersController::class, 're_order'])->name('re.order');
            Route::post('re-order/{id}/check', [OrdersController::class, 'checkIfOrderIsDirty'])->name('re-order-check');

            //profile
            Route::get('/profile/', [\App\Http\Controllers\Website\AddressController::class, 'get_address'])->name('profile');
            Route::get('/profile/map', [\App\Http\Controllers\Website\AddressController::class, 'get_address_map'])->name('profile.map');
            Route::get('/profile/addresses', [\App\Http\Controllers\Website\AddressController::class, 'get_address'])->name('profile.address');
            Route::post('/update-profile/', [\App\Http\Controllers\Website\UserController::class, 'update_user'])->name('update.profile');
            Route::delete('/delete_address/{address}', [\App\Http\Controllers\Website\AddressController::class, 'delete'])->name('delete_address');
            Route::post('/new-address/', [\App\Http\Controllers\Website\AddressController::class, 'store'])->name('new.address');
            Route::get('/update/{address}', [\App\Http\Controllers\Website\AddressController::class, 'update'])->name('update_address');

            //log out
            Route::post('/sign-out', [\App\Http\Controllers\Website\AuthController::class, 'logout'])->name('signout');

            //Loyalty Route
            Route::get('/loyalty/', [\App\Http\Controllers\Website\LoyalityController::class, 'get_loyalty'])->name('loyalty');
            Route::get('/profile/loyality',  [\App\Http\Controllers\Website\LoyalityController::class, 'getPage'])->name('profile.loyality');
            Route::get('/exchange/', [\App\Http\Controllers\Website\LoyalityController::class, 'get_loyalty_exchange'])->name('exchange.points');
            Route::get('/loyality/set/{value}/{points}', 'LoyalityController@setValue')->name('loyalty.set');
            Route::get('/loyality/unset', 'LoyalityController@unSetValue')->name('loyalty.unset');

            //choose service delivery or take away
            Route::get('/takeaway', 'ServiceController@takeawayPage')->name('takeaway.page');
            Route::get('/takeaway/{branch_id}/{service_type}', 'ServiceController@takeawayBranch')->name('takeaway.branch');

            // contactUS
            Route::get('/contact-us', 'ContactUSController@contactPage')->name('contact.page');
            Route::post('/contact', 'ContactUSController@store')->name('contact.store');
        });
    });

    Route::get('/privacy-policy', 'Website\PrivacyPolicyController@index')->name('privacy-policy');


    Route::get('/forget-password', [\App\Http\Controllers\Website\PasswordResetController::class, 'index'])->name('forget.password');
    Route::post('/get-reset-password', [\App\Http\Controllers\Website\PasswordResetController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Website\PasswordResetController::class, 'reset'])->name('password.get-reset');
    Route::get('/reset-password-code', [\App\Http\Controllers\Website\PasswordResetController::class, 'get_code'])->name('get.code');
    Route::post('/enter-code', [\App\Http\Controllers\Website\PasswordResetController::class, 'find'])->name('email.find');

    Route::group(['middleware' => ['auth'], 'prefix' => 'favourites', 'as' => 'favourites.'], function () {
        require __DIR__ . '/favourites_routes.php';
    });
});
