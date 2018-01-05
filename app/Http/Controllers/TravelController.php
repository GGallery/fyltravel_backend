<?php

namespace App\Http\Controllers;

use App\Travel;
use App\travel_consigliatoa;
use App\travel_image;
use App\travel_keywords;
use App\travel_scopo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use JWTAuth;
use Image;


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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_travel(Request $request)
    {
        $travel_id = $request->input('travel_id');
        $obj = Travel::with('scopo', 'keywords', 'consigliatoa' )->find($travel_id);
        return response()->json($obj);
    }


    // https://stackoverflow.com/questions/36318164/extending-eloquent-models-in-laravel-use-different-tables
    public function get_scopi()
    {
        $obj = travel_scopo::get();
        return response()->json($obj);
    }

    public function get_keywords()
    {
        $obj = travel_keywords::get();
        return response()->json($obj);
    }


    public function get_consigliatoa()
    {
        $obj = travel_consigliatoa::get();
        return response()->json($obj);
    }



    /**
     * Display a listing of best travel  resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_best_travel(Request $request)
    {
        $uid = $request->input('uid');
        $user = \App\User::where('uid', $uid)->first();
        $obj = Travel::where('author', $user->id)->orderBy('rate', 'desc')->take($request->input('amount'))->get();
        return response()->json($obj);
    }

    public function get_starred_travel(Request $request)
    {
        $obj = Travel::with('user')
            ->orderBy('rate', 'desc')
            ->take($request->input('amount'), 6)
            ->get();
        return response()->json($obj);
    }

    public function get_latest_travel(Request $request)
    {
        $obj = Travel::with('user')
            ->orderBy('rate', 'desc')
            ->take($request->input('amount'), 6)
            ->get();
        return response()->json($obj);
    }




    /**
     * Display a listing of the user travel.
     *
     * @return \Illuminate\Http\Response
     */
    public function userTravels(Request $request)
    {
        $uid = $request->input('uid');
        $user = \App\User::where('uid', $uid)->first();
        $travels = Travel::with('tappe', 'user', 'scopo', 'keywords', 'consigliatoa')->where('author' , $user->id)->get();
        return response()->json($travels);
    }


    /**
     * Display a listing of the user travel.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->input('search');

        if(!$search)
            return response()->json();

        $travels = Travel::with('tappe', 'user', 'scopo', 'keywords', 'consigliatoa')->where('title','like','%'.$search.'%')->get();

        return response()->json($travels);
    }


    /**
     * Count  user travel.
     *
     * @return \Illuminate\Http\Response
     */
    public function countTravel(Request $request)
    {
        $uid = $request->input('uid');
        $user = \App\User::where('uid', $uid)->first();
        $count = Travel::with('tappe')->where('author' , $user->id)->get()->count();
        return response()->json($count);
    }




    public function store(Request $request)
    {

        $user = JWTAuth::parseToken()->authenticate();

        $travel= new Travel();
        $travel->title = $request->input('title');
        $travel->author = $user->id;
        $travel->publish = 0    ;

        $travel->save();

        return response()->json($travel->id);
    }


    public function update(Request $request){

        $travel = Travel::find($request->input('id'));

        $travel->title= $request->input('title');
        $travel->description= $request->input('description');
        $travel->shortdescription= $request->input('shortdescription');
        $travel->hashtag = $request->input('hashtag');
        $travel->rate= $request->input('rate');
        $travel->publish= $request->input('publish');


        $travel->scopo()->sync((array)$request->input('scopi'));
        $travel->keywords()->sync((array)$request->input('keywords'));
        $travel->consigliatoa()->sync((array)$request->input('consigliatoa'));

        $travel->save();

        return response()->json('success');

    }

    public function upload_cover(Request $request){
        $travel_id = $request->input('travel_id');
        $current_cover = $request->input('current_cover');
        $file = $request->file("file");

        $filename = time().uniqid() . "." . $file->getClientOriginalExtension();
        Image::make($file)->save(public_path("/storage/_t/big/" . $filename));
        if(Image::make($file)->fit(400)->save(public_path("/storage/_t/cover/" . $filename)))
        {
            $obj= Travel::find($travel_id);
            $obj->cover = $filename;
            $obj->save();

            return response()->json(['file' => $filename, 'message' => "Immagine aggiunta correttamente e cancellata la vecchia"], 200);
        }
        return response()->json(['message' => "Error_setAvatar: No file provided !"], 404);
    }

    public function upload_media(Request $request){

        $id_travel = $request->input('travel_id');
        $file = $request->file("file");

        $filename = time().uniqid() . "." . $file->getClientOriginalExtension();

        $small  = Image::make($file)->fit(50)->save(public_path("/storage/_i/small/" . $filename));
        $medium = Image::make($file)->fit(200)->save(public_path("/storage/_i/medium/" . $filename));
        $big    = Image::make($file)->save(public_path("/storage/_i/big/" . $filename));

        if($big)
        {
            $obj= new travel_image();
            $obj->filename = $filename;
            $obj->id_travel = $id_travel;
            $obj->save();

            return response()->json(['file' => $filename, 'message' => "Immagine aggiunta correttamente e cancellata la vecchia"], 200);
        }

        return response()->json(['travel_id' => $id_travel, 'file' => $filename, 'message' => "Image add correctly"], 200);
        return response()->json(['message' => "Error_setAvatar: No file provided !"], 404);
    }

    public function upload_video(Request $request){
        $travel_id = $request->input('travel_id');
        $file = $request->file("file");

        $filename = time().uniqid() . ".mp4" . $file->getClientOriginalExtension();
        $path = public_path("/storage/_v/" );

        if($file->move($path, $filename))
        {
            $obj= Travel::find($travel_id);
            $obj->video = $filename;
            $obj->save();

            return response()->json(['file' => $filename, 'message' => "Video aggiunta correttamente "], 200);
        }

        return response()->json(['message' => "Error_setAvatar: No file provided !"], 404);
    }

    public function get_images(Request $request){
        $travel_id = $request->input('travel_id');
        $obj = travel_image::where('id_travel',$travel_id)->get();
        return response()->json($obj);
    }





}
