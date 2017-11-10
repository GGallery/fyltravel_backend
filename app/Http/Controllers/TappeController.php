<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TappeController extends Controller
{
    //


 public function store(Request $request)
    {
//        if(! $user = JWTAuth::parseToken()->authenticate()){
//            return response()->json(['messge' => 'User Not found'],404);
//        }

        $obj= new Tappa();

        $obj->id_travel  = $request->input('latitude');
        $obj->latitude  = $request->input('latitude');
        $obj->longitude = $request->input('longitude');
        $obj->location = $request->input('location');

        $obj->save();

        return response()->json($obj);
    }

}
