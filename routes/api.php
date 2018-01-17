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


Route::group(['middleware'=>'auth.jwt'], function () {

    Route::get('/checkToken  ', function () {
        return response()->json(true);
    });
});

Route::post('userTravels',   ['uses' => 'TravelController@userTravels' ]);

Route::post('userItinerari',   ['uses' => 'TravelController@userItinerari' ]);




Route::post('newtravel',    ['uses' => 'TravelController@store' ]);

Route::post('updatetravel',    ['uses' => 'TravelController@update' ]);

Route::post('updatetravel',    ['uses' => 'TravelController@update' ]);

Route::post('get_travel',   ['uses' => 'TravelController@get_travel' ]);

Route::post('get_tappe',   ['uses' => 'TappeController@get_tappe' ]);

Route::post('get_best_travel',   ['uses' => 'TravelController@get_best_travel' ]);

Route::post('get_latest_travel',   ['uses' => 'TravelController@get_latest_travel' ]);

Route::post('get_starred_travel',   ['uses' => 'TravelController@get_starred_travel' ]);


Route::post('get_images',   ['uses' => 'TravelController@get_images' ]);

Route::post('get_scopi',   ['uses' => 'TravelController@get_scopi' ]);

Route::post('get_keywords',   ['uses' => 'TravelController@get_keywords' ]);

Route::post('get_consigliatoa',   ['uses' => 'TravelController@get_consigliatoa' ]);

Route::post('set_tappe',    ['uses' => 'TappeController@set_tappe' ]);

Route::post('upload_cover', ['uses' => 'TravelController@upload_cover' ]);

Route::post('upload_media', ['uses' => 'TravelController@upload_media' ]);

Route::post('upload_video', ['uses' => 'TravelController@upload_video' ]);

Route::post('upload_profile_image', ['uses' => 'UserController@upload_profile_image' ]);



Route::post('search', ['uses' => 'TravelController@search' ]);



//}

Route::post('get_CountTravel',     ['uses' => 'TravelController@countTravel' ]);
Route::post('get_UserInfo',     ['uses' => 'UserController@get_userInfo' ]);

Route::post('signup',     ['uses' => 'UserController@signup' ]);

Route::post('signin',      ['uses' => 'UserController@signin' ]);
// });