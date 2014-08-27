<?php
/**
* Template Name: SearchResults
 */
?>



<?php 
    
    if (!empty(get_query_var('scsize1')) && !empty(get_query_var('scsize2')))
    {
        $size = get_query_var('scsize1') . "x" . get_query_var('scsize2');
        switch ($size)
        {
            case "5x5":
                $size = 1;
                $search_string = "5x5 Units";
                $title_search ="5x5 Units";
                break;
            case "5x10":
                $size = 2;
                $search_string = "5x10 Units";
                $title_search ="5x10 Units";
                break;
        }
        
        $clsFacilities = new SC_Facilities;
        $returned_facilities = $clsFacilities->getFacilitiesSizes($size);
        $facilities = $returned_facilities->searchFacilitiesResult->searchFacilities_Response;
    }

    if (!empty(get_query_var('srchstring')))
    {
           $sc_storage_options = get_option('sc_storage_options');
           $radius = esc_attr($sc_storage_options['option_radius']);
           $search_string = str_replace("-", " ", get_query_var('srchstring'));
           $title_search = $search_string;
           $clsSearch = new SC_Search;
           $location_result = $clsSearch->getLocation($search_string);
           $location = $location_result->geoCodeLocationResult->geoCodeLocation_Response;
           if ( $location->ReplyCode == '1')
           {
               $clsFacilities = new SC_Facilities;
               $returned_facilities = $clsFacilities->getFacilities("", "", "", $location->Latitude, $location->Longitude, $radius, "", "", "", "R", 0);
               $facilities = $returned_facilities->searchFacilitiesResult->searchFacilities_Response;
              
           }

    }
    
?>
<?php get_header(); ?>
<nav class="breadcrumbs">
        <ul>
<li class="home"><a href="<?php echo get_bloginfo('url') ?>" class="home">Chicago Storage</a></li>
<li class="current_item"><?php echo $search_string . " ";?>Search Results</li>
        </ul>
    </nav>

<h1><?php printf( __( 'Search Results for: %s', 'chicagostorage' ), '<span>' . esc_attr($search_string) . '</span>'); ?></h1>
<section class="result">
<?php

 if (is_array($facilities))
 {
    foreach ($facilities as $facility):
   
        ?>

        <div class="item">

           <div class="photo">
               <img width="128" height="96" src="http://www.storage.com/z-images/<?php echo $facility->SiteSource; ?>/128x96/<?php echo $facility->Images->string[0]; ?>" class="attachment-archive-thumbnail wp-post-image" alt="img1" />
           </div>

       <div class="info">
           <strong class="title"><a href="<?php echo "<a href='/facility/" . $facility->Id  ?>"><?php echo $facility->Branding ?></a></strong>
               <?php echo $facility->Address . "<br />"; 
                     echo $facility->City . " , " . $facility->StateAbbreviation . " " . $facility->PostalCode . "<br />";
               ?>
           <div class="rating"></div>
       </div>
           <div class="price-holder">
               <span><?php _e('units from','chicagostorage'); ?></span>
               <strong><?php echo '$' . number_format($facility->StartingAtPrice, 2); ?></strong>
           </div>
       <div class="btn-holder">
           <?php echo "<a href='/" . display_url($facility->Branding) . "-" . display_url($facility->Address) . "-" . display_url($facility->City) . "-" . $facility->StateAbbreviation . "-". $facility->PostalCode ."/" . $facility->Id . "/'" . "class='btn'>"?> <?php _e('more info','chicagostorage'); ?></a>
       </div>
   </div>
   <?php
      endforeach;
   }
   elseif (!empty($facilities) && $facilities->ReplyCode <> -1)
   {
            $facility = $facilities;
    ?>
             <div class="item">

           <div class="photo">
               <img width="128" height="96" src="http://www.storage.com/z-images/<?php echo $facility->SiteSource; ?>/128x96/<?php echo $facility->Images->string[0]; ?>" class="attachment-archive-thumbnail wp-post-image" alt="img1" />
           </div>

       <div class="info">
           <strong class="title"><a href="<?php echo "<a href='/facility/" . $facility->Id  ?>"><?php echo $facility->Branding ?></a></strong>
               <?php echo $facility->Address . "<br />"; 
                     echo $facility->City . " , " . $facility->StateAbbreviation . " " . $facility->PostalCode . "<br />";
               ?>
           <div class="rating"></div>
       </div>
           <div class="price-holder">
               <span><?php _e('units from','chicagostorage'); ?></span>
               <strong><?php echo '$' . number_format($facility->StartingAtPrice, 2); ?></strong>
           </div>
       <div class="btn-holder">
           <?php echo "<a href='/" . display_url($facility->Branding) . "-" . display_url($facility->Address) . "-" . display_url($facility->City) . "-" . $facility->StateAbbreviation . "-". $facility->PostalCode ."/" . $facility->Id . "/'" . "class='btn'>"?> <?php _e('more info','chicagostorage'); ?></a>
       </div>
   </div>
   <?php   
   }
   else
   {
       get_template_part('blocks/facilities-not-found');
   }

?>

</section>
	
<?php get_footer(); ?>