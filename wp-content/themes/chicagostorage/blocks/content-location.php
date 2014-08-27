<div class="item">
    <?php if (has_post_thumbnail()): ?>
        <div class="photo">
            <?php the_post_thumbnail('archive-thumbnail'); ?>
        </div>
    <?php endif; ?>
    <div class="info">
        <strong class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong>
        <?php $cpost = get_post(); ?>
        <?php if ($cpost->post_parent==0): ?>
            <?php echo wpautop(get_field('location'),false); ?>
        <?php else: ?>
            <?php the_content(); ?>
        <?php endif; ?>
        <div class="rating"><?PHP if(function_exists('the_ratings')) { the_ratings(); } ?></div>
    </div>
    <?php if ($cpost->post_parent==0): ?>
        <?php $id = get_the_ID(); ?>
        <?php $arr = array(
            'post_type' =>'site',
            'numberposts' => 1,
            'post_parent' => $id,
            'meta_key'  => 'price',
            'orderby'   =>  'meta_value ',
            'order' =>  'DESC'
                           ); ?>
        <?php $min = reset(get_posts($arr));  ?>
    <?php else: ?>
        <?php $min = $cpost;  ?>
    <?php endif; ?>
    <div class="row">  
        <?php if (!empty($min)): ?>
            <?php $price = get_field('price',$min->ID); ?>
            <?php $descript = get_field('price_descriptions',$min->ID); ?>
            <div class="price-holder">
                <span><?php _e('units from','chicagostorage'); ?></span>
                <strong><?php echo $price; ?></strong>
            </div>
            <?php if(!empty($descript)): ?>
                <div class="discount">
                    <?php echo wpautop($descript,false); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="btn-holder">
            <a href="<?php the_permalink(); ?>" class="btn"><?php _e('more info','chicagostorage'); ?></a>
        </div>
    </div>
</div>