<?php

namespace App\Http\Controllers;

use App\Travel;
use App\User;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use Illuminate\Http\Request;
use Debugbar;
use JWTAuth;

class TravelController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if(! $user = JWTAuth::parseToken()->authenticate()){
//            return response()->json(['messge' => 'User Not found'],404);
//        }

        $travels = Travel::with('user')->get();
        return response()->json($travels);
    }



    /**
     * Display a listing of the user travel.
     *
     * @return \Illuminate\Http\Response
     */
    public function userTravels(Request $request)
    {

        if(!$token= $request->input('token')){
            return response()->json(['messge' => 'Token non valido'],404);
        }

        $user = JWTAuth::toUser($token);
        $travels = Travel::with('tappe', 'user')->where('author' , $user->id)->get();

        return response()->json($travels);
    }


    public function store(Request $request)
    {

        if(!$token= $request->input('token')){
            return response()->json(['messge' => 'Token non valido'],404);
        }

        $user = JWTAuth::toUser($token);

        $travel= new Travel();

        $travel->title = $request->input('title');
        $travel->description = $request->input('description');
        $travel->author = $user->id;
        $travel->publish = 1;

        $travel->save();

        return response()->json($travel);
    }

//39,3998718	-8,2244539
//6,4237499	-66,5897293
//40,7134247	-74,0055237
//35,86166	104,1953964
//49,2827301	-123,1207352



}
