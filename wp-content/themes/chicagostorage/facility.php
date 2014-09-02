<?php
/**
* Template Name: Facility
 */
?>
<?php 

    $facID = get_query_var('scid');
 
    $clsFacility = new SC_Facility;
    $returned_facility = $clsFacility->getFacility($facID);
    $facility = $returned_facility->getFacilityResult;
    $images = $facility->Images->string;
    
    $clsUnits = new SC_Units;
    $returned_units = $clsUnits->getUnits($facID);
    $units = $returned_units->getUnitsAvailableResult->getUnitsAvailable_Response;
    $sc_storage_options = get_option('sc_storage_options');
     
    get_header();
    
    
    ?>
    <nav class="breadcrumbs">
        <ul>
            <li class="home"><a href="<?php echo get_bloginfo('url') ?>" class="home">Chicago Storage</a></li>
            <li class="current_item"><?php echo $facility->Branding . " " . $facility->Address . " " . $facility->City. " , " . $facility->StateAbbreviation . " " . $facility->PostalCode ;?></li>
        </ul>
    </nav>
    <h1>Storage Units at <?php echo $facility->Branding; ?></h1>
    <article class="details">
        <div class="carousel2">
            <div class="mask">
                <ul class="slideset">
                    <?php if (!empty($images)): ?>
                        <?php if (is_array($images)): ?>
                            <?php foreach($images as $image): ?>
                                <?php if (!empty($image)): ?>
                                    <li><img src="http://www.storage.com/z-images/<?php echo $facility->SiteSource; ?>/316x238/<?php echo $image; ?>" height="316" width="238"></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><img src="http://www.storage.com/z-images/<?php echo $facility->SiteSource; ?>/316x238/<?php echo $images; ?>" height="316" width="238"></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><img src="<?php echo get_template_directory_uri() . "/images/316x238/chicago-storage-default-pic-01.jpg"; ?>" height="316" width="238"></li>  
                    <?php endif; ?>
                </ul>
            </div>
            <?php if (is_array($images)): ?>
                <a href="#" class="btn-prev icon-arrow-left"></a>
                <a href="#" class="btn-next icon-arrow-right"></a>
            <?php endif; ?>
        </div>
        <div class="info">
            <div class="hold">
                <h1><?php echo $facility->Branding ?></h1>
                <?php echo $facility->Address . "<br/>";
                    echo $facility->City. " , " . $facility->StateAbbreviation . " " . $facility->PostalCode . "<br /><br />";
                ?>
            </div>
             <?php 
                $facility_features = explode("|", $facility->Features); 
                echo "<ul>";
                foreach($facility_features as $facfeature):
                    echo "<li>" . $facfeature . "</li>";
                endforeach;
                echo "</ul>";
            ?>
        </div>
        <div class="tab-area">
            <ul class="tabset">
                <li class="active"><a href="#units"><?php _e('Units','chicagostorage'); ?></a></li>
                <?php if (!empty($facility->OfficeHours) || !empty($facility->GateHours)): ?>
                    <li><a href="#hours"><?php _e('Hours','chicagostorage'); ?></a></li>
                <?php endif; ?>
                <?php if (comments_open()): ?>
                    <li><a href="#reviews"><?php _e('Reviews','chicagostorage'); ?></a></li>
                <?php endif; ?>
            </ul>
            <?php if (count($units) > 1): ?>
                <div id="units">
                    <table>
                        <?php foreach($units as $unit):  ?>
                            <tr>
                                    <td>
                                         <strong class="size"><?php echo $unit->Width . "x" . $unit->Length; ?></strong>   
                                    </td>
                                <td>
                                    <?php 
                                    $features = explode("|", $unit->Features); 
                                    echo "<ul>";
                                    foreach($features as $feature):
                                        echo "<li>" . $feature . "</li>";
                                    endforeach;
                                    echo "</ul>";
                                    ?>
                                </td>
                                <td>
                                    <div class="price-holder">
                                        <div class="price">
                                            <strong><?php echo '$' . number_format($unit->DiscountRate, 0); ?></strong>
                                            <span><?php _e('Month','chicagostorage'); ?></span>
                                        </div>
                                        <?php echo wpautop($unit->Promotion,false); ?>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="btn-holder">
                                         <?php echo "<a href='https://www.chicagostorage.com/index.php/reserve?scid=" .  $facID . "&scuid=" . $unit->Id . "'"; ?> class="btn"><span><?php _e('Rent now','chicagostorage'); ?></span></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php else: ?>
                <div id="units">
                    <table>
                            <tr>
                                    <td>
                                         <strong class="info">No units found for this facility.</strong>   
                                    </td>
                            </tr>
                    </table>
                </div>
            <?php endif; ?>
        <?php if (!empty($posts)): ?>
            <div id="units">
                <table>
                    <?php global $post; ?>
                    <?php foreach($posts as $post): setup_postdata($post); ?>
                        <tr>
                            <?php $tax = get_the_terms(get_the_ID(),'sizes'); ?>
                            <?php if (!empty($tax)): ?>
                                <td>
                                        <?php foreach($tax as $value): ?>
                                            <strong class="size"><?php echo $value->name; ?></strong>
                                        <?php endforeach; ?>
                                        <hr>
                                        <?php the_content(); ?>
                                </td>
                            <?php endif; ?>
                            <?php $price = get_field('price'); ?>
                            <td>
                                <?php if($price): ?>
                                    <div class="price-holder">
                                        <div class="price">
                                            <strong><?php echo $price; ?></strong>
                                            <span><?php _e('Month','chicagostorage'); ?></span>
                                        </div>
                                        <?php echo wpautop(get_field('price_descriptions'),false); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="btn-holder">
                                    <a href="<?php the_permalink(); ?>" class="btn"><span><?php _e('Rent now','chicagostorage'); ?></span></a>
                                </div>
                            </td>
                        </tr>
                        <?php wp_reset_postdata(); ?>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
        <?php if ($office_h || $gate_h): ?>
            <div id="hours">
                <table>
                    <tr>
                    <?php if ($office_h): ?>
                        <td>
                            <strong class="title"><?php _e('Office Hours','chicagostorage'); ?></strong>
                            <?php echo wpautop($office_h,false); ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($gate_h): ?>
                        <td>
                            <strong class="title"><?php _e('Gate Hours','chicagostorage'); ?></strong>
                            <?php echo wpautop($gate_h,false); ?>
                        </td>
                    <?php endif; ?>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
        <?php if (comments_open()): ?>
            <div id="reviews">
                <table>
                    <tr>
                        <td>
                            <?php comments_template(); ?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
        <?php if (!empty($facility->OfficeHours) || !empty($facility->GateHours)): ?>
            <div id="hours">
                <table>
                    <tr>
                    <?php if (!empty($facility->OfficeHours)): ?>
                        <td>
                            <strong class="title"><?php _e('Office Hours','chicagostorage'); ?></strong>
                            <?php echo "<br />" . $facility->OfficeHours;  ?>
                        </td>
                    <?php endif; ?>
                    <?php if (!empty($facility->GateHours)): ?>
                        <td>
                            <strong class="title"><?php _e('Gate Hours','chicagostorage'); ?></strong>
                            <?php echo "<br />" . $facility->GateHours; ?>
                        </td>
                    <?php endif; ?>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
        <?php if (comments_open()): ?>
            <div id="reviews">
                <table>
                    <tr>
                        <td>
                            <?php comments_template(); ?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </article>
   
<?php get_footer(); ?>
    

?>

