let map;

if(vidFile)
{
    $('.video-wrapper').show();
    $('#carouselExampleControls').hide();
    $('.audio-wrapper').hide();
}
else if(locImgCount){
    $('.video-wrapper').hide();
    $('#carouselExampleControls').show();
    $('.audio-wrapper').show();   
}

function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

clicked_from = '';

// google.maps.event.addDomListener(window, 'load', init);

// function init() {
//     // Basic options for a simple Google Map
//     // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
    

    
// }

$(document).ready(function(){

    // Initialize the Google Map      
    function getData(markerId)
    {
        return $.ajax({
            url: detailUrl,
            type: 'GET',
            data: {id:markerId},
            dataType: 'json',  
            async: false          
        });        
    }

    // Initialize map Starts
    var mapOptions = {
        styles: [{"featureType":"all","elementType":"geometry.fill","stylers":[{"lightness":"0"}]},{"featureType":"administrative","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"administrative.locality","elementType":"labels.text","stylers":[{"lightness":"25"}]},{"featureType":"administrative.neighborhood","elementType":"all","stylers":[{"visibility":"simplified"},{"lightness":"25"}]},{"featureType":"landscape","elementType":"all","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"simplified"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"lightness":"-5"}]},{"featureType":"poi","elementType":"all","stylers":[{"saturation":-100},{"lightness":"50"},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"visibility":"simplified"},{"color":"#dcedc8"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"lightness":"-5"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"simplified"},{"lightness":"25"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"visibility":"simplified"},{"lightness":"-5"}]},{"featureType":"road.highway.controlled_access","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"lightness":"30"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"visibility":"simplified"},{"weight":"2"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels.text.stroke","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"all","stylers":[{"lightness":"40"}]},{"featureType":"transit","elementType":"all","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"transit.line","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit.station","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"transit.station","elementType":"labels","stylers":[{"visibility":"simplified"},{"lightness":"50"}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit.station.bus","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit.station.rail","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#c3cfee"},{"visibility":"on"}]},{"featureType":"water","elementType":"labels.text","stylers":[{"lightness":"100"}]}]
    };

    // Get the HTML DOM element that will contain your map 
    // We are using a div with id="map" seen below in the <body>
    var mapElement = document.getElementById('map');

    // Create the Google Map using our element and options defined above
    var map = new google.maps.Map(mapElement, mapOptions);
    // Initialize map ends

    var markers = [];
    var lastClickedMarker = null;

    var infoWindow = new google.maps.InfoWindow();

    $.each(latlongarray, function(index, location) {
        console.log('marker='+markerImg+'/marker.png');

        var marker = new google.maps.Marker({
            position: {lat: location.latitude, lng: location.longitude},
            map: map,
            icon: markerImg+'/marker.png',
            title: location.title,
            id: location.id
        });

        marker.addListener('click', function() {
            // console.log('marker clicked');

            if (lastClickedMarker != null) {
                // Reset the previously clicked marker to its default state
                // lastClickedMarker.setIcon('http://maps.google.com/mapfiles/ms/micons/blue.png');
                lastClickedMarker.setIcon(markerImg+'/marker.png');
                
            }
            
            var locationData = getData(marker.id);
            var locationData = locationData.responseJSON;
            if(!is_full_map)
            {
                if(clicked_from == '')
                {
                    clicked_from = 'map';
                    $('.nation-item1-list #myUL').find('li a[data-id="'+marker.id+'"]').trigger('click');
                }
            }
            clicked_from = '';

            // console.log('map is not full screen');
            // Open the InfoWindow
            if (is_full_map) {
                console.log('map is full screen');
                var htm = '';
                if(locationData.locationsimg.length)
                {                
                    htm += '<div id="carouselExampleControls1" class="carousel slide" data-bs-ride="carousel">';
                    htm += '<div class="carousel-inner" id="imgDiv">';
                        
                        $.each(locationData.locationsimg, function(key,value) {
                            if(key == 0)
                                htm += '<div class="carousel-item active">';
                            else
                                htm += '<div class="carousel-item">';

                            htm += '<img src="'+img+'/'+value.image_path+'" class="d-block w-100"></div>';
                        });                   
                              
                    htm += '</div>';
                  htm += '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls1" data-bs-slide="prev">';
                    htm += '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                    htm += '<span class="visually-hidden">Previous</span>';
                  htm += '</button>';
                  htm += '<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls1" data-bs-slide="next">'+
                    '<span class="carousel-control-next-icon" aria-hidden="true"></span>'+
                    '<span class="visually-hidden">Next</span>'+
                  '</button>'+
                '</div>';
                }

                var videofile = '';
                if(locationData.videoSource)
                {
                    videofile += '<div class="video_song mb-2">'+
                    '<video style="width: 100%;" controls controlsList="nodownload noplaybackrate" disablePictureInPicture="true" id="video"><source src="'+locationData.videoSource+'" type="video/ogg"></source></video></div>';
                }

                var audiofile = '';
                
                if(locationData.audioSource)
                {
                    // audiofile += '<div class="audio_song mb-2">'+
                    // '<audio style="width: 100%;" controls><source src="'+locationData.audioSource+'" type="audio/ogg"></source></audio></div>';
                    var shuffle = getCookie('soundmap-shuffle');
                    var shuffle_class = '';
                    if(shuffle == '1')
                        shuffle_class = 'active';

                    audiofile += '<div class="audio-wrapper Row1">'+
                                        '<div class="Column1 buttons">'+
                                            '<i class="fa-solid fa-shuffle '+shuffle_class+'"></i>'+
                                            '<i class="fa-sharp fa-solid fa-backward-step"></i>'+
                                            '<i class="fa-sharp fa-solid fa-forward-step"></i>'+
                                        '</div>'+
                                        '<div class="Column1 audio-container" style="">'+
                                            '<audio controls controlsList="nodownload noplaybackrate" id="audio">'+
                                                '<source id="audioTag" src="'+locationData.audioSource+'" type="audio/mpeg"/>'+
                                            '</audio>'+
                                        '</div>'+
                                    '</div>';
                }

                var contentString = '<div class="info-window">' +
                    '<div class="info-window-images mb-2">' +
                        htm +
                    '</div>' +
                        videofile + audiofile +
                    '<h6>' + locationData.data.location_name + '</h6>' +
                    // '<p>' + locationData.data.latitude + ' ' + locationData.data.longitude + '</p>' +
                    // '<div class="info-window-content">' +
                    //     locationData.data.description +
                    // '</div>' +
                    '</div>';
                
                 // Set the InfoWindow content
                infoWindow.setContent(contentString);
            
                infoWindow.open(map, marker);
                previous_Window=infoWindow;
            }


            // Zoom and center the map on the marker's position            
            map.panTo(marker.getPosition(),{animate: true});
            map.setZoom(15, {animate: true});

            // Change the marker's color
            marker.setIcon(markerImg+'/selected-marker.png');
            
            // Set the clicked property to true
            lastClickedMarker = marker;

            // Set the clicked property to true
            marker.clicked = true;                        
        });
        
        markers.push(marker);                
    });
    
    google.maps.event.addListener(infoWindow, 'domready', function() {
        // Get the InfoWindow's content container element
        var iwContainer = $('.gm-style-iw');
        // Get the content element
        var iwContent = iwContainer.children(':first');
        // Apply the minimum width property
        iwContent.css('max-width', '300px');

        setTimeout(function(){
            if($(".info-window #audio").length > 0)
            {
                audio = $(".info-window #audio").get(0);
                audio.pause();
                audio.load();
                audio.play();
                var mediaElement = $(`.info-window`).find('audio');

                mediaElement.on('ended', function(){
                    console.log($('.locationName.selected').attr('data-id'));
                    playNextMedia($('.locationName.selected').attr('data-id'));
                });
            }

            if($(".info-window video").length > 0)
            {
                video = $(".info-window video").get(0);
                video.pause();
                video.load();
                video.play();
                var mediaElement = $(`.info-window`).find('video');
                
                mediaElement.on('ended', function(){
                    console.log($('.locationName.selected').attr('data-id'));
                    playNextMedia($('.locationName.selected').attr('data-id'));
                });
            }
        },500);
    });



    // Create a MarkerClusterer object and pass the array of markers to it
    var markerCluster = new MarkerClusterer(map, markers, {
        imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
    });


    setTimeout(function(){
        clicked_from = 'map';
        google.maps.event.trigger(markers[0], 'click');
        clicked_from = '';
        $('#map').css('opacity', 1);
    },1000);


    // Handle the marker click event
    function handleMarkerClick(markerId) {                
        $.ajax({
            url: detailUrl,
            type: 'GET',
            data: {id:markerId},
            dataType: 'json',
            success: function(result) {
                // controls['selector'].unselectAll();
                $('#location-modal').modal('show');
                $('#location_name').html(result.data.location_name);  
                $('#latitude').html(result.data.latitude);  
                $('#longitude').html(result.data.longitude);  
                $('#description').html(result.data.description);
                $('.audio_song').show();
                $('.video_song').show();

                if(result.audioSource)
                {
                   $('.audio_song').html('<audio style="width: 100%;" controls><source src="'+result.audioSource+'" type="audio/ogg"></source></audio>');
                }
                else{
                    $('.audio_song').hide();
                }
                if(result.videoSource){
                   $('.video_song').html('<video style="width: 100%;" controls><source src="'+result.videoSource+'" type="video/ogg"></source></video>');
                }
                else{
                    $('.video_song').hide('');
                }
                $('#images').html('');            

                $.each(result.locationsimg, function(key,value) {
                  $('#images').append('<a href="'+img+'/'+value.image_path+'" class="image-popup"><img src="'+img+'/'+value.image_path+'" class="modal-image" /></a>');  
                });       

                initMagnific();                        

            }
        });
    }

	function createPopup(feature) {
		var id =feature.attributes.location_id;
	    $.ajax({
	        url: detailUrl,
	        type: 'GET',
	        data: {id:id},
	        dataType: 'json',
	        success: function(result) {
	            controls['selector'].unselectAll();
	            $('#location-modal').modal('show');
	            $('#location_name').html(result.data.location_name);  
	            $('#latitude').html(result.data.latitude);  
	            $('#longitude').html(result.data.longitude);  
	            $('#description').html(result.data.description);
                $('.audio_song').show();
                $('.video_song').show();

                if(result.audioSource)
                {
	               $('.audio_song').html('<audio style="width: 100%;" controls><source src="'+result.audioSource+'" type="audio/ogg"></source></audio>');
                }
                else{
                    $('.audio_song').hide();
                }
                if(result.videoSource){
	               $('.video_song').html('<video style="width: 100%;" controls><source src="'+result.videoSource+'" type="video/ogg"></source></video>');
                }
                else{
                    $('.video_song').hide('');
                }
                $('#images').html('');            

	            $.each(result.locationsimg, function(key,value) {
	              $('#images').append('<a href="'+img+'/'+value.image_path+'" class="image-popup"><img src="'+img+'/'+value.image_path+'" class="modal-image" /></a>');  
	            });       

                initMagnific();                        

	        }
	    });          
	}

    function initMagnific(argument) {
        $('.popup-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                // titleSrc: function(item) {
                //     return item.el.attr('title') + '<small></small>';
                // }
            }
        });
    }

	function destroyPopup(feature) {
		
	}

    function get_random_element(currentMediaIndex) {
        var n_elements = $("#myUL li").length;
        var random = Math.floor(Math.random()*n_elements);
        if($("#myUL li").eq(random).find('a').attr('data-id') == currentMediaIndex)
            return get_random_element(currentMediaIndex);
        return random;
    }

    // Define a function that will play the next media element in the array
    function playNextMedia(currentMediaIndex) {    
        // console.log('playNextMedia');
        if(getCookie('soundmap-shuffle') == 1)
        {
            random = get_random_element(currentMediaIndex);
            // console.log(random);
            $("#myUL li").eq(random).find('a').click();
            return false;
        }
        else
        {
            var curruntLi = $("#myUL li a[data-id='"+currentMediaIndex+"']").parent();
            let nexiLi = curruntLi.next('li');
            if(nexiLi.length > 0)
                nexiLi.find('a').click();
            else
                $('#myUL').find('li:first').find('a').click();
            return false;
        }
    }

    $(document).on('click','.fa-forward-step', function(e){
        if($('.locationName.selected').length > 0)
        {
            var curruntLi = $("#myUL li a[data-id='"+$('.locationName.selected').attr('data-id')+"']").parent();
            let nexiLi = curruntLi.next('li');
            if(nexiLi.length > 0)
                nexiLi.find('a').click();
            else
                $('#myUL').find('li:first').find('a').click();
            return false;
        }
    });

    $(document).on('click','.fa-backward-step', function(e){
        if($('.locationName.selected').length > 0)
        {
            var curruntLi = $("#myUL li a[data-id='"+$('.locationName.selected').attr('data-id')+"']").parent();
            let prevLi = curruntLi.prev('li');
            if(prevLi.length > 0)
                prevLi.find('a').click();
            else
                $('#myUL').find('li:last').find('a').click();
            return false;
        }
    });


    $(document).on('click','.locationName', function(e){
		e.preventDefault();
        console.log('left sidebar link clicked');

        if(clicked_from == '')
        {
            clicked_from = 'link';
            key = $(this).attr('data-key');
            google.maps.event.trigger(markers[key], 'click');
        }
        clicked_from = '';

        $('.nation-item2-desc').css('display', 'none');
		var placeId = $(this).attr('data-id');		
		$this = $(this);

		$('#myUL a').each(function() {
			$(this).removeClass('selected');    
		});
		$this.addClass('selected');

		$.ajax({
            url: getDetailUrl + '?id=' + placeId,
            type: 'GET',
            dataType: 'json',
            success: function(result) {
                if (result.status == true) {         
                    $('.video-wrapper').find('video').remove();
                    $('.audio-wrapper').find('audio').remove();

                    $('.video-wrapper').show();
                    if(result.videoSource)
                    {
                        $('.video-wrapper').html('<video controls controlsList="nodownload noplaybackrate" disablePictureInPicture="true" width="100%" id="video">'+
                            '<source id="videoTag" src="'+result.videoSource+'" type="video/mp4"/>'+
                            '</video>');
                        
                        if(!is_full_map)
                        {
                            video = $(".nation-item-container #video").get(0);
                        	video.pause();
                        	video.load();
                            video.play();

                            const mediaElement = $(`.nation-item-container`).find('audio, video');
                            
                            mediaElement.on('ended', function(){
                                playNextMedia(placeId);
                            });
                        }
                    }
                    else{
                        $('.video-wrapper').hide();
                    }

                    $('.audio-wrapper').show();
                    if(result.audioSource)
                    {
                        $('.audio-container').html('<audio controls controlsList="nodownload noplaybackrate" id="audio">'+
                            '<source id="audioTag" src="'+result.audioSource+'" type="audio/mpeg"/>'+
                            '</audio>');

                        if(!is_full_map)
                        {
                            audio = $(".nation-item-container #audio").get(0);
                            audio.pause();
                            audio.load();
                            audio.play();
                            var mediaElement = $(`.nation-item-container`).find('audio, video');

                            mediaElement.on('ended', function(){
                                playNextMedia(placeId);
                            });
                        }
                    }
                    else{
                        $('.audio-wrapper').hide();
                    }

                    $('#carouselExampleControls').hide();
                    if(result.locationsimg.length)
                    {                        
                        $('#carouselExampleControls').show();
                        var imgHtm = '';
                        
                        $.each(result.locationsimg, function(key,value) {
                            if(key == 0)
                            {
                                imgHtm += '<div class="carousel-item active">';
                                imgHtm += '<img src="'+img+'/'+value.image_path+'" class="d-block w-100" alt="...">';
                                imgHtm += '</div>';
                            }
                            else
                            {
                                imgHtm += '<div class="carousel-item">';
                                imgHtm += '<img src="'+img+'/'+value.image_path+'" class="d-block w-100" alt="...">';
                                imgHtm += '</div>';
                            }                           

                            $('#imgDiv').html(imgHtm);
                        });
                    }


                    $('#locationName').html(result.location.location_name);
                    $('#locDescription').html(result.location.description);
                    $('#location').html(result.location.latitude+' '+result.location.longitude);

                    setTimeout(function(){
                        $('.nation-item2-desc').css('height', 'calc(100vh - '+($('.nation-item2').height()+110)+'px)');
                        $('.nation-item2-desc').css('display', 'block');
                    },100);
                } else {
                    showFlash(result.message, 'error');
                }
            },
            error: function(error) {
                showFlash(result.message, 'error');
            }
        });
	})
    

    $('.nation-item2-desc').css('height', 'calc(100vh - '+($('.nation-item2').height()+110)+'px)');
    $('.nation-item2-desc').css('display', 'block');

    var mediaElement = $(`.nation-item-container`).find('audio, video');

    mediaElement.on('ended', function(){
        // console.log('ended');
        // console.log($('#myUL').find('li:first').find('a').attr('data-id'));
        playNextMedia($('#myUL').find('li:first').find('a').attr('data-id'));
    });

    $(document).on('click', '.fa-shuffle', function(){
        if($(this).hasClass('active')){
            $('.fa-shuffle').removeClass('active');
            setCookie('soundmap-shuffle', 0, 365);
        }
        else {
            $('.fa-shuffle').addClass('active');
            setCookie('soundmap-shuffle', 1, 365);
        }
    });
    var shuffle = getCookie('soundmap-shuffle');
    if(shuffle == '1')
        $('.fa-shuffle').addClass('active');

    // google.maps.event.addListener(map, 'bounds_changed', function() {
    //     console.log('bounds_changed');
    //     setTimeout(function(){
    //         map_area_change_event();
    //     },1000)
    // });

    // // events on full screen and minimize
    // $(document).on('click', '.gm-fullscreen-control', function(){
    //     console.log('gm-fullscreen-control clicked');
    //     map_area_change_event();
    // });

    is_full_map = false;
    window.matchMedia('(display-mode: fullscreen)').addEventListener('change', ({ matches }) => {
        if (matches) {
            is_full_map = true;
        } else {
            is_full_map = false;
        }
        map_area_change_event();
    });
});

function map_area_change_event() {
    console.log('is_full_map : '+is_full_map);
    if(is_full_map) {
        // console.log('full screen');
        if($(".nation-item-container #audio").length > 0)
        {
            audio = $(".nation-item-container #audio").get(0);
            audio.pause();
        }
        else
        if($(".nation-item-container #video").length > 0)
        {
            video = $(".nation-item-container #video").get(0);
            video.pause();
        }
    }
    else {
        // console.log('minimize');
        if($(".info-window").length > 0)
        {
            // console.log('small screen');
            if($(".info-window audio").length > 0)
            {
                audio = $(".info-window audio").get(0);
                audio.pause();
                $('.info-window').remove();
            }
            else
            if($(".info-window video").length > 0)
            {
                video = $(".info-window video").get(0);
                video.pause();
                $('.info-window').remove();
            }
            previous_Window.close();
        }
    }
}
function setCookie(cname,cvalue,exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}