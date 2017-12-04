<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Namshi\JOSE\JWT;
use JWTException;
use JWTAuth;
use Image;

class UserController extends Controller
{


    public function signup(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $filename='empty.jpg';
        if($request->input('image')) {
            $filename = time() . uniqid() . ".jpg";
            Image::make($request->input('image'))->fit(200)->save(public_path("/storage/_p/big/" . $filename));
        }

        $user = new User([
            'name' => $request->input('name'),
            'uid' => time().uniqid(),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'provider' => $request->input('provider'),
            'image' => $filename
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
                return response()->json(['error' => 'Credenziali non valide'], 401);
            }
        }
        catch (JWTException $e){
            return response()->json(['error'=>'Non posso creare il token'],500);
        }

        $user = JWTAuth::toUser($token);

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200 );
    }

    public function get_userInfo(Request $request){

        $uid = $request->input('uid');
        $user = \App\User::where('uid', $uid)->first();
        $obj = \App\User::with('tipology')->find($user->id);
        return response()->json($obj);


    }
}
