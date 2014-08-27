<h1><?php _e('Reserve Now','chicagostorage'); ?></h1>
<?php $cpost = get_post(); ?>
<?php $parent_post = get_topmost_parent($cpost->ID); ?>
<div class="product-info">
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
</div>
<?php wp_reset_postdata($post); ?>
<?php echo str_replace(array("\xA0","&nbsp;"),"",html_entity_decode(do_shortcode(get_field('form')))); ?>