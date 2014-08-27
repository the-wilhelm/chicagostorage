<?php $sq = get_search_query() ? get_search_query() : __('', 'chicagostorage'); ?>
<section class="search-box">
    <form id="search_form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
        <input type="search" id="s" name="s" placeholder="<?php _e('Search street name or address','chicagostorage'); ?>" value="<?php echo $sq; ?>">
        <input type="hidden" name="by_location" value="1">
        <button type="submit"><span><?php _e('search','chicagostorage'); ?> <i class="icon-search"></i></span></button>
    </form>
</section>