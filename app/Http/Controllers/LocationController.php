<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\locations;
use App\locationimgs;
use Validator;
use Illuminate\Validation\Rule;
use DataTables;
use File;
use Carbon\Carbon;
use DB;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {   

       return view('location.list');

    }

    public function viewlocation(Request $request)
    {
        return view("location.add");
    }
    

    public function getlocationdetails(Request $request){
        if ($request->ajax()) {
            $data = locations::oldest()->get();   
            return Datatables()::of($data)
                ->addIndexColumn()
               
                ->rawColumns(['Actions','description'])
                ->make(true);
        }        
         return DataTables::eloquent($data)->toJson();
    }

    public function delete(Request $request){

        $location = locations::find($request->id);
        if($location->delete()){
            $result = ['status' => true, 'message' => 'location Delete successfully'];
        }else{
            $result = ['status' => false, 'message' => 'Delete fail'];
        }
        return response()->json($result);
    }

    public function edit(Request $request)
    {
        $data = locations::where("id", $request->id)->first();
        $locationsimg = \DB::table('location_image')->select('location_id','image_path','id')->whereNotNull('image_path')->where('location_id',$request->id)->whereNull('deleted_at')->get();

        if ($data) {
            return view("location.edit", ["data" => $data,"locationsimg"=>$locationsimg]);
        }
    }

     public function update(Request $request){

        $customMessages = [
                'location_name.required' => 'Location name is required',
                'latitude.required' => 'Latitude  is required',
                'longitude.required' => 'Longitude is required',
                'description.required' => 'Description is required',
                'images.required' => 'Please select images',
                "images.mimes" =>'Please select images only ' ,
                "audio_file.mimes" =>'Select audio file  is only ' ,
                "video_file.mimes" =>'Select video file is only' ,

            ];
            
            $validator = Validator::make($request->all(),[
                "location_name" => ["required"],
                'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],             
                'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
                // "latitude" => ["required"],
                // "longitude" => ["required", "string"],
                "description" => ["required", "string"],
                "audio_file" => ["mimes:ogg,mp3"],
                "video_file" => ["mimes:mp4,ogg"],
                "images.*" => ["mimes:jpeg,jpg,png,gif"],
                "images" => ["array","min:1"],

            ],$customMessages);
                // dd($validator);
                if($validator->fails()){

                    $result = ["status" => false,"error" => $validator->errors(),"data" => [],];
                        return response()->json($result);

                    // return redirect()->back()->withErrors($validator->errors())->withInput($request->input());

                }else{

                $updatelocation = locations::where("id", $request->id)->first();
                $updatelocation->location_name =$request->location_name;
                $updatelocation->latitude = $request->latitude;
                $updatelocation->longitude = $request->longitude;
                $updatelocation->description = $request->description;

                if (!empty($request->audio_file)) {
                    if ($updatelocation->audio_file) {
                        $path = public_path('audio/locationaudio/'.$updatelocation->audio_file);
                        if (file_exists($path)) {
                            unlink($path);
                        }
                        
                    }
                     $uniqueid=uniqid();
                     $original_name=$request->file('audio_file')->getClientOriginalName();
                     $size=$request->file('audio_file')->getSize();
                     $extension=$request->file('audio_file')->getClientOriginalExtension();
                     $filename=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
                     $audiopath=public_path('audio/locationaudio');
                     //$audiopath=url('/storage/upload/files/audio/'.$filename);
                     $request->file('audio_file')->move($audiopath.'/',$filename);   
                     //$path=$file->storeAs('public/upload/files/audio/',$filename);
                     $updatelocation->audio_file = $filename;
                }

                if (!empty($request->video_file)) {
                    if ($updatelocation->video_file) {
                        $path = public_path('video/locationvideo/'.$updatelocation->video_file);
                        if (file_exists($path)) {
                            unlink($path);
                        }
                     }
                     $uniqueid=uniqid();
                     $original_name=$request->file('video_file')->getClientOriginalName();
                     $size=$request->file('video_file')->getSize();
                     $extension=$request->file('video_file')->getClientOriginalExtension();
                     $filename=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
                     $videopath=public_path('video/locationvideo');
                     //$audiopath=url('/storage/upload/files/audio/'.$filename);
                     $request->file('video_file')->move($videopath.'/',$filename);   
                     //$path=$file->storeAs('public/upload/files/audio/',$filename);
                     $updatelocation->video_file = $filename;
                }

                if($updatelocation->update()){
                     $image=array();
                     $directoryPath=public_path('images/locationimage/'.$updatelocation->id);
                        if (!file_exists($directoryPath)) {
                             $folder =File::makeDirectory($directoryPath);
                        }

                    // $folder =File::makeDirectory($directoryPath);
                    $time = time();

                    if($files=$request->file('images')){
                        foreach($files as $file){
                            $imageName = $time.'_'.$file->getClientOriginalName();
                            $file->move($directoryPath.'/',$imageName);                            
                            $image[]=$updatelocation->id.'/'.$imageName;
                        }
                    }

                    if($filedata=$request->file('images')){
                        $count = 1;
                        foreach($filedata as $fdata){
                            $name=$time.'_'.$fdata->getClientOriginalName();
                            $locationimage = new locationimgs();
                            $locationimage->location_id = $updatelocation->id;
                            $locationimage->image_path =$updatelocation->id.'/'.$time.'_'.$fdata->getClientOriginalName();
                            $locationimage->save();
                            $count++;
                        }
                    } 

                    $result = [ "status" => true, "message" => 'location Update successfully',"data" => route("location")];
                    return response()->json($result);

                    // return redirect()->route('location');                     
                }
                else{
                     return redirect()->back()->withErrors($updatelocation->getErrors())->withInput($request->input());
                }
            }  
    }

    public function deleteimage(Request $request){

        $locationimage = locationimgs::where("id", $request->id)->first();
          $path = public_path('images/locationimage/'.$locationimage->image_path);
            if (file_exists($path)) {
                unlink($path);
            }       
        if($locationimage->delete()){
            $result = ['status' => true, 'message' => 'Delete successfully'];
        }else{
            $result = ['status' => false, 'message' => 'Delete fail'];
        }
        
        return response()->json($result);
    }

     public function add(Request $request){
        
           $customMessages = [
                'location_name.required' => 'Location name is required',
                'latitude.required' => 'Latitude  is required',
                'latitude.required' => 'Latitude  is required',
                'longitude.regex' => 'Latitude value appears to be incorrect format.',
                'longitude.regex' => 'Longitude value appears to be incorrect format.',
                'description.required' => 'Description is required',
                'images.required' => 'Please select images',
                "images.*.mimes" =>'Please select images only ' ,
                "audio_file.required" =>'Audio file  is required' ,
                "audio_file.mimes" =>'Select audio file  is only ' ,
                "video_file.required" =>'Video file is required' ,
                "video_file.mimes" =>'Select video file is only' ,

            ];
            
            $validator = Validator::make($request->all(),[
                "location_name" => ["required"],
                'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],             
                'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
                // "latitude" => ["required"],
                // "longitude" => ["required", "string"],
                "description" => ["required", "string"],
                "audio_file" => ["required","mimes:ogg,mp3"],
                "video_file" => ["required","mimes:mp4,ogg"],
                "images.*" => ["required", "mimes:jpeg,jpg,png,gif"],
                "images"    => ["required","array","min:1"],

            ],$customMessages);
                if($validator->fails()){

                        $result = ["status" => false,"error" => $validator->errors(),"data" => [],];
                        return response()->json($result);

                    // return redirect()->back()->withErrors($validator->errors())->withInput($request->input());

                }else{
                    // dd($request->all());
                        $locations = new locations;
                        $locations->location_name = $request->location_name;
                        $locations->latitude = $request->latitude;
                        $locations->longitude = $request->longitude;
                        $locations->description = $request->description;
                        $locations->location_name = $request->location_name;

                        if($request->hasFile('audio_file')){
                         $uniqueid=uniqid();
                         $original_name=$request->file('audio_file')->getClientOriginalName();
                         $size=$request->file('audio_file')->getSize();
                         $extension=$request->file('audio_file')->getClientOriginalExtension();
                         $filename=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
                         $audiopath=public_path('audio/locationaudio');
                         //$audiopath=url('/storage/upload/files/audio/'.$filename);
                         $request->file('audio_file')->move($audiopath.'/',$filename);   
                         //$path=$file->storeAs('public/upload/files/audio/',$filename);
                         $locations->audio_file = $filename;
                        }

                        if($request->hasFile('video_file')){
                         $uniqueid=uniqid();
                         $original_name=$request->file('video_file')->getClientOriginalName();
                         $size=$request->file('video_file')->getSize();
                         $extension=$request->file('video_file')->getClientOriginalExtension();
                         $filename=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
                         $videopath=public_path('video/locationvideo');
                         //$audiopath=url('/storage/upload/files/audio/'.$filename);
                         $request->file('video_file')->move($videopath.'/',$filename);   
                         //$path=$file->storeAs('public/upload/files/audio/',$filename);
                         $locations->video_file = $filename;
                        }

                            if($locations->save()){
                                 $image=array();
                                 $directoryPath=public_path('images/locationimage/'.$locations->id);
                                    if (!file_exists($directoryPath)) {
                                         $folder =File::makeDirectory($directoryPath);
                                    }

                                // $folder =File::makeDirectory($directoryPath);
                                $time = time();

                                if($files=$request->file('images')){
                                    foreach($files as $file){
                                        $imageName = $time.'_'.$file->getClientOriginalName();
                                        $file->move($directoryPath.'/',$imageName);                            
                                        $image[]=$locations->id.'/'.$imageName;
                                    }
                                }

                                if($filedata=$request->file('images')){
                                    $count = 1;
                                    foreach($filedata as $fdata){
                                        $name=$time.'_'.$fdata->getClientOriginalName();
                                        $locationimage = new locationimgs();
                                        $locationimage->location_id = $locations->id;
                                        $locationimage->image_path =$locations->id.'/'.$time.'_'.$fdata->getClientOriginalName();
                                        $locationimage->save();
                                        $count++;
                                    }
                                } 

                                $result = [ "status" => true, "message" => 'location Add successfully',"data" => route("location")];
                                return response()->json($result);

                                // return redirect()->route('location');                     
                            }else{
                                 return redirect()->back()->withErrors($locations->getErrors())->withInput($request->input());
                            }
                }    
          
       }
}
