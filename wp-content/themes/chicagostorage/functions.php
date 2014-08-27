<?php

//Staging restrictions
if (file_exists(sys_get_temp_dir().'/staging-restrictions.php')) {
	define('STAGING_RESTRICTIONS', true);
	require_once sys_get_temp_dir().'/staging-restrictions.php';
}

include( get_template_directory() .'/classes.php' );
include( get_template_directory() .'/widgets.php' );

add_action('themecheck_checks_loaded', 'theme_disable_cheks');
function theme_disable_cheks() {
	$disabled_checks = array('TagCheck');
	global $themechecks;
	foreach ($themechecks as $key => $check) {
		if (is_object($check) && in_array(get_class($check), $disabled_checks)) {
			unset($themechecks[$key]);
		}
	}
}

add_theme_support( 'automatic-feed-links' );

if ( ! isset( $content_width ) ) $content_width = 900;

remove_action('wp_head', 'wp_generator');

add_action( 'after_setup_theme', 'theme_localization' );
function theme_localization () {
	load_theme_textdomain( 'chicagostorage', get_template_directory() . '/languages' );
}


if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'id' => 'footer-sidebar',
		'name' => __('Footer Sidebar', 'chicagostorage'),
		'before_widget' => '<section class="block">',
		'after_widget' => '</section>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
}

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 50, 50, true ); // Normal post thumbnails
	add_image_size( 'single-post-thumbnail', 400, 9999, true );
	add_image_size( 'sites-home-thumbnail', 266, 139, false );
	add_image_size( 'archive-thumbnail', 126, 81, false );
	add_image_size( 'gallery-thumbnail', 616, 315, false );
	add_image_size( 'checkout-thumbnail', 280, 158, false );
}

register_nav_menus( array(
	'footer' => __( 'Footer Navigation', 'chicagostorage' ),
) );


//Add [email]...[/email] shortcode
function shortcode_email($atts, $content) {
	$result = '';
	for ($i=0; $i<strlen($content); $i++) {
		$result .= '&#'.ord($content{$i}).';';
	}
	return $result;
}
add_shortcode('email', 'shortcode_email');

function shortcode_link($atts, $content) {
	$result = '';
	for ($i=0; $i<strlen($content); $i++) {
		$result .= '&#'.ord($content{$i}).';';
	}
	return $result;
}
add_shortcode('link', 'shortcode_link');

