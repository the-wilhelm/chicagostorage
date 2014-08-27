<div class="item">
    <?php if (has_post_thumbnail()): ?>
        <div class="photo">
            <?php the_post_thumbnail('archive-thumbnail'); ?>
        </div>
    <?php endif; ?>
    <div class="info archive">
        <strong class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong>
        <?php the_excerpt(); ?>
        <div class="rating"><?PHP if(function_exists('the_ratings')) { the_ratings(); } ?></div>
    </div>
    <div class="row">
        <div class="btn-holder">
            <a href="<?php the_permalink(); ?>" class="btn"><?php _e('more info','chicagostorage'); ?></a>
        </div>
    </div>
</div>