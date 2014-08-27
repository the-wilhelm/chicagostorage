
			<?php if ( is_single() ) :
				the_title( '<h1>', '</h1>' );
			else :
				the_title( '<h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif; ?>		
			<p class="info"><strong class="date"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_time('F jS, Y') ?></a></strong> <?php _e('by', 'chicagostorage'); ?> <?php the_author(); ?></p>

		<?php the_post_thumbnail('full'); ?>
		<?php if (is_single()) :
			the_content();
		else:
			theme_the_excerpt();
		endif; ?>
	<?php wp_link_pages(); ?>
	<div class="meta">
		<ul>
			<li><?php _e('Posted in', 'chicagostorage'); ?> <?php the_category(', ') ?></li>
			<li><?php comments_popup_link(__('No Comments', 'chicagostorage'), __('1 Comment', 'chicagostorage'), __('% Comments', 'chicagostorage')); ?></li>
			<?php the_tags(__('<li>Tags: ', 'chicagostorage'), ', ', '</li>'); ?>
			<?php edit_post_link( __( 'Edit', 'chicagostorage' ), '<li>', '</li>' ); ?>
		</ul>
	</div>