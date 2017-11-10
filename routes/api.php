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



// Route::group(['middleware'=>'cors'], function (){
Route::resource('book','BookController');


Route::get('userTravels', [
    'uses' => 'TravelController@userTravels',
    'middleware' => 'auth.jwt'
]);

Route::post('newtravel', [
    'uses' => 'TravelController@store',
    'middleware' => 'auth.jwt'
]);

Route::post('get_travel', [
    'uses' => 'TravelController@get_travel',
    'middleware' => 'auth.jwt'
]);


Route::post('get_tappe', [
    'uses' => 'TappeController@get_tappe',
    'middleware' => 'auth.jwt'
]);

Route::post('set_tappe', [
    'uses' => 'TappeController@set_tappe',
    'middleware' => 'auth.jwt'
]);


Route::post('updatetravelimage', [
    'uses' => 'TravelController@update_travel_image'
]);


Route::post('upload_copertina', [
    'uses' => 'TravelController@upload_copertina'
]);



Route::post('/signup', [
    'uses' => 'UserController@signup'
]);

Route::post('/signin', [
    'uses' => 'UserController@signin'
]);
// });