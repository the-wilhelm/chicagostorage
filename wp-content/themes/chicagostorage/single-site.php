<?php get_header(); ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php $cpost = get_post(); ?>
        <?php if ($cpost->post_parent == 0): ?>
			<?php get_template_part('blocks/breadcrumb'); ?>
            <article class="details">
                <?php get_template_part('blocks/content', get_post_type().'-parent'); ?>
            </article>
        <?php else: ?>
            <div class="checkout">
                <?php get_template_part('blocks/content', get_post_type().'-child'); ?>
            </div>
        <?php endif; ?>
    <?php endwhile; ?>
<?php get_footer(); ?>