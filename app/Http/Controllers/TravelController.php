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

    public function store(Request $request)
    {
//        if(! $user = JWTAuth::parseToken()->authenticate()){
//            return response()->json(['messge' => 'User Not found'],404);
//        }

        $travel= new Travel();

        $travel->title = $request->input('title');
        $travel->description = $request->input('description');
        $travel->author = 1;
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
