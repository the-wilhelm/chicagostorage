<?php get_header(); ?>
	<?php get_template_part('blocks/breadcrumb'); ?>
	<article class="article">
		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part('blocks/content', get_post_type()); ?>		
			<?php comments_template(); ?>
			<?php get_template_part('blocks/pager-single', get_post_type()); ?>
			
		<?php endwhile; ?>
	<article class="article">
</div>
<?php get_footer(); ?>