<?php
	
if (!empty($_REQUEST['by_location']))
{
        
        $search_string = esc_attr(trim($_REQUEST['s']));
        
        if (!empty($search_string))
        {              
            $url = get_bloginfo('url') . "/".  display_url($search_string) .  "-results";  
        }
        else
        {
            $url = get_bloginfo('url') . "/".  display_url("Chicago, IL") .  "-results";        
        }

        wp_redirect($url);
        exit();
}
?>