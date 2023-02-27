@extends('layouts.dashboard')
@section('content')
<div class="row">
   <div class="col-12">
      <div class="page-title-box">
         <h4 class="page-title">Edit location</h4>
      </div>
   </div>
</div>
<div class="card">
   <div class="card-body">
      <div align="center">
         <div class="w-50 text-start text-left" style="float: left;">
            <form  id="edit_location_form" method="POST" enctype="multipart/form-data" action="{{ route('location.update') }}">
            @csrf
             <input type="hidden" id="id" name="id"  value="{{$data->id}}">
            <div class="form-group fv-row mt-2">
               <label for="location name">Location name</label>
               <input type="text" class="form-control @error('location_name') is-invalid @enderror" @if(old('_token')) value="{{ old('location_name') }}" @else value="{{ $data->location_name }}" @endif id="location_name" name="location_name">
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-location_name" id="error_location_name"></span>
               @if($errors->has('location_name'))
                   <div class="error">{{ $errors->first('location_name') }}</div>
               @endif
            </div>
            <div class="form-group fv-row mt-2">
               <label for="latitude">Latitude</label>
               <input type="text" class="form-control @error('latitude') is-invalid @enderror" @if(old('_token')) value="{{ old('latitude') }}" @else value="{{ $data->latitude }}" @endif  id="latitude" name="latitude"  autocomplete="off">
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-latitude" id="error_latitude"></span>
               @if($errors->has('latitude'))
                   <div class="error">{{ $errors->first('latitude') }}</div>
               @endif
            </div>
            <div class="form-group fv-row mt-2">
               <label for="longitude">Longitude</label>
               <input type="text" class="form-control @error('longitude') is-invalid @enderror" @if(old('_token')) value="{{ old('longitude') }}" @else value="{{ $data->longitude }}" @endif id="longitude" name="longitude"  autocomplete="off">
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-longitude" id="error_longitude"></span>
                @if($errors->has('longitude'))
                   <div class="error">{{ $errors->first('longitude') }}</div>
               @endif
            </div>
            <div class="form-group fv-row mt-2">
               <label for="Description">Description</label>
               <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ $data->description }}</textarea>
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-description" id="error_description"></span>
               @if($errors->has('description'))
                   <div class="error">{{ $errors->first('description') }}</div>
               @endif
            </div>
            <div class="form-group fv-row mt-2">
               <label for="Image">Image</label>
               @if($locationsimg)
                  <div class="row">
                   @foreach($locationsimg as $key => $images)
                   <div class="col-sm-3 delimg" id="image_{{ $images->id }}">
                       <img src="{{asset('images/locationimage/'.$images->image_path)}}" alt="Image" style="margin-bottom: 10px;width:80px;height:80px;border: 1px solid;">
                        <i class="fa fa-trash delete-img" value="{{$images->image_path}}" data-id="{{$images->id}}"></i>
                   </div><br>
                   @endforeach
                </div>
               @endif
               <input class="form-control @error('images') is-invalid @enderror" style="height: auto;" type="file" id="images" name="images[]" multiple>
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-images" id="error_images"></span>
                 @if($errors->has('images'))
                      <div class="error">{{ $errors->first('images') }}</div>
                  @endif
                  @if ($errors->has('images.*'))
                     <div class="error">{{ $errors->first('images.*') }}</div>
                   @endif
            </div>
            <div class="form-group fv-row mt-2">
                @if($data->audio_file)
                 <a href="{{asset('audio/locationaudio/'.$data->audio_file)}}" download>{{$data->audio_file}}<br></a>
                 @endif
               <label for="Image">Audio file</label>
               <input class="form-control @error('audio_file') is-invalid @enderror" style="height: auto;" type="file" id="audio_file" name="audio_file">
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-audio_file" id="error_audio_file"></span>
                @if($errors->has('audio_file'))
                   <div class="error">{{ $errors->first('audio_file') }}</div>
               @endif
            </div>
            <div class="form-group fv-row mt-2">
                @if($data->video_file)
                 <a href="{{asset('video/locationvideo/'.$data->video_file)}}" download>{{$data->video_file}}<br></a>
                 @endif
               <label for="video_file">Video file</label>
               <input class="form-control @error('video_file') is-invalid @enderror" style="height: auto;" type="file" id="video_file" name="video_file">
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-video_file" id="error_video_file"></span>
               @if($errors->has('video_file'))
                   <div class="error">{{ $errors->first('video_file') }}</div>
               @endif
            </div>            
            <div class="text-left submit-section text-center mt-2">
               <center><button class="btn btn-primary" type="submit">Update</button></center>
            </div>
            </form>
         </div>
         <div class="w-50 float-end">
            <div id="map" style="width:450px; height:450px;margin-left:15px;margin-bottom:10px;"></div>
         </div>
      </div>
   </div>
</div>
<!--begin::Container-->
<!--end::Container-->
@endsection
@section('pagejs')
<script>
   var apiUrl = "{{ route('location.list') }}"; 
   var deleteimgurl = "{{ route('location.deleteimage',['id' => ':id']) }}"; 
   var updatelocationUrl = "{{ route('location.update') }}";
   var current_lat = '{{$data->latitude}}';
   var current_lan = '{{$data->longitude}}'; 
   var geo_counter = 0; 
   var map;
   var pos;
</script>
<!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDiKmRh2vEg2hiV1ZIVeyNlxPjVegpChvE&amp;libraries=places&amp;callback=initMap"
async defer></script>

<script src="{{asset('/')}}page/gmap.js?{{cacheclear()}}"></script>
<script src="{{asset('/')}}page/locationdetail.js?{{cacheclear()}}"></script>

@endsection
