<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$route = env('PACKAGE_ROUTE', '');
Route::get('/', function () {
    return "heel";//view('welcome');
});
/*
  Accessing uploaded files
*/
Route::get($route.'/storage/profiles/{filename}', function ($filename)
{
    $path = storage_path('/app/profiles/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
Route::get($route.'/storage/logo/{filename}', function ($filename)
{
    $path = storage_path('/app/logos/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('/cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'hey'.$exitCode;

    //
});
Route::get('/clear', function () {
    $exitCode = Artisan::call('config:cache');
    return 'hey'.$exitCode;

    //
});
Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'hey'.$exitCode;

    //
});
//For testing email template
Route::get('/demo', function () {
    return new App\Mail\Receipts();
});

/* Authentication Router */
$route = env('PACKAGE_ROUTE', '').'/authenticate';
Route::resource($route, 'AuthenticateController', ['only' => ['index']]);
Route::post($route, 'AuthenticateController@authenticate');
Route::post($route.'/user', 'AuthenticateController@getAuthenticatedUser');
Route::post($route.'/social-user', 'AuthenticateController@getSocialAuthenticatedUser');
Route::post($route.'/refresh', 'AuthenticateController@refreshToken');
Route::post($route.'/invalidate', 'AuthenticateController@deauthenticate');
Route::post($route.'/auth', function () {
    return true;
});

// Google Place
$route = env('PACKAGE_ROUTE', '').'/google_places/';
$controller = 'GooglePlaceController@';
Route::post($route.'search', $controller."search");

//Emails Controller
$route = env('PACKAGE_ROUTE', '').'/emails';
Route::post($route.'/create', "EmailController@create");
Route::post($route.'/retrieve', "EmailController@retrieve");
Route::post($route.'/update', "EmailController@update");
Route::post($route.'/delete', "EmailController@delete");
Route::post($route.'/reset_password', 'EmailController@resetPassword');
Route::post($route.'/verification', 'EmailController@verification');
Route::post($route.'/changed_password', 'EmailController@changedPassword');
Route::post($route.'/referral', 'EmailController@referral');
Route::post($route.'/trial', 'EmailController@trial');
Route::post($route.'/test_sms', 'EmailController@testSMS');

//Notification Settings Controller
$route = env('PACKAGE_ROUTE', '').'/notification_settings/';
$controller = 'NotificationSettingController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update_otp', $controller."generateOTP");
Route::post($route.'block_account', $controller."blockedAccount");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller.'test');


//Coupon Controller
$route = env('PACKAGE_ROUTE', '').'/coupons/';
$controller = 'CouponController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'validate', $controller."retrieveByValidation");
Route::post($route.'delete', $controller."delete");
Route::post($route.'update', $controller."update");

//Subscription Controller
$route = env('PACKAGE_ROUTE', '').'/subscriptions/';
$controller = 'SubscriptionController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'retrieve_by_params', $controller."retrieveByParams");
Route::post($route.'retrieve_by_merchant', $controller."retrieveSubscriptionByMerchant");
Route::post($route.'retrieve_graph', $controller."retrieveSubscribersGraph");
Route::post($route.'delete', $controller."delete");
Route::post($route.'update', $controller."update");

//Events Controller
$route = env('PACKAGE_ROUTE', '').'/events/';
$controller = 'EventController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'delete', $controller."delete");
Route::post($route.'update', $controller."update");

//Recently Visited Churches Controller
$route = env('PACKAGE_ROUTE', '').'/recently_visited_churches/';
$controller = 'RecentlyVisitedChurchesController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'delete', $controller."delete");
Route::post($route.'update', $controller."update");


//Payment Methods Controller
$route = env('PACKAGE_ROUTE', '').'/payment_methods/';
$controller = 'PaymentMethodController@';
Route::post($route.'create', $controller."create");
Route::post($route.'create_method', $controller."CreateMethod");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'retrieve_methods', $controller."RetrieveMethods");
Route::post($route.'delete', $controller."delete");
Route::post($route.'update', $controller."update");

//Announcements Controller
$route = env('PACKAGE_ROUTE', '').'/announcements/';
$controller = 'AnnouncementController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'delete', $controller."delete");
Route::post($route.'update', $controller."update");
