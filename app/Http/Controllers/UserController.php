<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Namshi\JOSE\JWT;
use JWTException;
use JWTAuth;

class UserController extends Controller
{


    public function signup(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();

        return response()->json([
            'message' => 'Utente creato correttamente'
        ], 200 );
    }

    public function signin(Request $request){

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credential = $request->only('email' , 'password');
        
        try{
            if ( !$token = JWTAuth::attempt($credential)){
                    return response()->json(['error' => 'Invalid Token'], 401);
            }
        }
        catch (JWTException $e){
            return response()->json(['error'=>'Non posso creare il token'],500);
        }

        return response()->json([
            'token' => $token
        ], 200 );
    }

    //
}
