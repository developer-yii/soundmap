@extends('layouts.web')

@section('content')
<div class="row">
    <div class="col-lg-6 col-xl-2">
        <div class="nation-item1">
            <div class="search-wrapper">
                <div class="round-btn" id="show-search-box">
                    <i class="fa fa-search flip-icon"></i>
                </div>
                <div class="hidden-search-box" id="hidden-search-box" >
                    <form action="">
                        <div class="input-group">
                            <input placeholder="Search" name=""  type="text" id="myInput" onkeyup="myFunction()">
                            <button type="submit" class="search-btn">
                            <i class="fa fa-search flip-icon"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>  
            <div class="nation-item1-list mt-5">
            	<?php
            		$vidFile = '';
            		$audFile = '';
            		$locName = '';
            		$lat = '';
            		$long = '';
            		$desc = '';
            	?>
                <ul id="myUL">
                	@if($locations)
                		@foreach($locations as $key => $location)
                			<?php
                				$loc = $locations[0];    
                				$vidFile = $loc->video_file;
			            		$audFile = $loc->audio_file;
			            		$locName = $loc->location_name;
			            		$lat = $loc->latitude;
			            		$long = $loc->longitude; 
			            		$desc = $loc->description;      				
                			?>
		                    <li>
		                        <a href="javascript:void(0)" data-id="{{ $location->id }}" class="locationName {{($key == 0 )?"selected":""}}">
		                        	<p>{{ $location->location_name }}</p>
		                        </a>
		                    </li>                			
                		@endforeach
                	@endif                    
                </ul>
            </div>              
        </div>
    </div>
    <div class="col-lg-6 col-xl-5">
        <div class="nation-item2">
            @if($vidFile)
            <div class="video-wrapper">
               <video controls width="100%" id="video">
                <source id="videoTag" src="{{ asset('video/locationvideo/'.$vidFile) }}" type='video/mp4'/>
                {{-- <source  src="{{ asset('video/video10.webm') }}" type='video/webm'/> --}}
                </video>
            </div>
            @endif
            @if($audFile)
            <div class="audio-wrapper">
                <audio controls id="audio">
                 <source id="audioTag" src="{{ asset('audio/locationaudio/'.$audFile) }}" type="audio/mpeg"/>
                </audio>
            </div>     
            @endif 
            <div class="nation-item2-list">
                <ul>
                    <li id="locationName">{{$locName}}</li>                    
                    <li id="location">{{$lat}} {{$long}}</li>
                    {{-- <li>9AM</li>
                    <li>13.11.2023</li> --}}
                    {{-- <li id="description">Lewitt LCT 540S, Sound Devices MixPre 6</li> --}}
                </ul>
            </div>
            <div class="nation-item2-list2">
                <ul>
                	<li id="locDescription">                		
	                    {!! $desc !!}
                	</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-5 col-lg-12">
        <div class="nation-item3">
        	<div id="map" style="width: auto; height: 100vh;"></div>
            {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116706.88427665795!2d120.54551864597262!3d23.921862185823485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3469319125cb8dad%3A0x7c22297becb353da!2sNantou%20City%2C%20Nantou%20County%2C%20Taiwan%20540!5e0!3m2!1sen!2sbd!4v1674732708764!5m2!1sen!2sbd"  style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
        </div>
    </div>
</div>
@endsection

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
                       	<div id="images" class="popup-gallery"></div>
                       </div>
                    </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var latlongarray = <?php echo json_encode($locData); ?>;
 	var detailUrl = "{{ route('map.detail') }}";
	var audio= "{{asset('audio/locationaudio/')}}";
	var video= "{{asset('video/locationvideo/')}}";
	var img= "{{asset('images/locationimage')}}";
    var getDetailUrl = "{{ route('dashboard.location.detail') }}";
</script>
@endsection

@section('pagejs')
	<script src="{{asset('/')}}page/dashboard.js?{{cacheclear()}}"></script>
@endsection