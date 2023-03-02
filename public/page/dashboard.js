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

    initMap();

    var markers = [];
    var lastClickedMarker = null;

    var infoWindow = new google.maps.InfoWindow();

    $.each(latlongarray, function(index, location) {
        var marker = new google.maps.Marker({
            position: {lat: location.latitude, lng: location.longitude},
            map: map,
            icon: location.marker,
            title: location.title,
            id: location.id
        });       

        // check if the map is in full screen mode
        function isMapFullScreen() {
          return (window.innerHeight == screen.height);
        }

        marker.addListener('click', function() {
            if (lastClickedMarker != null) {
                // Reset the previously clicked marker to its default state
                lastClickedMarker.setIcon('http://maps.google.com/mapfiles/ms/micons/blue.png');
            }
            
            var locationData = getData(marker.id);
            var locationData = locationData.responseJSON;
            // var isMapFullScreen = isMapFullScreen();
            if(!isMapFullScreen())
            {
                $('.nation-item1-list #myUL').find('li a[data-id="'+marker.id+'"]').trigger('click');
            }

            // Open the InfoWindow
            if (isMapFullScreen()) {
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
                    '<video style="width: 100%;" controls><source src="'+locationData.videoSource+'" type="video/ogg"></source></video></div>';
                }

                var audiofile = '';
                
                if(locationData.audioSource)
                {
                    audiofile += '<div class="audio_song mb-2">'+
                    '<audio style="width: 100%;" controls><source src="'+locationData.audioSource+'" type="audio/ogg"></source></audio></div>';
                }            

                var contentString = '<div class="info-window">' +
                    '<div class="info-window-images mb-2">' +                 
                        htm +                
                    '</div>' +
                        videofile + audiofile +
                    '<h6>' + locationData.data.location_name + '</h6>' +                
                    '<p>' + locationData.data.latitude + ' ' + locationData.data.longitude + '</p>' +                
                    '<div class="info-window-content">' +                
                        locationData.data.description +
                    '</div>' +
                    
                    '</div>';
                
                 // Set the InfoWindow content
                infoWindow.setContent(contentString);
            
                infoWindow.open(map, marker);
            }


            // Zoom and center the map on the marker's position            
            map.panTo(marker.getPosition(),{animate: true});
            map.setZoom(15, {animate: true});

            // Change the marker's color
            marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');                

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
    });



    // Create a MarkerClusterer object and pass the array of markers to it
    var markerCluster = new MarkerClusterer(map, markers, {
        imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
    });

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

    // Define a function that will play the next media element in the array
    function playNextMedia(currentMediaIndex) {    
        var curruntLi = $("#myUL li a[data-id='"+currentMediaIndex+"']").parent();
        let nexiLi = curruntLi.next('li');
        nexiLi.find('a').click();
        return false;
    }


    $(document).on('click','.locationName', function(e){
		e.preventDefault();
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
                        $('.video-wrapper').html('<video controls width="100%" id="video">'+
                            '<source id="videoTag" src="'+result.videoSource+'" type="video/mp4"/>'+
                            '</video>');
                        
                        video = $("#video").get(0);
                    	// video1 = $("#videoTag")[0];                	
                    	// video1.src = result.videoSource;       
                    	video.pause();
                    	video.load();
                        video.play();

                        const mediaElement = $(`.nation-item-container`).find('audio, video');
                        
                        mediaElement.on('ended', function(){
                            console.log('ended');
                            console.log(placeId);
                            playNextMedia(placeId);
                        });
                    }
                    else{
                        $('.video-wrapper').hide();
                    }

                    $('.audio-wrapper').show();
                    if(result.audioSource)
                    {
                        $('.audio-wrapper').html('<audio controls width="100%" id="audio">'+
                            '<source id="audioTag" src="'+result.audioSource+'" type="audio/mpeg"/>'+
                            '</audio>');

                        audio = $("#audio").get(0);
                    	// audio1 = $("#audioTag")[0];                	
                    	// audio1.src = result.audioSource;       
                    	audio.pause();
                    	audio.load();
                        audio.play();
                        var mediaElement = $(`.nation-item-container`).find('audio, video');

                        mediaElement.on('ended', function(){
                            playNextMedia(placeId);
                        });
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
                        $('.nation-item2-desc').css('height', 'calc(100vh - '+($('.nation-item2').height()+10)+'px)');
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
    

    $('.nation-item2-desc').css('height', 'calc(100vh - '+($('.nation-item2').height()+10)+'px)');
    $('.nation-item2-desc').css('display', 'block');

    var mediaElement = $(`.nation-item-container`).find('audio, video');

    mediaElement.on('ended', function(){
        console.log('ended');
        console.log($('#myUL').find('li:first').find('a').attr('data-id'));
        playNextMedia($('#myUL').find('li:first').find('a').attr('data-id'));
    });

});