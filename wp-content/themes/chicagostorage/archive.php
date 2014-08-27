<?php get_header(); ?>
	<?php get_template_part('blocks/breadcrumb'); ?>
	<?php if (have_posts()) : ?>
	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h1><?php printf(__( 'Archive for the &#8216;%s&#8217; Category', 'chicagostorage' ), single_cat_title('', false)); ?></h1>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>			
	<h1><?php printf(__( 'Posts Tagged &#8216;%s&#8217;', 'chicagostorage' ), single_tag_title('', false)); ?></h1>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h1><?php _e('Archive for', 'chicagostorage'); ?> <?php the_time('F jS, Y'); ?></h1>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h1><?php _e('Archive for', 'chicagostorage'); ?> <?php the_time('F, Y'); ?></h1>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h1><?php _e('Archive for', 'chicagostorage'); ?> <?php the_time('Y'); ?></h1>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h1><?php _e('Author Archive', 'chicagostorage'); ?></h1>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h1><?php _e('Blog Archives', 'chicagostorage'); ?></h1>
	<?php } ?>
	<?php $type = empty($_REQUEST['by_location']) ? 'archive' : 'location'; ?>
	<section class="result">
	<?php while (have_posts()) : the_post(); ?>
    
        <?php $type = (get_post_type() == 'site') ? 'location' : 'archive'; ?>
		<?php get_template_part('blocks/content', $type); ?>
	<?php endwhile; ?>
	</section>
	<?php get_template_part('blocks/pager'); ?>
	
	<?php else : ?>
		<?php get_template_part('blocks/not_found'); ?>
	<?php endif; ?>

<?php get_footer(); ?>