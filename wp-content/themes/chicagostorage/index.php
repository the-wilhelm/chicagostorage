
<?php get_header(); ?>
	<?php get_template_part('blocks/breadcrumb'); ?>
	<?php if (have_posts()) : ?>
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