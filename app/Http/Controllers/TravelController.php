<?php

namespace App\Http\Controllers;

use App\Travel;
use App\User;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use Illuminate\Http\Request;
use Debugbar;
use JWTAuth;
use Image;

use Illuminate\Support\Facades\Storage;

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

        if($request->hasFile("file")) {
            $newcover = $request->file("file");
            $filename = time().uniqid() . "." . $newcover->getClientOriginalExtension();
            //Image::make($avatar)->fit(900)->save(public_path("/media/travel/" . $filename));
            if(Image::make($newcover)->save(public_path("/media/_t/" . $filename)))
            {
                $obj= Travel::find($travel_id);
                $obj->cover = $request->input('image');
                $obj->save();

                $path = public_path("/media/_t/" . $current_cover);
                $del = Storage::exists($path);

                return response()->json(['path' => $path, 'del' => $del, 'file' => $filename, 'message' => "Immagine aggiunta correttamente e cancellata la vecchia"], 200);
            }
        }
        return response()->json(['message' => "Error_setAvatar: No file provided !"], 404);
    }


    public function update_travel_image(Request $request){

        if(!$token= $request->input('token')){
            return response()->json(['messge' => 'Token non valido'],404);
        }
        $travel_id = $request->input('travel_id');
        $obj= Travel::find($travel_id);
        $obj->image = $request->input('image');
        $obj->save();
        return response()->json(['message' => "Image save correctly"], 200);
    }





    public function upload_media(Request $request){

        $travel_id = $request->input('travel_id');
        if($request->hasFile("file")) {
            $avatar = $request->file("file");
            $filename = time().uniqid() . "." . $avatar->getClientOriginalExtension();
            //Image::make($avatar)->fit(900)->save(public_path("/media/travel/" . $filename));
            Image::make($avatar)->save(public_path("/media/_i/". $travel_id. "/".$filename));
            return response()->json(['travel_id' => $travel_id, 'file' => $filename, 'message' => "Image add correctly"], 200);
        }
        return response()->json(['message' => "Error_setAvatar: No file provided !"], 404);
    }






//39,3998718	-8,2244539
//6,4237499	-66,5897293
//40,7134247	-74,0055237
//35,86166	104,1953964
//49,2827301	-123,1207352



}
