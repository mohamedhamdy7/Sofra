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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'sofra','namespace'=>'Api'],function (){

    Route::get('cities','MainController@cities');

    Route::get('regions','MainController@regions');

    Route::get('categories','MainController@categories');

    Route::get('settings','MainController@settings');

    Route::post('contacts','MainController@contacts');

    Route::post('restaurants','MainController@restaurants');

    Route::post('restaurant','MainController@restaurant');

    Route::post('items','MainController@items');

    Route::post('offers','MainController@offers');

    Route::post('offer','MainController@offer');





});

Route::group(['prefix'=>'client','namespace'=>'Api\Client'],function (){

    Route::post('register','AuthController@register');

    Route::post('login','AuthController@login');

    Route::post('forgetPass','AuthController@forgetPass');

    Route::post('newpass','AuthController@newpass');



    Route::group(['middleware'=>'auth:client'],function (){

        Route::post('update','AuthController@update');


        Route::post('registerToken','AuthController@registerToken');

        Route::post('removeToken','AuthController@removeToken');

        Route::post('newOrder','MainController@newOrder');

        Route::post('myOrder','MainController@myOrder');

        Route::get('showOrder','MainController@showOrder');

        Route::get('latestOrder','MainController@latestOrder');

        Route::post('confirmOrder','MainController@confirmOrder');

        Route::post('declineOrder','MainController@declineOrder');

        Route::post('review','MainController@review');

    });



});







Route::group(['prefix'=>'restraunt','namespace'=>'Api\Restraunt'],function (){

    Route::post('register','AuthController@register');

    Route::post('login','AuthController@login');

    Route::post('forgetPass','AuthController@forgetPass');

    Route::post('newpass','AuthController@newpass');

    Route::post('ShowInformation','MainController@ShowInformation');



    Route::group(['middleware'=>'auth:restaurant'],function (){

        Route::post('update','AuthController@update');

        Route::post('registerToken','AuthController@registerToken');

        Route::post('removeToken','AuthController@removeToken');

        Route::post('AddItem','MainController@AddItem')->middleware('commission');

        Route::get('ShowItem','MainController@ShowItem')->middleware('commission');

        Route::post('UpdateItem','MainController@UpdateItem')->middleware('commission');

        Route::post('DeleteItem','MainController@DeleteItem')->middleware('commission');




        Route::post('AddOffer','MainController@AddOffer')->middleware('commission');

        Route::get('ShowOffer','MainController@ShowOffer')->middleware('commission');

        Route::post('UpdateOffer','MainController@UpdateOffer')->middleware('commission');

        Route::post('DeleteOffer','MainController@DeleteOffer')->middleware('commission');

        Route::post('commission','MainController@commission')->middleware('commission');



        Route::post('myOrders','MainController@myOrders')->middleware('commission');

        Route::get('showOrder','MainController@showOrder')->middleware('commission');

        Route::post('acceptOrder','MainController@acceptOrder')->middleware('commission');

        Route::post('rejectOrder','MainController@rejectOrder')->middleware('commission');

        Route::post('confirmOrder','MainController@confirmOrder')->middleware('commission');

        Route::post('changeState','MainController@changeState')->middleware('commission');

        //Route::post('payOff','MainController@payOff');

        Route::get('commission','MainController@commission');



    });


});