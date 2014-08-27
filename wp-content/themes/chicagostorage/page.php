<?php get_header(); ?>
	<?php get_template_part('blocks/breadcrumb'); ?>
	<article class="article">
		<?php while (have_posts()) : the_post(); ?>
			<?php the_title('<h1>', '</h1>'); ?>
			<?php the_content(); ?>
			<?php edit_post_link( __( 'Edit', 'chicagostorage' ) ); ?>	
		<?php endwhile; ?>
		<?php comments_template(); ?>
	</article>

<?php get_footer(); ?>