<?php $cpost = get_post(); ?>
<?php if (is_front_page()): ?>
	<?php
		//$home_side_data=array(
		//	'title' => get_field('home_side_title','options'),
		//	'description' => get_field('home_side_description','options'),
		//	'related' => get_field('home_side_posts','options'),
		//	'link_title' => get_field('home_side_title_link','options'),
		//	'link' => get_field('home_side_link','options'),
		//);
		//$home_side_data = array_filter($home_side_data);
	?>
	<?php/* if (!empty($home_side_data)): ?>
		<aside id="sidebar">
			<div class="box">
				<?php if (!empty($home_side_data['title'])): ?>
					<h3><?php echo $home_side_data['title']; ?></h3>
				<?php endif; ?>
				<?php if (!empty($home_side_data['description'])) echo wpautop($home_side_data['description'],false); ?>
				<?php if (!empty($home_side_data['related'])): ?>
					<ul>
						<?php for($i=0;$i<count($home_side_data['related']);$i++): ?>
							<li><a href="<?php echo get_permalink($home_side_data['related'][$i]->ID); ?>"><?php echo $home_side_data['related'][$i]->post_title; ?></a></li>
						<?php endfor; ?>
					</ul>
				<?php endif; ?>
				<?php if (!empty($home_side_data['link_title']) && !empty($home_side_data['link'])): ?>
					<a href="<?php echo $home_side_data['link']; ?>" class="btn"><?php echo $home_side_data['link_title']; ?> <i class="icon-caret-right"></i></a>
				<?php endif; ?>
			</div>
		</aside>
	<?php endif; */?>
<?php elseif($cpost->post_type=='site' && $cpost->post_parent!=0 && is_singular()): ?>
		<?php/* global $post; ?>
		<?php $post = $cpost; ?>
		<?php $parent_post = get_topmost_parent($cpost->ID); ?>
		<?php setup_postdata($post); ?>
		<aside id="sidebar" class="pull-left">
			<section class="product-info">
				<?php if (has_post_thumbnail()): ?>
						<div class="photo"><?php the_post_thumbnail('checkout-thumbnail'); ?></div>
				<?php endif; ?>
				<?php $tax = get_the_terms(get_the_ID(),'sizes'); ?>
				<?php if (!empty($tax)): ?>
					<?php foreach($tax as $value): ?>
						<strong class="size"><?php echo $value->name; ?></strong>
					<?php endforeach; ?>
				<?php endif; ?>
				<?php if($price = get_field('price')): ?>
						<span class="price"><strong><?php echo $price; ?></strong> <?php echo get_field('period') ? get_field('period') : __('per month','chicagostorage'); ?></span>
				<?php endif; ?>
				<?php if ($address = get_field('location',$parent_post)): ?>
						<strong class="title"><?php _e('Value Store It','chicagostorage'); ?></strong>
						<?php echo wpautop($address,false); ?>
				<?php endif; ?>
				<?php if ($office_hour = get_field('office_hours',$parent_post)): ?>
						<strong class="title"><?php _e('Office Hours','chicagostorage'); ?></strong>
						<?php echo wpautop($office_hour,false); ?>
				<?php endif; ?>
				<?php if ($gate_hour = get_field('gate_hours',$parent_post)): ?>
						<strong class="title"><?php _e('Gate Hours','chicagostorage'); ?></strong>
						<?php echo wpautop($gate_hour,false); ?>
				<?php endif; ?>
			</section>
		</aside>
		<?php wp_reset_postdata($post); */?>
<?php else: ?>
	<aside id="sidebar">
		<?php get_template_part('blocks/search','locations'); ?>
		<?php// get_template_part('blocks/search','customs'); ?>
	</aside>
<?php endif; ?>