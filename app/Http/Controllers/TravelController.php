<?php

namespace App\Http\Controllers;

use App\Travel;
use App\User;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use Illuminate\Http\Request;
use Debugbar;

class TravelController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $travels = Travel::with('user')->get();
        return response()->json($travels);
    }

}
