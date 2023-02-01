<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\locations;
use DB;

class SiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }

    public function map(Request $request)
    {

        $data = locations::get();
        $array=array();

        foreach ($data as $key => $value) {
            $array[]=[floatval($value->longitude),floatval($value->latitude),$value->id,'http://maps.google.com/mapfiles/ms/micons/blue.png'];
        }
   
        return view('map.map',["array" => $array]);
    }

    public function detail(Request $request){
        $location_details = locations::find($request->id);

        $locationsimg = \DB::table('location_image')->select('location_id','image_path','id')->whereNotNull('image_path')->where('location_id',$request->id)->whereNull('deleted_at')->get();

        $result = ['status' => true, 'message' => '', 'data' => $location_details,"locationsimg"=>$locationsimg];

        return response()->json($result);
    }
    
}
