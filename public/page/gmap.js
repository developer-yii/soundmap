function initMap() {
    var customMapType = new google.maps.StyledMapType([
      {
        "featureType": "poi",
        "stylers": [
          { "visibility": "off" }
        ]
      },{
        "featureType": "poi.government",
        "stylers": [
          { "visibility": "on" }
        ]
      },{
        "featureType": "poi.medical",
        "stylers": [
          { "visibility": "on" }
        ]
      },{
        "featureType": "poi.park",
        "stylers": [
          { "visibility": "on" }
        ]
      },{
        "featureType": "poi.place_of_worship",
        "stylers": [
          { "visibility": "on" }
        ]
      },{
        "featureType": "poi.sports_complex",
        "stylers": [
          { "visibility": "on" }
        ]
      }
    ], {
      name: 'Custom Style'
  });
  var customMapTypeId = 'custom_style';


  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: -25.363, lng: 131.044},
    zoom: 16,
    disableDefaultUI: true,
    zoomControl: true,
    mapTypeControl: true,    
  });
  
  map.mapTypes.set(customMapTypeId, customMapType);
  map.setMapTypeId(customMapTypeId);
  
  // the geocoder object allows us to do latlng lookup based on address
  geocoder = new google.maps.Geocoder();

  // the marker shows us the position of the latest address
  marker = new google.maps.Marker({
    map: map,
    draggable: true
  });

  // event triggered when marker is dragged and dropped
  google.maps.event.addListener(marker, 'dragend', function() {
    geocode_lookup( 'latLng', marker.getPosition() );
  });

  // event triggered when map is clicked
  google.maps.event.addListener(map, 'click', function(event) {
    marker.setPosition(event.latLng)
    geocode_lookup( 'latLng', event.latLng  );
  });  

  // Try HTML5 geolocation.
    
    if (geo_counter==0){
        if(document.getElementById('latitude').value != '' && document.getElementById('longitude').value != ''){
            var x = parseFloat(document.getElementById('latitude').value);
            var y = parseFloat(document.getElementById('longitude').value);    
        }else{
            var x = 21.876182;
            var y = 73.693591;
        }
        
        pos = {lat: parseFloat(x.toFixed(6)), lng: parseFloat(y.toFixed(6))};
    }
    else{
        if(current_lat == '' || current_lan == ''){
            current_lat = position.coords.latitude;
            current_lan = position.coords.longitude;            
        }
        position.coords.latitude = current_lat;
        position.coords.longitude = current_lan;
        pos = {
            lat: parseFloat(current_lat),
            lng: parseFloat(current_lan)
          };
    }  
      marker.setPosition(pos);
      map.setZoom(11);
      map.setCenter(pos);
      geocode_lookup( 'latLng', marker.getPosition() );
}

// move the marker to a new position, and center the map on it
function update_map( geometry ) {
  map.fitBounds( geometry.viewport );
  marker.setPosition( geometry.location );
  map.setZoom(16);
  map.setCenter(marker.getPosition());
}

// fill in the UI elements with new position data
function update_ui( address, latLng, country_short_name) {  
  $('#map_address').val(address);
  if (geo_counter != 0){    
    document.getElementById('latitude').value=latLng.lat;
    document.getElementById('longitude').value=latLng.lng;     
  }
  geo_counter=1;  
}

function get_short_country(address_components_data){
  // Get address_components
  for (var i = 0; i < address_components_data.address_components.length; i++)
  {
    var addr = address_components_data.address_components[i];
    var getCountry;
    if (addr.types[0] == 'country'){ 
      getCountry = addr.short_name;
      }
  } 
  return getCountry;
}

function geocode_lookup( type, value, update ) {
  // default value: update = false
  update = typeof update !== 'undefined' ? update : false;

  request = {};
  request[type] = value;

  geocoder.geocode(request, function(results, status) {
    $('#gmaps-error').html('');
    $('#gmaps-error').hide();
    if (status == google.maps.GeocoderStatus.OK) {
      // Google geocoding has succeeded!
      if (results[0]) {
                   
        // Only update the map (position marker and center map) if requested
        if( update ) { update_map( results[0].geometry ) }
        
        // Always update the UI elements with new location data
        LatLng_array = {'lat': marker.getPosition().lat().toFixed(6), 'lng': marker.getPosition().lng().toFixed(6)}
        update_ui( results[0].formatted_address,
                   LatLng_array,
                   get_short_country(results[0]))       
        
      } else {
        // Geocoder status ok but no results!?
        $('#gmaps-error').html("Sorry, something went wrong. Try again!");
        $('#gmaps-error').show();
      }
    } else {
      // Google Geocoding has failed. Two common reasons:
      //   * Address not recognised (e.g. search for 'zxxzcxczxcx')
      //   * Location doesn't map to address (e.g. click in middle of Atlantic)

      if( type == 'address' ) {
        // User has typed in an address which we can't geocode to a location
        $('#gmaps-error').html("Sorry! We couldn't find " + value + ". Try a different search term, or click the map." );
        $('#gmaps-error').show();
      } else {
        // User has clicked or dragged marker to somewhere that Google can't do a reverse lookup for
        // In this case we display a warning, clear the address box, but fill in LatLng
        $('#gmaps-error').html("Woah... that's pretty remote! You're going to have to manually enter a place name." );
        $('#gmaps-error').show();
        update_ui('', value)
      }
    };
  });
};