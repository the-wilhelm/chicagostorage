<?php
/*
    Plugin Name: SC Storage
    Plugin URI: http://www.b2interactive.com
    Description: Create a pluging to add storage functionallity
    Version: 1.0
    Author: B2Interactive
    Author URI: http://www.b2interactive.com
    License: GPLv2
*/
register_activation_hook(__FILE__,'storage_install');

function storage_install()
{
    global $wp_version;
    if (version_compare($wp_version, '3.5', '<'))
    {
        wp_die('This plugin requires WordPress version 3.5 or higher.');
    }
    $sc_storage_options_arr = array(
                            'option_siteid' => '999',
                            'option_city' => 'Nashville',
                            'option_state' => 'TN',
                            'option_telephone' => '(402) 555-1111',
                            'option_latitude' => 36.165890,
                            'option_longitude' => -86.784440,
                            'option_radius' => 10,
                            'option_email' => 'charles.mccullough@b2interactive.com',
                            'option_ws_login' => '',
                            'option_ws_password' => '',
                            'option_ws_url' => ''
                            );
    
    add_option('sc_storage_options', $sc_storage_options_arr);
    
//    add_facility_rewrite_rules();
    flush_rewrite_rules();
}

register_deactivation_hook(__FILE__,'storage_uninstall');
function storage_uninstall()
{
    delete_option('sc_storage_options');
//    flush_rewrite_rules();
}

define('SC_PLUGIN_VERSION','1.0.0');

define( 'SC_PARENT_DIR', plugin_dir_path(__FILE__) );
define( 'SC_PARENT_URL', plugin_dir_url(__FILE__) );

add_action('admin_menu', 'sc_storage_menu');

function sc_storage_menu() {
    add_menu_page("SC Storage Plugin Page", 'SC Storage', 'manage_options', 'sc_storage_main_menu', 'sc_storage_plugin_page', plugins_url('/images/wordpress.png', __FILE__));

    add_submenu_page('sc_storage_main_menu', 'Storage.com Settings Page', 'Settings', 'manage_options', 'sc_settings', 'sc_storage_settings_page');
    add_submenu_page('sc_storage_main_menu', 'Storage.com Storage Support Page', 'Support', 'manage_options', 'sc_support', 'sc_storage_support_page');
    
    add_action('admin_init', 'sc_storage_register_settings');   
}

function sc_storage_register_settings()
{
    register_setting('sc_storage_settings_group', 'sc_storage_options', 'sc_storage_sanitiize_options');
}

