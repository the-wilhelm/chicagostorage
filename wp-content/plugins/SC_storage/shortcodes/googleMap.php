<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
add_shortcode( 'google_map', 'gmap_generate_map' );

function gmap_generate_map( $attr) {

    // Set map default
    $defaults = array(
        'width'  => '500',
        'height' => '500',
        'zoom'   => 12,
    );
    
    $lat = 36.165890;
    $long = -86.784440;
    $zoom = 10;
    $address = "234 Oak Avenue, Omaha, NE 68128";
    
    // Get map attributes (set to defaults if omitted)
    extract( shortcode_atts( $defaults, $attr ) );
    
     // Output for the shortcode
    $output = '';
    
    $output .= '<script type="text/javascript"
        src="http://maps.google.com/maps/api/js?sensor=false"></script>';
    
     // Add the map specific code
    $output .= <<<CODE
    <div id="map_canvas"></div>
    
    <script type="text/javascript">
    function generate_map() {
        var latlng = new google.maps.LatLng( $lat, $long );
        var options = {
            zoom: $zoom,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

        var map = new google.maps.Map(
            document.getElementById("map_canvas"),
            options
        );

        var legend = '<div class="map_legend"><p> $address </p></div>';

        var infowindow = new google.maps.InfoWindow({
            content: legend,
        });

        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
        });
        
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });

    }

    generate_map();
    
    </script>
    
    <style type"text/css">
    .map_legend{
        width:200px;
        max-height:200px;
        min-height:100px;
    }
    #map_canvas {
        width: {$width}px;
        height: {$height}px;
    }
    </style>
    
CODE;

    return $output;
    
}

