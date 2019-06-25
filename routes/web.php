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



Auth::routes();

Route::group(['middleware'=>'auth'], function(){

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('city','CityController');

    Route::resource('region','RegionController');

    Route::resource('category','CategoryController');

    Route::resource('offer','OfferController');

    Route::resource('restaurant','RestaurantController');

    Route::resource('setting','SettingController');

    Route::resource('client','ClientController');

    Route::resource('order','OrderController');

    Route::resource('contact','ContactController');


    Route::get('client/{id}/activate', 'ClientController@activate');

    Route::get('client/{id}/de-activate', 'ClientController@deActivate');

  Route::get('restaurant/{id}/activate', 'RestaurantController@activate');

    Route::get('restaurant/{id}/de-activate', 'RestaurantController@deActivate');


    Route::get('user/change-password','UserController@changePassword');

    Route::post('user/change','UserController@changePasswordSave');


});