function sc_storage_sanitiize_options($input)
{
    $input['option_siteid'] = filter_var($input['option_siteid'],FILTER_SANITIZE_NUMBER_INT);
    $input['option_city'] = sanitize_text_field($input['option_city']);
    $input['option_state'] = sanitize_text_field($input['option_state']);
    $input['option_telephone'] = sanitize_text_field($input['option_telephone']);
    $input['option_latitude'] = sanitize_text_field($input['option_latitude']);
    $input['option_longitude'] = filter_var($input['option_longitude'],FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $input['option_radius'] = filter_var($input['option_radius'],FILTER_SANITIZE_NUMBER_INT);
    $input['option_ws_login'] = sanitize_text_field($input['option_ws_login']);
    $input['option_ws_password'] = sanitize_text_field($input['option_ws_password']);
    $input['option_email'] = sanitize_text_field($input['option_email']);
    $input['option_ws_url'] = sanitize_text_field($input['option_ws_url']);
    
    return $input;
}

function sc_storage_plugin_page()
{
?>
    <div class="wrap">
        <h2>Storage.com Main Page</h2>
    </div>
<?php
}
function sc_storage_settings_page()
{
?>
    <div class="wrap">
        <h2>Storage.com Settings Page</h2>
        <form method="post" action="options.php">
        <?php settings_fields('sc_storage_settings_group'); ?>
        <?php $sc_storage_options = get_option('sc_storage_options'); ?>
        <table class="form-table">
            <tr valign="top">
                 <th scope="row">Site ID:</th>
                <td><input type="text" name="sc_storage_options[option_siteid]" value="<?php echo $sc_storage_options['option_siteid']; ?> " </td></tr>
                <th scope="row">City:</th>
                <td><input type="text" name="sc_storage_options[option_city]" value="<?php echo $sc_storage_options['option_city']; ?> " </td></tr>
                <th scope="row">State:</th>
                <td><input type="text" name="sc_storage_options[option_state]" size="4" value="<?php echo $sc_storage_options['option_state']; ?> " </td></tr>
                <th scope="row">Telephone:</th>
                <td><input type="text" name="sc_storage_options[option_telephone]" value="<?php echo $sc_storage_options['option_telephone']; ?> " </td></tr>
                <th scope="row">Latitude:</th>
                <td><input type="text" name="sc_storage_options[option_latitude]" size="8" value="<?php echo $sc_storage_options['option_latitude']; ?> " </td></tr>
                <th scope="row">Longitude:</td>
                <td><input type="text" name="sc_storage_options[option_longitude]" size="8" value="<?php echo $sc_storage_options['option_longitude']; ?> " </td></tr>
                <th scope="row">Radius:</td>
                <td><input type="text" name="sc_storage_options[option_radius]" size="3" value="<?php echo $sc_storage_options['option_radius']; ?> " </td></tr>
                <th scope="row">Email:</td>
                <td><input type="text" name="sc_storage_options[option_email]" size="35" value="<?php echo esc_attr($sc_storage_options['option_email']); ?> " </td></tr>
                <th scope="row">Web Service Login:</td>
                <td><input type="text" name="sc_storage_options[option_ws_login]" size="35" value="<?php echo esc_attr($sc_storage_options['option_ws_login']); ?> " </td></tr>
                <th scope="row">Web Service Password:</td>
                <td><input type="text" name="sc_storage_options[option_ws_password]" size="35" value="<?php echo esc_attr($sc_storage_options['option_ws_password']); ?> " </td></tr>
                <th scope="row">Web Service URL:</td>
                <td><input type="text" name="sc_storage_options[option_ws_url]" size="35" value="<?php echo esc_attr($sc_storage_options['option_ws_url']); ?> " </td></tr>
        </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="Save Changes" />
            </p>
        </form>
    </div>
<?php
}
function sc_storage_support_page()
{
?>
    <div class="wrap">
        <h2>Storage.com Support Page</h2>
    </div>
<?php
}

// use widgets_init action hook to execute custom function
add_action( 'widgets_init', 'boj_widgetexample_register_widgets' );

 //register our widget
function boj_widgetexample_register_widgets() {
    register_widget( 'boj_widgetexample_widget_my_info' );
}

include_once 'widgets/MyInfoWidget.php';

add_action( 'widgets_init', 'facility_search_register_widgets' );

 //register our widget
function facility_search_register_widgets() {
    register_widget( 'facility_search' );
}

include_once 'widgets/facility_search.php';

add_action( 'widgets_init', 'facility_listing_register_widgets' );
include_once 'widgets/facility_listing.php';

 //register our widget
function facility_listing_register_widgets() {
    register_widget( 'facility_listing' );
}

// include models

include_once 'Models/SC_Search.php';
include_once 'Models/SC_Facilities.php';
include_once 'Models/SC_Facility.php';
include_once 'Models/SC_Costs.php';
include_once 'Models/SC_Reservation.php';
include_once 'Models/SC_Units.php';

// include shortcodes

include_once 'shortcodes/googleMapJQ.php';


// rewrite rules
//add_action('init', 'add_facility_rewrite_rules');
//function add_facility_rewrite_rules()
//{
//    add_rewrite_rule('facility/?([^/]*)', 'index.php?pagename=facility&facid=$matches[1]', 'top');
//    add_rewrite_rule('([0-9-]+)-self-storage/radius-([0-9-]+)', 'index.php?pagename=search-results&zip=$matches[1]&radius=$matches[2]', 'top');
//    add_rewrite_rule('([0-9|a-z|A-Z|\-]+)-self-storage/([a-z|A-Z|\-]+)-self-storage', 'index.php?pagename=search-results&city=$matches[1]&state=$matches[2]', 'top');
//}

// Add query vars
add_filter('query_vars', 'add_query_vars');
function add_query_vars( $vars )
{
    $vars[] = ('scid');
    $vars[] = ('sccity');
    $vars[] = ('scstate');
    $vars[] = ('scuid');
    $vars[] = ('scsizes');
    $vars[] = ('reserror');
    $vars[] = ('srchstring');
    
    return $vars;
}

// add scripts
//add_action('init', 'load_search_script');
//function load_search_script()
//{
// 
//    $jsurl = plugins_url("js/facility_search.js", __FILE__);
//    wp_enqueue_script('search-box', $jsurl, array( 'jquery' ));
//}

add_action('init', 'load_external_libraries');
function load_external_libraries()
{
    wp_register_script('jquery-validation-plugin', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js', array('jquery'));
    wp_enqueue_script('jquery-validation-plugin');
    wp_register_script('jquery-validation-plugin_additional', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js', array('jquery'));
    wp_enqueue_script('jquery-validation-plugin_additional');
}

add_action( 'init', 'location_session' );
function location_session () {
 global $wp_session;
 $wp_session = WP_Session::get_instance();
}



