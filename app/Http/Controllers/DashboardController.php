<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\locations;

class DashboardController extends Controller
{
    public function index()
    {
        $locations = locations::all();        

        $locData = [];

        foreach ($locations as $key => $location) {
            $locData[]=[floatval($location->longitude),floatval($location->latitude),$location->id,'http://maps.google.com/mapfiles/ms/micons/blue.png'];
        }

        if(count($locations))
        {
            $locationsimg = \DB::table('location_image')->select('location_id','image_path','id')->whereNotNull('image_path')->where('location_id',$locations[0]->id)->whereNull('deleted_at')->get();
        }        

        return view('dashboard.index',compact('locations','locData','locationsimg'));
    }

    public function getLocationDetail(Request $request)
    {
        if($request->ajax()) 
        {            
            if($request->id)
            {
                $location = locations::find($request->id);

                if($location)
                {                       
                    $videoSource = ($location->video_file)?asset('video/locationvideo/'.$location->video_file):'';
                    $audioSource = ($location->audio_file)?asset('audio/locationaudio/'.$location->audio_file):'';

                    $locationsimg = \DB::table('location_image')->select('location_id','image_path','id')->whereNotNull('image_path')->where('location_id',$location->id)->whereNull('deleted_at')->get();

                    $result = ['status' => true, 'location' => $location, 'videoSource' => $videoSource, 'audioSource' => $audioSource, 'locationsimg' => $locationsimg];
                    return response()->json($result);
                }
                else
                {
                    $result = ['status' => false, 'message' => 'failed to fetch details'];
                    return response()->json($result);   
                }
            }
        }       
        
    }
}
