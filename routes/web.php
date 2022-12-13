<?php

use Illuminate\Support\Facades\Route;

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



Route::get('/', function () {
    // return view('welcome');
    return view('index');
});
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
// Route::middleware('admin')->group(function () {


// });
Route::get('/admin/login', 'Auth\AuthController@login')->name('login');
Route::get('/login', 'Auth\AuthController@login')->name('login');

Route::post('/login', 'Auth\AuthController@authenticate');

Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/home', 'Auth\AuthController@home')->name('home')->middleware(['auth']);
    Route::post('logout', 'Auth\AuthController@logout')->name('logout');
    // Route::get('/dashboard', 'HomeController@dashboard')->name('admin.home')->middleware('is_admin');

    // profile
    Route::get('/profile', 'ProfileController@index')->name('profile.view');
    // Users Route::get('/users', 'UserController@index')->name('users.index');
    Route::get('/users/view/{id}', 'UserController@viewUserdetails')->name('users.view');
    Route::get('/users/create', 'UserController@create')->name('users.create');
    Route::get('/users/index', 'UserController@index')->name('users.index');
    Route::post('/users/store', 'UserController@store')->name('users.store');
    Route::post('/users/distroy', 'UserController@distroy')->name('users.distroy');
    Route::post('/users/wallet', 'UserController@wallet')->name('users.wallet');
    // users
    Route::get('live-search/user', 'UserController@searchBox')->name('live_search.action');
    Route::get('user/{id}/status', 'UserController@statusUpdate')->name('user.status');
    Route::get('user/{id}/delete', 'UserController@destroy')->name('user.delete');
    Route::get("users-list", "UserController@getUsers")->name('user.list');

    // companyOffres
    Route::post('companyOffres/delete/{id}/', 'CompanyOffresController@destroy')->name('companyOffres.delete');
    Route::get('/companyOffres/view/{id}', 'CompanyOffresController@viewDriverdetails')->name('companyOffres.view');
    Route::get('/companyOffres/create', 'CompanyOffresController@create')->name('companyOffres.create');
    Route::get('/companyOffres/index', 'CompanyOffresController@index')->name('companyOffres.index');
    Route::post('/companyOffres/store', 'CompanyOffresController@store')->name('companyOffres.store');
    Route::post('/companyOffres/update', 'CompanyOffresController@updateProfile')->name('companyOffres.update');
    Route::get('/companyOffres/edit/{id}', 'CompanyOffresController@edit')->name('companyOffres.edit');
    Route::get('live-search/companyOffres', 'CompanyOffresController@searchBox')->name('live_search.companyOffres');
    Route::get('companyOffres-detail', 'CompanyOffresController@driverDetail')->name('companyOffres.detail');
    // Drivers
    Route::get('/drivers/view/{id}', 'DriverController@viewDriverdetails')->name('drivers.view');
    Route::get('/drivers/create', 'DriverController@create')->name('drivers.create');
    Route::get('/drivers/index', 'DriverController@index')->name('drivers.index');
    Route::post('/drivers/store', 'DriverController@store')->name('drivers.store');
    Route::post('/drivers/update', 'DriverController@updateProfile')->name('drivers.update');
    Route::get('/drivers/edit/{id}', 'DriverController@edit')->name('drivers.edit');
    // drivers
    Route::get('live-search/drivers', 'DriverController@searchBox')->name('live_search.driver');
    Route::get('driver/{id}/status', 'DriverController@statusUpdate')->name('driver.status');
    Route::get('driver/{id}/delete', 'DriverController@destroy')->name('driver.delete');
    Route::get('driver-detail', 'DriverController@driverDetail')->name('Driver.detail');

    // vehicle
    Route::get('live-search/vehicles', 'VehiclesController@searchBox')->name('live_search.vehicle');
    Route::get('vehicle/{id}/status', 'VehiclesController@statusUpdate')->name('vehicle.status');
    Route::get('/vehicle/index', 'VehiclesController@index')->name('vehicles.view');
    // Route::get('user/{id}/delete', 'DriverController@destroy')->name('driver.delete');

    // packages
    Route::get('live-search/Packages', 'PackageController@searchBox')->name('live_search.package');
    // Route::get('Package/{id}/status', 'PackageController@statusUpdate')->name('Package.status');
    Route::get('/package/index', 'PackageController@index')->name('packages.view');
    Route::get('/package/view/{id}', 'PackageController@packageDetails')->name('package.details');
    Route::post('/get-drivers', 'PackageController@getDrivers')->name('get.drivers');
    Route::post('/assign-driver', 'PackageController@assignDriver')->name('assign.driver');

    // contact us
    Route::get('/contact/index', 'ContactsController@index')->name('contact.view');
    Route::get('live-search/contact', 'ContactsController@searchBox')->name('live_search.Contact');
    Route::get('contact-detail', 'ContactsController@contactDetail')->name('Contact.detail');

    // Banner 
    Route::get('/banner/create', 'BannerController@create')->name('banner.create');
    Route::get('/banner/index', 'BannerController@index')->name('banner.index');
    // Route::post('/banner/store', 'BannerController@upload')->name('banner.upload');
    Route::get('banner/fetch', 'BannerController@fetch')->name('banner.fetch');
    Route::post('/banner/upload', 'BannerController@store')->name('banner.store');
    Route::get('/banner/edit', 'BannerController@edit')->name('banner.edit');

    Route::get('banner/delete', 'BannerController@delete')->name('banner.delete');

    // companies
    Route::get('/companies/create', 'CompanyController@create')->name('companies.create');
    Route::get('/companies/index', 'CompanyController@index')->name('companies.index');
    Route::post('/companies/store', 'CompanyController@store')->name('companies.store');
    Route::get('live-search/companies', 'CompanyController@searchBox')->name('live_search.companies');
    Route::get('companies/{id}/status', 'CompanyController@statusUpdate')->name('companies.status');
    Route::get('/companies/view/{id}', 'CompanyController@profile')->name('companies.view');

    Route::post('/companies/rate-store', 'CompanyController@storeRate')->name('companies.rate.store');
    Route::post('/companies/rate-discount', 'CompanyController@rateDiscount')->name('rate.discount');
    // Route::post('/companies/car-store', 'CompanyController@carStore')->name('companies.car.store');
    // Route::post('/companies/bike-store', 'CompanyController@bikeStore')->name('companies.bike.store');
    Route::get('/notification/index', 'NotificationController@index')->name('notification.index');
    Route::post('/notification/send', 'NotificationController@sendToUserApp')->name('notification.create');
    // special city routes
    Route::get('/special-city/index', 'SpecialCityController@index')->name('special-city.index');
    Route::get('/search-plus-load-data/special-city', 'SpecialCityController@searchPlusloadTableData')->name('search-plus-load-data.special-city');
    Route::get('/special-city/update', 'SpecialCityController@updateSpecialCity')->name('special-city.update');
    Route::get('/special-city/delete', 'SpecialCityController@deleteSpecialCity')->name('special-city.delete');
    Route::post('/special-city/store', 'SpecialCityController@storeSpecialCity')->name('special-city.store');
    
  //----- Promo code Apis route start ------- //
    Route::get('/promocode/create', 'PromoCodeController@create')->name('promocode.create');
	Route::post('/promocode/store', 'PromoCodeController@store')->name('promocode.store');
    Route::get('/promocode/index', 'PromoCodeController@index')->name('promocode.index');
     Route::get('promocode/fetch', 'PromoCodeController@fetch')->name('promocode.fetch');
    
 //----- Promo code Apis route end ------- //    
    
});

Route::get('privacy-policy', function () {
    return view('privacy');
})->name('privacy');

Route::get('terms-conditions', function () {
    return view('terms');
})->name('terms');
