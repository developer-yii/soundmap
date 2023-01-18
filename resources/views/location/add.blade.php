@extends('layouts.dashboard')
@section('content')
<div class="row">
   <div class="col-12">
      <div class="page-title-box">
         <h4 class="page-title">Add location</h4>
      </div>
   </div>
</div>
<div class="card">
   <div class="card-body">
      <div align="center">
         <div class="w-50 text-start text-left" style="float: left;">
            <form  id="create_user_form" method="POST" enctype="multipart/form-data" action="{{ route('location.add') }}">
            @csrf
            <div class="form-group fv-row mt-2">
               <label for="location name">Location name</label>
               <input type="text" class="form-control @error('location_name') is-invalid @enderror" value="{{ old('location_name') }}" id="location_name" name="location_name">
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-location_name" id="error_location_name"></span>
               @if($errors->has('location_name'))
                   <div class="error">{{ $errors->first('location_name') }}</div>
               @endif
            </div>
            <div class="form-group fv-row mt-2">
               <label for="latitude">Latitude</label>
               <input type="text" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude') }}"  id="latitude" name="latitude"  autocomplete="off">
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-latitude" id="error_latitude"></span>
               @if($errors->has('latitude'))
                   <div class="error">{{ $errors->first('latitude') }}</div>
               @endif
            </div>
            <div class="form-group fv-row mt-2">
               <label for="longitude">Longitude</label>
               <input type="text" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude') }}"  id="longitude" name="longitude"  autocomplete="off">
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-longitude" id="error_longitude"></span>
                @if($errors->has('longitude'))
                   <div class="error">{{ $errors->first('longitude') }}</div>
               @endif
            </div>
            <div class="form-group fv-row mt-2">
               <label for="Description">Description</label>
               <textarea id="description" name="description" value="{{ old('description') }}" class="form-control @error('description') is-invalid @enderror"></textarea>
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-description" id="error_description"></span>
               @if($errors->has('description'))
                   <div class="error">{{ $errors->first('description') }}</div>
               @endif
            </div>
            <div class="form-group fv-row mt-2">
               <label for="Image">Image</label>
               <input class="form-control @error('images') is-invalid @enderror" style="height: auto;" type="file" id="images" name="images[]" multiple>
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-audio_file" id="error_audio_file"></span>
               @if($errors->has('images'))
                   <div class="error">{{ $errors->first('images') }}</div>
               @endif
               @if ($errors->has('images.*'))
                  <div class="error">{{ $errors->first('images.*') }}</div>
                @endif

            </div>
            <div class="form-group fv-row mt-2">
               <label for="Image">Audio file</label>
               <input class="form-control @error('audio_file') is-invalid @enderror" style="height: auto;" type="file" id="audio_file" name="audio_file">
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-audio_file" id="error_audio_file"></span>
                @if($errors->has('audio_file'))
                   <div class="error">{{ $errors->first('audio_file') }}</div>
               @endif
            </div>
            <div class="form-group fv-row mt-2">
               <label for="video_file">Video file</label>
               <input class="form-control @error('video_file') is-invalid @enderror" style="height: auto;" type="file" id="video_file" name="video_file">
               <span class="error-border"></span>
               <span class="text-danger error invalid-data error-video_file" id="error_video_file"></span>
               @if($errors->has('video_file'))
                   <div class="error">{{ $errors->first('video_file') }}</div>
               @endif
            </div>            
            <div class="text-left submit-section text-center mt-2">
               <center><button class="btn btn-primary" type="submit">submit</button></center>
            </div>
            </form>
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
</script>

<script src="{{asset('/')}}page/locationdetail.js?{{cacheclear()}}"></script>

@endsection
