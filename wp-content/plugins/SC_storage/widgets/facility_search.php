<?php
//boj_widget_my_info class
class facility_search extends WP_Widget {

    //process the new widget
    function facility_search() {
        $widget_ops = array( 
			'classname' => 'facility_search', 
			'description' => 'Search for a facility.' 
			); 
        $this->WP_Widget( 'facility_search', 'Facility Search', $widget_ops );
        
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
    function widget($args, $instance) 
    {
     $status = "";
     
        if(isset($_GET["status"]))
        {
            
            if($_GET["status"] == 1)
            {
              echo "Address Not Found"; 
            }
        }

        extract($args);
        
        echo $before_widget;
          $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
          if (!empty($title))
           echo $before_title . $title . $after_title;;
        
        // $url = plugins_url("process_search.php", __FILE__);
        
//        if(isset($wp_session['search_status']) && !empty($wp_session['search_status'])) {
//            $errors = $wp_session['search_status']; 
//        }
          
           
        $url = plugins_url("process_search.php", __FILE__);
        
    ?>
        <div style="border: #000 solid 1px; background-color: #FFF;" >
  
<!--				<form method="post" class="search-form" action="<?php echo $url; ?>">-->
                <form id="search_widget" method="post" class="search-form" action="<?php echo $url; ?>">
                 
				<div>
					<input class="" type="text" id="txtSearch" name="txtSearch" value="Enter City, State or Zip"  />
					<input  name="btnSubmit" id="btnSubmit" type="submit"  Value="Search"/>
                    <input  name="hdnURL" id="hdnURL" type="hidden"  Value="<?php echo $_SERVER["REQUEST_URI"]; ?>"/>
				</div>
				</form><!-- .search-form -->

			</div><!-- .search -->
<?php
        echo $after_widget;
       
}       
    }

