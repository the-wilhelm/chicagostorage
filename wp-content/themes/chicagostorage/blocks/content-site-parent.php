<?php get_template_part('blocks/gallery'); ?>
<div class="info">
    <div class="hold">
        <h1><?php the_title(); ?></h1>
        <?php if ($phone = get_field('phone')): ?>
            <?php $phone = preg_replace('/[^\d]/','',$phone); ?>
            <?php $phone = preg_replace('/([\d]{3})([\d]{3})([\d]{4})/','$1-$2-$3',$phone); ?>
            <div class="call"><?php _e('call toll free ',''); ?><strong><?php echo $phone; ?></strong></div>
        <?php endif; ?>
        <?php echo wpautop(get_field('location'),false); ?>
        <div class="rating"><?PHP if(function_exists('the_ratings')) { the_ratings(); } ?></div>
    </div>
    <?php the_content(); ?>
</div>
<?php $args = array(
    'post_type'=>'site',
    'post_parent'=>get_the_ID(),
    'posts_per_page'=>-1,
    'numberposts'=>-1,
                    ) ?>
<?php $posts = get_posts($args); ?>
<div class="tab-area">
    <ul class="tabset">
        <?php if (!empty($posts)): ?>
            <li class="active"><a href="#units"><?php _e('Units','chicagostorage'); ?></a></li>
        <?php endif; ?>
        <?php $office_h = get_field('office_hours'); ?>
        <?php $gate_h = get_field('office_hours'); ?>
        <?php if ($office_h || $gate_h): ?>
            <li><a href="#hours"><?php _e('Hours','chicagostorage'); ?></a></li>
        <?php endif; ?>
        <?php if (comments_open()): ?>
            <li><a href="#reviews"><?php _e('Reviews','chicagostorage'); ?></a></li>
        <?php endif; ?>
    </ul>
    <?php if (!empty($posts)): ?>
        <div id="units">
            <table>
                <?php global $post; ?>
                <?php foreach($posts as $post): setup_postdata($post); ?>
                    <tr>
                        <?php $tax = get_the_terms(get_the_ID(),'sizes'); ?>
                        <?php if (!empty($tax)): ?>
                            <td>
                                    <?php foreach($tax as $value): ?>
                                        <strong class="size"><?php echo $value->name; ?></strong>
                                    <?php endforeach; ?>
                                    <hr>
                                    <?php the_content(); ?>
                            </td>
                        <?php endif; ?>
                        <?php $price = get_field('price'); ?>
                        <td>
                            <?php if($price): ?>
                                <div class="price-holder">
                                    <div class="price">
                                        <strong><?php echo $price; ?></strong>
                                        <span><?php _e('Month','chicagostorage'); ?></span>
                                    </div>
                                    <?php echo wpautop(get_field('price_descriptions'),false); ?>
                                </div>
                            <?php endif; ?>
                            <div class="btn-holder">
                                <a href="<?php the_permalink(); ?>" class="btn"><span><?php _e('Rent now','chicagostorage'); ?></span></a>
                            </div>
                        </td>
                    </tr>
                    <?php wp_reset_postdata(); ?>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>
    <?php if ($office_h || $gate_h): ?>
        <div id="hours">
            <table>
                <tr>
                <?php if ($office_h): ?>
                    <td>
                        <strong class="title"><?php _e('Office Hours','chicagostorage'); ?></strong>
                        <?php echo wpautop($office_h,false); ?>
                    </td>
                <?php endif; ?>
                <?php if ($gate_h): ?>
                    <td>
                        <strong class="title"><?php _e('Gate Hours','chicagostorage'); ?></strong>
                        <?php echo wpautop($gate_h,false); ?>
                    </td>
                <?php endif; ?>
                </tr>
            </table>
        </div>
    <?php endif; ?>
    <?php if (comments_open()): ?>
        <div id="reviews">
            <table>
                <tr>
                    <td>
                        <?php comments_template(); ?>
                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
</div>