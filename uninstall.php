<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://icanwp.com/plugins
 * @since      1.0.0
 *
 * @package    WP_Contents_Dynamic_Display
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

//Delete Global Data - Registered Options
$wpcdd_options = array(
	'settings_field_wpcdd_control_panel'
);

foreach( $wpcdd_options as $wpcdd_data ){
	delete_option( $wpcdd_data );
}

//Remove WPCDD Custom Posts
$wpcdd_arg = array(
'numberposts' => -1,
'order' => 'ASC',
'post_type' => 'wpcdd',
'post_status' => 'publish'
);
$wpcdd_settings = get_posts( $wpcdd_arg );

foreach( $wpcdd_settings as $setting ){
	$setting_id = intval( $setting->ID );
	wp_delete_post( $setting_id, true);
}
?>