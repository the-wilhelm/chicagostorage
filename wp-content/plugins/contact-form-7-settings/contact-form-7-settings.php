<?php
/*
Plugin Name: Contact Form 7 Settings
Description: Change Contact Form 7 constants settings
Version: 0.0.1
*/

function my_plugin_load_first()
{
	$path = 'contact-form-7-settings/contact-form-7-settings.php';
	if ( $plugins = get_option( 'active_plugins' ) ) {
		if ( $key = array_search( $path, $plugins ) ) {
			array_splice( $plugins, $key, 1 );
			array_unshift( $plugins, $path );
			update_option( 'active_plugins', $plugins );
		}
	}
}
add_action( 'activated_plugin', 'my_plugin_load_first' );

include('contact-form-7-settings-config.php');

    // constant activate
    foreach($wpcf7_options as $option){        
        if ( ! defined( $option[0] ) ){
            $current_option = get_option($option[1]);
            if($current_option == 'on'){
                define( $option[0], true );
            }else{
                define( $option[0], false );
            }
        }
    }


add_action('admin_menu', 'wpautop_control_menu');
function wpautop_control_menu() {
    add_submenu_page( 'wpcf7',
                    __( 'Contact Forms Settings', 'wpcf7' ), __( 'Settings', 'wpcf7' ),
                    'wpcf7_read_contact_forms', 'wpcf7_settings', 'wpcf7_settings_page' );
}
function wpcf7_settings_page(){
        
    include('contact-form-7-settings-config.php');
    
    // Options update
    if($_POST['save'] == 'Save changes'){
        foreach($wpcf7_options as $option){
            if( $_POST[$option[1]] ==  'on'){
                update_option( $option[1], 'on' );
            }else{
                update_option( $option[1], 'off' );
            }
        }
    }
    
    // Settings page
    ?>
    <div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div><h2><?php echo __( 'Contact Form 7 Settings', 'wpcf7_settings'); ?></h2>
        <form id="mainform" enctype="multipart/form-data" action="" method="post">
        <table>
        <tr>
            <td></td>
            <td><b><?php echo __( 'Constant', 'wpcf7_settings'); ?></b></td>
            <td><b><?php echo __( 'Description', 'wpcf7_settings'); ?></b></td>
        </tr>
        <?php    
        
            foreach($wpcf7_options as $option){
                if( !$current_option = get_option($option[1]) ){
                    add_option($option[1], $option[2], '', 'yes');
                }
                if($current_option == 'on'){
                    $checked = ' checked="checked"';
                }else{
                    $checked = '';
                }
                ?>
                <tr>
                    <td><input type="checkbox" name="<?php echo $option[1]; ?>" <?php echo $checked; ?>></td>
                    <td><?php echo $option[0]; ?></td>
                    <td><?php echo $option[3]; ?></td>
                </tr>
                <?php 
            }
        ?>
        </table>
        <br /><br />
        <input class="button-primary" type="submit" value="<?php echo __( 'Save changes', 'wpcf7_settings'); ?>" name="save">
        </form>
    </div>
    <?php  
        return true;
}
?>