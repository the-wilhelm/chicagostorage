<?php
/*
Template Name: Home Template
*/
get_header();

$sc_storage_options = get_option('sc_storage_options');
$sc_latitude = esc_attr($sc_storage_options['option_latitude']);
$sc_longitude = esc_attr($sc_storage_options['option_longitude']);

$clsFacilities = new SC_Facilities;
$returned_facilities = $clsFacilities->getFacilities("", "", "", $sc_latitude, $sc_longitude, "", "", "", "", "R", 3);
$facilities = $returned_facilities->searchFacilitiesResult->searchFacilities_Response;

?>

<?php get_template_part('blocks/search','locations'); ?>
<?php get_template_part('blocks/search','customs'); ?>
<?php while (have_posts()) : the_post(); ?>
	<?php if ($best_values = get_field('best_values')) : ?>
		<section class="featured">
			<h2><?php _e('best value nearby','chicagostorage'); ?></h2>
			<div class="carousel">
				<div class="mask">
					<ul class="slideset">
						<?php foreach($facilities as $facility): ?>
							<li>
							 	<img width="266" height="139" src="http://local.chicagostorage.com/wp-content/uploads/2014/08/img1.jpg" class="attachment-sites-home-thumbnail wp-post-image" alt="img1" /> 
								<div class="holder">
									<strong class="title"><?php echo _e($facility->Branding,'chicagostorage'); ?></strong>
									<?php echo "<p>" . $facility->Address . "<br/>";
                                    echo $facility->City. " , " . $facility->StateAbbreviation . " " . $facility->PostalCode . "<br /></p>"; 
									echo "<a href='/facility/" . $facility->Id . "'"; ?> class='btn'><span><?php _e('select this facility','chicagostorage'); ?> <i class="icon-caret-right"></i></span></a>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="paging"></div>
			</div>
		</section>
	<?php endif; ?>
<?php endwhile; ?>
<?php get_footer(); ?>