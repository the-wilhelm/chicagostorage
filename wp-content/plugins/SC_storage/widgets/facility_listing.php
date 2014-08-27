<?php
class facility_listing extends WP_Widget{
    
    //process the new widget
    function facility_listing() {
        $widget_ops = array( 
			'classname' => 'facility_listing', 
			'description' => 'Provide a listing of facilities for a city' 
			); 
        $this->WP_Widget( 'facility_listing', 'Facility Listing', $widget_ops );
    }
    
    //build the widget settings form
    function form($instance) {
        $defaults = array('title'=>'' ); 
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title = $instance['title'];
  ?>
           
   <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>

<?php
      
    }
    
     //save the widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        
        return $instance;
        
    }
    
     //display the widget
    function widget($args, $instance) {

        extract($args);
        
        echo $before_widget;
        
          $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
          if (!empty($title))
           echo $before_title . $title . $after_title;
        
        $lat = 36.165890;
        $long = -86.784440;
        $zoom = 10;
        $count = 0;
        $markerString = "";
        
        $facilities = SC_Facilities::getFacilities();
        
         foreach ($facilities as $facility)
        {
            foreach ($facility as $key=>$site){
                echo "<br />" . $site["SiteName"] . "<br />";
                echo $site["SiteAddress"] . "<br />";
                echo $site["SiteCity"]. " , " . $site["SiteState"] . " " . $site["SiteZip"] . "<br />";
                echo "Distance: " . $site["Distance"] . "<br />";
                 echo "<br />";
                $markerString .= "{latitude: " . $site["SiteLat"] . ", longitude: " . $site["SiteLong"] . ","
                      . "html: '" . "<table><tr><td>" . $site["SiteName"] . "</td></tr></table>'},";
                        
            }
        $markerString = substr($markerString, 0, -1);  // remove last ,
        echo "<br />";
     
      }
      
        echo $after_widget;
       
    }
      
}