//Register tag [template-url]
function filter_template_url($text) {
	return str_replace('[template-url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'filter_template_url');
add_filter('get_the_content', 'filter_template_url');
add_filter('widget_text', 'filter_template_url');


//Register tag [site-url]
function filter_site_url($text) {
	return str_replace('[site-url]',get_bloginfo('url'), $text);
}
add_filter('the_content', 'filter_site_url');
add_filter('get_the_content', 'filter_site_url');
add_filter('widget_text', 'filter_site_url');

//Replace standard wp menu classes
function change_menu_classes($css_classes) {
	$css_classes = str_replace("current-menu-item", "active", $css_classes);
	$css_classes = str_replace("current-menu-parent", "active", $css_classes);
	return $css_classes;
}
add_filter('nav_menu_css_class', 'change_menu_classes');

//Replace standard wp body classes and post classes
function theme_body_class($classes) {
	$non_prefix = array('home');
	if (is_array($classes)) {
		foreach ($classes as $key => $class) {
			if (!in_array($class,$non_prefix))
				$classes[$key] = 'body-class-' . $classes[$key];
		}
	}
	
	return $classes;
}
add_filter('body_class', 'theme_body_class', 9999);

function theme_post_class($classes) {
	if (is_array($classes)) {
		foreach ($classes as $key => $class) {
			$classes[$key] = 'post-class-' . $classes[$key];
		}
	}
	
	return $classes;
}
add_filter('post_class', 'theme_post_class', 9999);

//Allow tags in category description
$filters = array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description');
foreach ( $filters as $filter ) {
    remove_filter($filter, 'wp_filter_kses');
}


//Make wp admin menu html valid
function wp_admin_bar_valid_search_menu( $wp_admin_bar ) {
	if ( is_admin() )
		return;

	$form  = '<form action="' . esc_url( home_url( '/' ) ) . '" method="get" id="adminbarsearch"><div>';
	$form .= '<input class="adminbar-input" name="s" id="adminbar-search" tabindex="10" type="text" value="" maxlength="150" />';
	$form .= '<input type="submit" class="adminbar-button" value="' . __('Search', 'chicagostorage') . '"/>';
	$form .= '</div></form>';

	$wp_admin_bar->add_menu( array(
		'parent' => 'top-secondary',
		'id'     => 'search',
		'title'  => $form,
		'meta'   => array(
			'class'    => 'admin-bar-search',
			'tabindex' => -1,
		)
	) );
}

function fix_admin_menu_search() {
	remove_action( 'admin_bar_menu', 'wp_admin_bar_search_menu', 4 );
	add_action( 'admin_bar_menu', 'wp_admin_bar_valid_search_menu', 4 );
}

add_action( 'add_admin_bar_menus', 'fix_admin_menu_search' );

//Disable comments on pages by default
function theme_page_comment_status($post_ID, $post, $update) {
	if (!$update) {
		remove_action('save_post_page', 'theme_page_comment_status', 10);
		wp_update_post(array(
			'ID' => $post->ID,
			'comment_status' => 'closed',
		));
		add_action('save_post_page', 'theme_page_comment_status', 10, 3);
	}
}
add_action('save_post_page', 'theme_page_comment_status', 10, 3);

//custom excerpt
function theme_the_excerpt() {
	global $post;
	
	if (trim($post->post_excerpt)) {
		the_excerpt();
	} elseif (strpos($post->post_content, '<!--more-->') !== false) {
		the_content();
	} else {
		the_excerpt();
	}
}

/* advanced custom fields settings*/

//theme options tab in appearance
if(function_exists('acf_add_options_sub_page')) {
	acf_add_options_sub_page(array(
		'title' => 'Theme Options',
		'parent' => 'themes.php',
	));
}

//acf theme functions placeholders
if(!class_exists('acf') && !is_admin()) {
	function get_field_reference( $field_name, $post_id ) {return '';}
	function get_field_objects( $post_id = false, $options = array() ) {return false;}
	function get_fields( $post_id = false) {return false;}
	function get_field( $field_key, $post_id = false, $format_value = true )  {return false;}
	function get_field_object( $field_key, $post_id = false, $options = array() ) {return false;}
	function the_field( $field_name, $post_id = false ) {}
	function have_rows( $field_name, $post_id = false ) {return false;}
	function the_row() {}
	function reset_rows( $hard_reset = false ) {}
	function has_sub_field( $field_name, $post_id = false ) {return false;}
	function get_sub_field( $field_name ) {return false;}
	function the_sub_field($field_name) {}
	function get_sub_field_object( $child_name ) {return false;}
	function acf_get_child_field_from_parent_field( $child_name, $parent ) {return false;}
	function register_field_group( $array ) {}
	function get_row_layout() {return false;}
	function acf_form_head() {}
	function acf_form( $options = array() ) {}
	function update_field( $field_key, $value, $post_id = false ) {return false;}
	function delete_field( $field_name, $post_id ) {}
	function create_field( $field ) {}
	function reset_the_repeater_field() {}
	function the_repeater_field($field_name, $post_id = false) {return false;}
	function the_flexible_field($field_name, $post_id = false) {return false;}
	function acf_filter_post_id( $post_id ) {return $post_id;}
}

// Options Page
function theme_acf_options_page_settings( $settings )
{
	$settings['title'] = 'Theme Options';
	$settings['pages'] = array('Contacts','Search','Checkout','Home Side','Blog Settings');
	
	return $settings;
}
 
add_filter('acf/options_page/settings', 'theme_acf_options_page_settings');

// Sizes taxanomy

add_action( 'init', 'register_taxonomy_sizes' );

function register_taxonomy_sizes() {

    $labels = array( 
        'name' => _x( 'Sizes', 'sizes' ),
        'singular_name' => _x( 'Size', 'sizes' ),
        'search_items' => _x( 'Search Sizes', 'sizes' ),
        'popular_items' => _x( 'Popular Sizes', 'sizes' ),
        'all_items' => _x( 'All Sizes', 'sizes' ),
        'parent_item' => _x( 'Parent Size', 'sizes' ),
        'parent_item_colon' => _x( 'Parent Size:', 'sizes' ),
        'edit_item' => _x( 'Edit Size', 'sizes' ),
        'update_item' => _x( 'Update Size', 'sizes' ),
        'add_new_item' => _x( 'Add New Size', 'sizes' ),
        'new_item_name' => _x( 'New Size', 'sizes' ),
        'separate_items_with_commas' => _x( 'Separate sizes with commas', 'sizes' ),
        'add_or_remove_items' => _x( 'Add or remove Sizes', 'sizes' ),
        'choose_from_most_used' => _x( 'Choose from most used Sizes', 'sizes' ),
        'menu_name' => _x( 'Sizes', 'sizes' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'show_admin_column' => false,
        'hierarchical' => true,

        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'sizes', array('site'), $args );
}


add_action( 'init', 'register_cpt_site' );

function register_cpt_site() {

    $labels = array( 
        'name' => _x( 'Sites', 'site' ),
        'singular_name' => _x( 'Site', 'site' ),
        'add_new' => _x( 'Add New', 'Site' ),
        'add_new_item' => _x( 'Add New Site', 'site' ),
        'edit_item' => _x( 'Edit Site', 'site' ),
        'new_item' => _x( 'New Site', 'site' ),
        'view_item' => _x( 'View Site', 'site' ),
        'search_items' => _x( 'Search sites', 'site' ),
        'not_found' => _x( 'No sites found', 'site' ),
        'not_found_in_trash' => _x( 'No sites found in Trash', 'site' ),
        'parent_item_colon' => _x( 'Parent Site:', 'site' ),
        'menu_name' => _x( 'Sites', 'site' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        
        'supports' => array( 'title', 'editor', 'excerpt','comments', 'thumbnail', 'page-attributes' ),
        'taxonomies' => array( 'sizes', 'site_types' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'site', $args );
}

function the_excerpt_max_charlength( $charlength ){
	$excerpt = get_the_excerpt();
	$excerpt = !empty($excerpt) ? $excerpt : get_the_content();
	$charlength++;
	$res = '';
	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$res .= mb_substr( $subex, 0, $excut );
		} else {
			$res .= $subex;
		}
		$res .= '...';
	} else {
		$res .= $excerpt;
	}
	echo wpautop($res,$res);
}




// acf rules hase_parent
add_filter('acf/location/rule_types', 'acf_location_rules_types');
function acf_location_rules_types( $choices )
{
    $choices['Basic']['has_parent'] = 'Has Parent';
 
    return $choices;
}

add_filter('acf/location/rule_values/has_parent', 'acf_location_rules_values_has_parent');
function acf_location_rules_values_has_parent( $choices )
{
		$choices[ 'is_child' ] = 'Is Child';
		$choices[ 'is_parent' ] = 'Is Parent';
    return $choices;
}

add_filter('acf/location/rule_match/has_parent', 'acf_location_rules_match_has_parent', 10, 3);
function acf_location_rules_match_has_parent( $match, $rule, $options )
{
    $current_post = get_post($options['post_id']);//wp_get_current_user();
    $selected_value =  $rule['value'];
	$current_value = ($current_post->post_parent == 0) ? 'is_parent' : 'is_child';
 
    if($rule['operator'] == "==")
    {
    	$match = ( $selected_value == $current_value );
    }
    elseif($rule['operator'] == "!=")
    {
    	$match = ( $selected_value != $current_value );
    }
 
    return $match;
}




function my_acf_result_query( $args, $field, $post )
{
    // eg from https://codex.wordpress.org/Class_Reference/WP_Query#Custom_Field_Parameters
	
    $args['post_parent'] = 0;
 
    return $args;
}
 
// acf/fields/relationship/result/name={$field_name} - filter for a specific field based on it's name
add_filter('acf/fields/relationship/query/name=best_values', 'my_acf_result_query', 10, 3);

function get_topmost_parent($post_id){
  $parent_id = get_post($post_id)->post_parent;
  if($parent_id == 0){
    return $post_id;
  }else{
    return get_topmost_parent($parent_id);
  }
}


add_action('pre_get_posts', 'search_pre_post' );

function search_pre_post( $wp_query ) {
	if ($wp_query->is_search && !empty($_REQUEST['by_location'])){
		$s = $wp_query->query_vars['s'];
		$wp_query->set('post_parent',0);
		$meta_query = $wp_query->get('meta_query');
		$wp_query->set('post_type','site');
		$meta_query = array(
			array(
			'key' => 'location',
			'value' => $s,
			'compare' => 'LIKE'
		)
		 );
		$wp_query->set('meta_query',$meta_query);
		$wp_query->set('s',"");
	}
	return $wp_query;
}

function get_theme_image($img,$size='full',$args=array()){
	$html = false;
	if (!empty($img)){
		if (is_array($img)){
			$attrs = '';
			$src = (!empty($img['sizes'][$size])) ? $img['sizes'][$size] : $img['url'];
			$width = (!empty($img['sizes'][$size.'-width'])) ? $img['sizes'][$size.'-width'] : $img['width'];
			$height = (!empty($img['sizes'][$size.'-height'])) ? $img['sizes'][$size.'-height'] : $img['height'];
			$alt = (!empty($img['alt'])) ? $img['alt'] : $img['title'];
			foreach ($args as $key=>$value){
				$attrs .= ' '.$key.'="'.$value.'"';
			}
			$html = "<img$attrs src=\"$src\" height=\"$height\" width=\"$width\" alt=\"$alt\">";
		}
		else{
			$html = wp_get_attachment_image($img,$size,false,$args);
		}
	}
	return $html;
}

add_action('init', 'search_query_fix');
function search_query_fix(){
	if(isset($_GET['s']) && $_GET['s']==''){
			$_GET['s']=' ';
	}
}

function load_bootstrap()
{
    wp_register_script('bootstrap-3-2-0', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array('jquery'), null, true);
    wp_enqueue_script('bootstrap-3-2-0');

    wp_register_script('jquery-masked-input', get_template_directory_uri() . '/js/jquery.maskedinput.min.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-masked-input'); 
    
    wp_register_script('jquery-validation-tooltips', get_template_directory_uri() . '/js/jquery-validate.bootstrap-tooltip.min.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-validation-tooltips'); 

}

add_action('wp_enqueue_scripts', 'load_bootstrap');

function display_url($search_string)
{
    $search_string = str_replace(" ", "-", $search_string);
    $search_string = str_replace("'", "-", $search_string);
    $search_string = str_replace(".", "", $search_string);
    $search_string = str_replace("$", "-", $search_string);
    $search_string = str_replace("--", "-", $search_string);

    return $search_string;
        
}

global $title_search;
global $facility;