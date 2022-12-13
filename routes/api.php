<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
    // Route::get('/customers', 'CustomerController@index')->name('customers')->middleware('admin');
});

Route::group(['middleware' => ['cors']], function () {

     // Validate promo code
     Route::get('/verify-promocode', 'API\PromoCodeController@show')->name('verify.promocode');



    // public routes
    Route::post('/login', 'API\AuthController@login')->name('login.api');
    Route::post('/device-register', 'API\AuthController@deviceRegister')->name('device.register');
    Route::post('/driver-login', 'API\DriverController@login')->name('driver.register');
});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'API\AuthController@logout')->name('logout.api');
    Route::get('/customers', 'CustomerController@index')->name('customers')->middleware('admin');
    Route::post('/register', 'API\AuthController@register')->name('register.api');
    // packages
    Route::post('/create-packages', 'API\PackageController@store')->name('package.store');
    Route::post('/orders-list', 'API\PackageController@list')->name('package.list');
    //sender  address
    Route::post('/sender-address-list', 'API\AddressController@index')->name('address.sender.index');
    Route::post('/store-sender-address', 'API\AddressController@store')->name('address.sender.store');
    Route::post('/address-details', 'API\AddressController@details')->name('address.details');
    Route::post('/address-delete', 'API\AddressController@destroy')->name('address.destroy');
    Route::post('/address-update', 'API\AddressController@updateAddress')->name('address.update');

    //reciever  address
    Route::post('/reciever-address-list', 'API\AddressController@index')->name('address.reciever.index');
    Route::post('/store-reciever-address', 'API\AddressController@store')->name('address.reciever.store');
    Route::post('/address-details', 'API\AddressController@details')->name('address.details');

    // user profile
    Route::post('/user-profile', 'API\UserController@profileDetails')->name('show.profile');
    Route::post('/update-user-profile', 'API\UserController@update')->name('update.profile');
    Route::post('/profile-image', 'API\UserController@profileImage')->name('profile.image');

    // order placed
    Route::post('/place-order', 'API\OrderController@createOrder')->name('place.order');
    Route::post('/order-details', 'API\OrderController@orderStatus')->name('order.status');

    // cancel order
    Route::post('/cancel-order', 'API\OrderController@cancelOrder')->name('cancel.order');
    // Contact us
    Route::post('/contact-us', 'API\ContactsController@store')->name('contact.store');
    // Contact us
    Route::post('/banners', 'API\BannerController@index')->name('banner.index');

    // driver listing
    Route::post('/drivers', "API\DriverController@index")->name('driver.list');

    // language
    Route::post('/language', "API\UserController@language")->name('language');

    // deactivate account
    Route::post('/deactivate', "API\UserController@deactivate")->name('deactivate');

    // shipping type
    Route::post('/shipping-type', "API\PackageController@companyList")->name('shipping.type');

    // vehicle Availability
    Route::post('/vehicle-avail', "API\DriverController@vehicleAvailability")->name('vehicle.avail');

    // vehicle Availability
    Route::post('/review-driver', "API\DriverController@reviewDriver")->name('review.driver');

    // Company Offres
    Route::get('/company_offres', 'API\DriverController@company_offres')->name('company_offres');


});
// Driver api section
Route::middleware('auth:api-driver')->group(function () {
    // Route::get('/drivers', "API\DriverController@index")->name('sample.test');

    // driver logout
    Route::post('/driver-logout', 'API\DriverController@logout')->name('logout.driver');
    // check in api
    Route::post('/check-in', 'API\DriverController@activity')->name('check.in');
    // check out api
    Route::post('/check-out', 'API\DriverController@activity')->name('check.out');

    Route::post('/location-update', 'API\DriverController@locationUpdate')->name('location.update');

    // order request
    Route::post('/order-requests', 'API\DriverController@orderList')->name('orders.request');

    // accpt-orders
    Route::post('/accept-order', 'API\DriverController@acceptOrder')->name('accept.order');
    // accept order
    Route::post('/active-orders', 'API\DriverController@activeOrders')->name('active.order');

    // order Details
    Route::post('/orders-detail', 'API\DriverController@orderDetails')->name('orders.details');
    // driver profile images

    // update driver profile
    Route::post('/update-driver-profile', 'API\DriverController@updateProfile')->name('update.driver');
    // accept order
    Route::post('/deliver-history', 'API\DriverController@deliverHistory')->name('deliver.history');
    // deliverOrder
    Route::post('/deliver-order', 'API\DriverController@deliverOrder')->name('deliver.order');
    // profile images
    Route::post('/driver-profile-image', 'API\DriverController@profileImage')->name('deliver.profile');

    Route::get('/movex-onesignal', 'API\OnesignalController@index')->name('movex.onesignal');
    
  
    Route::post('/create-offser-deliver', 'API\DriverController@createOfferDeliver')->name('movex.createOfferDeliver');

    // Route::get('/movex-onesignal', 'API\OnesignalController@index')->name('movex.onesignal');

});


Route::get('/get-offser-deliver', 'API\DriverController@getOfferDeliver')->name('movex.getOfferDeliver');





