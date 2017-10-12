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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



//Route::post('/signup', [
//    'uses' => 'UserController@signup'
//]);
//
//Route::post('/signin', [
//    'uses' => 'UserController@signin'
//]);


//Route::get('travels', [
//    'uses' => 'TravelController@index'
//    , 'middleware' => 'auth.jwt'
//]);

//
Route::group(['middleware'=>'cors'], function (){
  Route::resource('book','BookController');
  Route::get('travels', [
      'uses' => 'TravelController@index',
      'middleware' => 'auth.jwt'
  ]);

    Route::post('/signup', [
        'uses' => 'UserController@signup'
    ]);

    Route::post('/signin', [
        'uses' => 'UserController@signin'
    ]);

});