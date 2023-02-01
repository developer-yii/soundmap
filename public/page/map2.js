$(document).ready(function() {

    map = new OpenLayers.Map("map");
    map.addLayer(new OpenLayers.Layer.OSM());
    
    epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection
    projectTo = map.getProjectionObject(); //The map projection (Spherical Mercator)
   
    var lonLat = new OpenLayers.LonLat(78.8718, 21.7679).transform(epsg4326, projectTo);
    var zoom=5;
    map.setCenter (lonLat, zoom);

    var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
    var places = latlongarray;
    var features = [];
    for (var i = 0; i < places.length; i++) {
        var feature = new OpenLayers.Feature.Vector(
            new OpenLayers.Geometry.Point( places[i][0], places[i][1] ).transform(epsg4326, projectTo),
            {description:'','location_id':places[i][2]} ,
            {externalGraphic: 'http://maps.google.com/mapfiles/ms/micons/blue.png', graphicHeight: 25, graphicWidth: 21, graphicXOffset:-12, graphicYOffset:-25  }
        );    
        vectorLayer.addFeatures(feature);
    }

    map.addLayer(vectorLayer);

    //Add a selector control to the vectorLayer with popup functions
    var controls = {
      selector: new OpenLayers.Control.SelectFeature(vectorLayer, { onSelect: createPopup, onUnselect: destroyPopup })
    };

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
                $('.audio_song').html('<audio style="width: 100%;" controls><source src="'+audio+'/'+result.data.audio_file+'" type="audio/ogg"></source></audio>');
                $('.video_song').html('<video style="width: 100%;" controls><source src="'+video+'/'+result.data.video_file+'" type="video/ogg"></source></video>');
                $('#images').html('');
                $.each(result.locationsimg, function(key,value) {
                  $('#images').append('<img src="'+img+'/'+value.image_path+'" style="margin-bottom: 10px;width:80px;height:80px;border: 1px solid;">');  
                });

            }
        });    

      // feature.popup = new OpenLayers.Popup.FramedCloud("pop",
      //     feature.geometry.getBounds().getCenterLonLat(),
      //     null,
      //     '<div class="markerContent">'+feature.attributes.description+'</div>',
      //     null,
      //     true,
      //     function() { controls['selector'].unselectAll(); }
      // );
      // // feature.popup.closeOnMove = true;
      // // map.addPopup(feature.popup);
      // feature.popup.destroy();
      // feature.popup = null;
    }

    function destroyPopup(feature) {
      // feature.popup.destroy();
      // feature.popup = null;
      // $('#OpenLayers.Map_2_OpenLayers_ViewPort').click();
    }
    
    map.addControl(controls['selector']);
    controls['selector'].activate();
      
});