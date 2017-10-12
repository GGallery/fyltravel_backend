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

}
