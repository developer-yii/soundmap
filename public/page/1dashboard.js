
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
    var popup;
    var lastClickedMarker = null;

    // var infoWindow = new google.maps.InfoWindow();

    $.each(latlongarray, function(index, location) {
        var marker = new google.maps.Marker({
            position: {lat: location.latitude, lng: location.longitude},
            map: map,
            icon: location.marker,
            title: location.title,
            id: location.id
        });       

        marker.addListener('click', function() {
            if (lastClickedMarker != null) {
                // Reset the previously clicked marker to its default state
                lastClickedMarker.setIcon('http://maps.google.com/mapfiles/ms/micons/blue.png');
            }

            var locationData = getData(marker.id);
            var locationData = locationData.responseJSON;

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
            popup = new Popup(
                new google.maps.LatLng(-33.866, 151.196),
                contentString
              );
            popup.setMap(map);
            
            // infoBoxe.content(contentString);            

            // Open the InfoWindow
            popup.open(map, marker);


            // Set the map to full screen mode
            // map.setOptions({
            //   fullscreenControl: true,
            //   fullscreenControlOptions: {
            //     position: google.maps.ControlPosition.TOP_RIGHT
            //   }
            // });
            
            // handleMarkerClick(marker.id);
        
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

    google.maps.event.addListener(popup, 'domready', function() {
        // Get the InfoWindow's content container element
        // var iwContainer = $('.gm-style-iw');
        // Get the content element
        // var iwContent = iwContainer.children(':first');
        // Apply the minimum width property
        // iwContent.css('max-width', '300px');
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

	// Code for map
	// map = new OpenLayers.Map("map");
    // map.addLayer(new OpenLayers.Layer.OSM());
    
    // epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection
    // projectTo = map.getProjectionObject(); //The map projection (Spherical Mercator)
   
    // var lonLat = new OpenLayers.LonLat(78.8718, 21.7679).transform(epsg4326, projectTo);
    // var zoom = 5;
    // map.setCenter (lonLat, zoom);

    // var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
    // var places = latlongarray;
    // var features = [];
    // for (var i = 0; i < places.length; i++) {
    //     var feature = new OpenLayers.Feature.Vector(
    //         new OpenLayers.Geometry.Point( places[i][0], places[i][1] ).transform(epsg4326, projectTo),
    //         {description:'','location_id':places[i][2]} ,
    //         {externalGraphic: 'http://maps.google.com/mapfiles/ms/micons/blue.png', graphicHeight: 25, graphicWidth: 21, graphicXOffset:-12, graphicYOffset:-25  }
    //     );    
    //     vectorLayer.addFeatures(feature);
    // }

    // map.addLayer(vectorLayer);

    // //Add a selector control to the vectorLayer with popup functions
    // var controls = {
    //   selector: new OpenLayers.Control.SelectFeature(vectorLayer, { onSelect: createPopup, onUnselect: destroyPopup })
    // };

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

    // map.addControl(controls['selector']);
    // controls['selector'].activate();

    // Map code ends

	$(document).on('click','.locationName', function(e){
		e.preventDefault();
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
                    $('.video-wrapper').show();
                    if(result.videoSource)
                    {                        
                    	video = $("#video").get(0);
                    	video1 = $("#videoTag")[0];                	
                    	video1.src = result.videoSource;       
                    	video.pause();
                    	video.load();                    
                    }
                    else{
                        $('.video-wrapper').hide();
                    }

                    $('.audio-wrapper').show();
                    if(result.audioSource)
                    {
                        audio = $("#audio").get(0);
                    	audio1 = $("#audioTag")[0];                	
                    	audio1.src = result.audioSource;       
                    	audio.pause();
                    	audio.load();
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
                } else {
                    showFlash(result.message, 'error');
                }
            },
            error: function(error) {
                showFlash(result.message, 'error');
            }
        });
	})

});