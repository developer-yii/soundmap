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
                <ul id="myUL">
                	@if($locations)
                		@foreach($locations as $location)
		                    <li>
		                        <a href="javascript:void(0)" data-id="{{ $location->id }}" class="locationName">
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
            <div class="video-wrapper">
               <video controls width="100%">
                <source src="{{ asset('video/video10.mp4') }}" type='video/mp4'/>
                <source src="{{ asset('video/video10.webm') }}" type='video/webm'/>
                </video>
            </div>
            <div class="audio-wrapper">
                <audio controls>
                 <source  src="{{ asset('audio/audio10.mp3') }}" type="audio/mpeg"/>
                </audio>
            </div>      
            <div class="nation-item2-list">
                <ul>
                    <li id="locationName">Shanlinxi Forest Recreation Area</li>                    
                    <li id="location">23°38′12.0″N 120°47′47.1″E</li>
                    {{-- <li>9AM</li>
                    <li>13.11.2023</li> --}}
                    {{-- <li id="description">Lewitt LCT 540S, Sound Devices MixPre 6</li> --}}
                </ul>
            </div>
            <div class="nation-item2-list2">
                <ul>
                	<li id="description">                		
	                    <p>Shanlinxi Forest Recreation Area or Sun Link Sea Forest Recreation Area (traditional Chinese: 杉林溪</p>
	                    <p>森林生態渡假園區; simplified Chinese: 杉林溪森林生态渡假园区; pinyin: Shānlínxī Sēnlín Shēngtài </p>
	                    <p>Dùjiǎ Yuánqū) is a forest in Zhushan Township, Nantou County, Taiwan. The forest is located at an </p>
	                    <p>elevation of 1,600-1,800 meters above sea level with an area of 40 hectares. It consists of herb and </p>
                	</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-5 col-lg-12">
        <div class="nation-item3">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116706.88427665795!2d120.54551864597262!3d23.921862185823485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3469319125cb8dad%3A0x7c22297becb353da!2sNantou%20City%2C%20Nantou%20County%2C%20Taiwan%20540!5e0!3m2!1sen!2sbd!4v1674732708764!5m2!1sen!2sbd"  style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // var apiUrl = "{{ route('location.list') }}";
    // var location_editurl ="{{route('location.edit')}}";
    // var deleteUrl = "{{ route('location.delete') }}";
    var getDetailUrl = "{{ route('dashboard.location.detail') }}";
</script>
@endsection

@section('pagejs')
	<script src="{{asset('/')}}page/dashboard.js?{{cacheclear()}}"></script>
@endsection