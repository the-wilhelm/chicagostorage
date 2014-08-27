<?php
/*
Plugin Name: Contact Form 7 Addon
Plugin URI: http://wordpress.org
Description: Additional "Logs" fields for Contact Form 7 plugin
Author: Nobody
Author URI: http://example.com
*/

$plugins = apply_filters('active_plugins', get_option( 'active_plugins' ));
if (!in_array('contact-form-7/wp-contact-form-7.php', $plugins)) {
	add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>Contact form 7 addon</strong>: this plugin requires Contact form 7 to be activated.</p></div>';"));
	return;
}

add_action( 'plugins_loaded', 'wpcf7_load_modules_addon' );

function wpcf7_load_modules_addon(){
    wpcf7_add_shortcode('logs', 'wpcf7_logs_shortcode_handler', true);
}

function wpcf7_logs_shortcode_handler($tag){
    $value = '';
    if(in_array('postpermalink', $tag['options'])):
        if(in_the_loop()):
            $value .= get_permalink(get_the_ID());
        else:
            $value .= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        endif;
    endif;
    if(in_array('posttitle', $tag['options'])):
        global $wp_query;
        $post_ID = $wp_query->get_queried_object_id();
        if(in_the_loop()){
            $post_ID = get_the_ID();
        }
        if(is_single() or is_page()):
            $title = get_the_title($post_ID);
        elseif(is_category() or is_tag()):
            $title = ucfirst($wp_query->queried_object->taxonomy) . ' : ' . ucfirst($wp_query->queried_object->name);
        elseif(is_author()):
            $title = 'Author Archive';
        elseif (is_day() or is_month() or is_year()):
            $title = 'Date archive';
        elseif(is_home()):
            $title = 'Blog Page';
        elseif(is_search()):
            $title = 'Search Page';
        elseif(is_404()):
            $title = '404 Page';
        endif;
        if(in_the_loop()):
            $title = get_the_title(get_the_ID());
        endif;
        $value .= $title;
    endif;
    if(in_array('referer', $tag['options'])):
        $value .= $_SERVER['HTTP_REFERER'];
    endif;
    if(in_array('userip', $tag['options'])):
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')):
            $ip = getenv('HTTP_CLIENT_IP');
        elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')):
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')):
            $ip = getenv('REMOTE_ADDR');
        elseif (!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')):
            $ip = $_SERVER['REMOTE_ADDR'];
        else:
            $ip = 'unknown';
        endif;
        $value .= $ip;
    endif;
    if(in_array('useragent', $tag['options'])):
        $value .= $_SERVER['HTTP_USER_AGENT'];
    endif;
    return '<input type="hidden" value="'.$value.'" name="'.$tag['name'].'" />';
}

function wpcf7_add_tag_generator_logs() {
    wpcf7_add_tag_generator( 'logs', 'Logs', 'wpcf7-tg-pane-logs', 'wpcf7_tg_pane_logs');
}
add_action( 'admin_init', 'wpcf7_add_tag_generator_logs', 75 );

function wpcf7_tg_pane_logs(){
?>
<div id="wpcf7-tg-pane-logs" class="hidden">
<form action="">
<table><tr><td><?php echo esc_html( __( 'Name', 'wpcf7' ) ); ?><br /><input type="text" name="name" class="tg-name oneline" /></td></tr></table>
<table>
<tr>
<td colspan="2">

<input type="checkbox" checked="checked" name="postpermalink" class="exclusive option" />&nbsp;<?php echo esc_html( __( "Send page / post permalink", 'wpcf7' ) ); ?><br />
<input type="checkbox" name="posttitle" class="exclusive option" />&nbsp;<?php echo esc_html( __( "Send page / post title", 'wpcf7' ) ); ?><br />
<input type="checkbox" name="referer" class="exclusive option" />&nbsp;<?php echo esc_html( __( "Send referer", 'wpcf7' ) ); ?><br />
<input type="checkbox" name="userip" class="exclusive option" />&nbsp;<?php echo esc_html( __( "Send user IP", 'wpcf7' ) ); ?><br />
<input type="checkbox" name="useragent" class="exclusive option" />&nbsp;<?php echo esc_html( __( "Send useragent", 'wpcf7' ) ); ?>

</td>
</tr>
</table>
<div class="tg-tag"><?php echo esc_html( __( "Copy this code and paste it into the form left.", 'wpcf7' ) ); ?><br /><input type="text" name="logs" class="tag" readonly="readonly" onfocus="this.select()" /></div>
<div class="tg-mail-tag"><?php echo esc_html( __( "And, put this code into the Mail fields below.", 'wpcf7' ) ); ?><br /><span class="arrow">&#11015;</span>&nbsp;<input type="text" class="mail-tag" readonly="readonly" onfocus="this.select()" /></div>
</form>
</div>
<?php
}
?>