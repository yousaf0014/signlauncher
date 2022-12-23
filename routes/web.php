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

Route::get('/', function () {	
    return view('welcome');
});

Route::get('/getPageNumber','UtilitiesController@getPageNumber');
Route::get('/getPage','UtilitiesController@getPage');
Route::get('/loadurl','UtilitiesController@loadurl');
Route::get('/autologout','UtilitiesController@autologout');
Route::get('/logoutUser','UtilitiesController@autologout');
Route::get('/logoutAnywhere','UtilitiesController@autologout');
Route::get('/logout','UtilitiesController@logout');

Route::get('paypal/express-checkout-success', 'PaypalController@expressCheckoutSuccess');
Route::post('paypal/notify', 'PaypalController@notify');
/*
Route::get('paypal/updateReoccuringPayment', 'PaypalController@updateReoccuringPayment');
Route::get('paypal/cancelReoccuringPayment', 'PaypalController@cancelReoccuringPayment');
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' =>['web']],function(){
	Route::get('/Devices','DevicesController@index');
	Route::get('/Devices/create','DevicesController@create');
	Route::get('/Devices/{device}','DevicesController@show');
	Route::get('/Devices/{device}/edit','DevicesController@edit');
	Route::post('/Devices','DevicesController@store');
	Route::put('/Devices/update/{device}','DevicesController@update');
	Route::delete('/Devices/{device}','DevicesController@delete');

	Route::get('/Channels','ChannelsController@index');
	Route::get('/Channels/create','ChannelsController@create');
	Route::get('/Channels/{channel}','ChannelsController@show');
	Route::get('/Channels/{channel}/edit','ChannelsController@edit');
	Route::post('/Channels','ChannelsController@store');
	Route::put('/Channels/update/{channel}','ChannelsController@update');
	Route::delete('/Channels/{channel}','ChannelsController@delete');

	Route::get('/Schdules/{channel}','SchdulesController@index');
	Route::get('/Schdules/create/{channel}','SchdulesController@create');
	Route::get('/Schdules/edit/{schdule}/{channel}','SchdulesController@edit');
	Route::get('/Schdules/{schdule}/{channel}','SchdulesController@show');
	Route::post('/Schdules/{channel}','SchdulesController@store');
	Route::put('/Schdules/update/{schdule}','SchdulesController@update');
	Route::delete('/Schdules/{schdule}','SchdulesController@delete');

	Route::get('/PlayLists','PlayListsController@index');
	Route::get('/PlayLists/create','PlayListsController@create');
	Route::get('/designPage/{playList}','PlayListsController@designPage');
	Route::get('/viewdesignPage/{playList}','PlayListsController@viewDesign');
	Route::post('/designPage/{playList}','PlayListsController@savedesignPage');
	Route::get('/PlayLists/{playList}','PlayListsController@show');
	Route::get('/PlayLists/{playList}/edit','PlayListsController@edit');
	Route::post('/PlayLists','PlayListsController@store');
	Route::put('/PlayLists/update/{playList}','PlayListsController@update');
	Route::delete('/PlayLists/{playList}','PlayListsController@delete');
	

	Route::get('/gallery/list', 'GalleryController@viewGalleryList');
	Route::post('/gallery/save', 'GalleryController@saveGallery');
	Route::get('/gallery/delete/{id}', 'GalleryController@deleteGallery');
	Route::get('/gallery/view/{id}', 'GalleryController@viewGalleryPics');
	Route::post('/image/do-upload', 'GalleryController@doImageUpload');

	Route::get('paywithpaypal', 'PaypalController@payWithPaypal');
	Route::POST('paypal/express-checkout', 'PaypalController@expressCheckout')->name('paypal.express-checkout');
	Route::get('/Invoices', 'PaypalController@index');
	Route::get('/Invoices/create', 'PaypalController@payWithPaypal');
	Route::get('/Invoices/{invoice}/edit','PaypalController@edit');
	Route::post('/Invoices/updateReoccuringPayment/{invoice}','PaypalController@updateReoccuringPayment')->name('Invoices.updateReoccuringPayment');
	Route::delete('/Invoices/{invoice}','PaypalController@cancelReoccuringPayment');

});