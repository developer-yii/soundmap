@extends('layouts.forntend')
@section('content')
		<div id="map" style="width: 1000px; height: 600px;"></div>
@section('modal')
<!-- /.modal -->
<div id="location-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class=""><span class="">Location Details</span> </h4> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
                <div class="modal-body">
                <div class="row ">
                    <div class="row mt-2">
                        <label class="col-md-6">Location name:</label>
                        <div id="location_name" class="col-md-6"></div>
                    </div>
                    <div class="row mt-2">
                        <label class="col-md-6">Latitude :</label>
                        <div id="latitude" class="col-md-6"></div>
                    </div>
                    <div class="row mt-2">
                        <label class="col-md-6">Longitude :</label>
                        <div id="longitude" class="col-md-6"></div>
                    </div>
                    <div class="row mt-2">
                        <label class="col-md-6">Description:</label>
                        <div id="description" class="col-md-6"></div>
                    </div>
                    <div class="row mt-2">
                        <label class="col-md-6">Audio file:</label>
                        <div class="audio_song">
	                        <audio controls>
							  <source src="" id="audio_file_ogg" type="audio/ogg">
							  <source src="" id="audio_file" type="audio/mpeg">
							</audio>
						</div>
                        <div id="" class="col-md-6"></div>
                    </div>
                    <div class="row mt-2">
                        <label class="col-md-6">Video file:</label>
                         <div class="video_song">
	                        <video width="400" controls >
							  <source src="" id="video_file" type="video/mp4">
							  <source src="" id="video_file_ogg" type="video/ogg">
							</video>
						</div>
                        <div id="" class="col-md-6"></div>
                    </div>
                    <div class="row mt-2">
                        <label class="col-md-6">Image:</label>
                       <div class="row">
                       	<div id="images"></div>
                       </div>
                    </div>
            </div>
            </div>
        </div>
    </div>
</div>


@endsection

@endsection

@section('js')
<script>

 var latlongarray = <?php echo json_encode($array); ?>;
 var detailUrl = "{{ route('map.detail') }}";
 var audio= "{{asset('audio/locationaudio/')}}";
 var video= "{{asset('video/locationvideo/')}}";
 var img= "{{asset('images/locationimage')}}";


</script>
@endsection

@section('pagejs')
<script src="{{asset('/')}}page/map2.js?{{cacheclear()}}"></script>
@endsection