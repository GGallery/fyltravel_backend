<?php

namespace App\Http\Controllers;

use App\Travel;
use App\travel_image;
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

        $obj = Travel::find($travel_id);

        return response()->json($obj    );
    }


    /**
     * Display a listing of the user travel.
     *
     * @return \Illuminate\Http\Response
     */
    public function userTravels(Request $request)
    {

        $user = JWTAuth::parseToken()->authenticate();
        $travels = Travel::with('tappe', 'user')->where('author' , $user->id)->get();

        return response()->json($travels);
    }


    public function store(Request $request)
    {

        $user = JWTAuth::parseToken()->authenticate();

        $travel= new Travel();
        $travel->title = $request->input('title');
        $travel->description = $request->input('description');
        $travel->author = $user->id;
        $travel->publish = 1;

        $travel->save();

        return response()->json($travel);
    }

    public function upload_cover(Request $request){
        $travel_id = $request->input('travel_id');
        $current_cover = $request->input('current_cover');
        $file = $request->file("file");

        $filename = time().uniqid() . "." . $file->getClientOriginalExtension();
        if(Image::make($file)->save(public_path("/storage/_t/" . $filename)))
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

    public function get_images(Request $request){
        $travel_id = $request->input('travel_id');
        $obj = travel_image::where('id_travel',$travel_id)->get();
        return response()->json($obj);
    }

}
