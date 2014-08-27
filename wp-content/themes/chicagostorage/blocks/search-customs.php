<?php if ($find = get_field('find_box','options')): ?>
    <section class="find-box">
        <?php echo $find;  ?>
    </section>
<?php endif; ?>
<?php if ($terms = get_field('terms_to_link','options') ): ?>
    <section class="search-btns">
        <?php if ($title = get_field('taxanomy_links_title','options')) : ?>
            <h3><?php echo $title; ?></h3>
        <?php endif; ?>
        <div class="btn-holder">
            <a href="<?php echo "/5x5"; ?>" class="btn"><span><?php _e('search '. "5x5".' units','chicagostorage') ?> <i class="icon-caret-right"></i></span></a>
            <a href="<?php echo "/5x10"; ?>" class="btn"><span><?php _e('search '. "5x10".' units','chicagostorage') ?> <i class="icon-caret-right"></i></span></a>
        </div>
    </section>
<?php endif; ?>