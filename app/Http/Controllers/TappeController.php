<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tappe;


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



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_tappe(Request $request)
    {
        $travel_id = $request->input('travel_id');
        $obj = Tappe::where('id_travel', $travel_id)->get();
        return response()->json($obj);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function set_tappe(Request $request)
    {
        $travel_id = $request->input('travel_id');
        $tappe =$request->input('tappe');
        Tappe::where('id_travel', $travel_id)->delete();

        foreach ($tappe as  $tappa) {

            $obj = new Tappe;
            $obj->id_travel= $travel_id;
            $obj->latitude= $tappa['latitude'];
            $obj->longitude= $tappa['longitude'];
            $obj->location= $tappa['location'];
            $obj->save();

        }
        return response()->json(['message' => 'Save succefully'], 200);
    }



}
