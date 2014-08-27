<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
add_shortcode( 'google_mapJQ', 'gmap_generate_map_JQ' );

function gmap_generate_map_JQ($attr) {

    // Set map default
    $defaults = array(
        'width'  => '500',
        'height' => '500',
        'zoom'   => 12,
        'markerstring' => ''
    );
    
    // get default lat long from setting page
    $sc_storage_options_arr = get_option('sc_storage_options');
    extract($sc_storage_options_arr);
    
    $lat = $option_latitude;
    $long = $option_longitude;
    
//    $lat = 36.165890;
//    $long = -86.784440;
    
    // Get map attributes (set to defaults if omitted)
    extract( shortcode_atts( $defaults, $attr ) );
    
    $width = esc_attr($width);
    $height = esc_attr($height);
    
     // Output for the shortcode
    $output = '';
    
    $output .= '<script type="text/javascript"
        src="http://maps.google.com/maps/api/js?sensor=false"></script>';
     $output .= '<script type="text/javascript"
        src="http://local.b2i_storage.com/wp-content/plugins/b2i_storage/assets/js/jquery.gmap.min.js"></script>';
    
     // Add the map specific code
    $output .= <<<CODE
     
    
    </style>
    <script type="text/javascript">
        jQuery('#map_canvas').width($width).height($height);
        jQuery('#map_canvas').gMap(
            {
                 latitude: $lat,
                 longitude: $long,
                 maptype: 'ROADMAP',
                 markers: [
                            $markerstring
                        ],
                 icon: {
                        image: "http://www.google.com/mapfiles/marker.png",
                        shadow: "http://www.google.com/mapfiles/shadow50.png",
                        iconsize: [20, 34],
                        shadowsize: [37, 34],
                        iconanchor: [9, 34],
                        shadowanchor: [19, 34]
                },
                 zoom: $zoom,
                 controls: {
                     panControl: true,
                     zoomControl: false,
                     mapTypeControl: true,
                     scaleControl: true,
                     streetViewControl: false,
                     overviewMapControl: false
                 }
      
            });
                
    </script>
    
   
    
CODE;

    return $output;
    
}



