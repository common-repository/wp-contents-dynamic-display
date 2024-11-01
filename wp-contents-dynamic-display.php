<?php

/**
 *
 * @link              https://icanwp.com/plugins/
 * @since             1.0.0
 * @package           WP_Contents_Dynamic_Display
 *
 * @wordpress-plugin
 * Plugin Name:       WP Contents Dynamic Display
 * Plugin URI:        https://icanwp.com/plugins/
 * Description:       WP Contents Dynamic Display allows users to create variations of contents that gets displayed based on codition. Users can also use it to manage a content from a single location that needs frequent update or needs update from many different places. One example is to display phone number for tech support page and sales phone on contact page through a single short code embeded on a sidebar text widget or anywhere in the content area.
 * Version:           1.0.1
 * Author:            iCanWP Team, Sean Roh, Chris Couweleers
 * Author URI:        https://icanwp.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-contents-dynamic-display
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-contents-dynamic-display-activator.php
 */
function activate_wp_contents_dynamic_display() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-contents-dynamic-display-activator.php';
	WP_Contents_Dynamic_Display_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-contents-dynamic-display-deactivator.php
 */
function deactivate_wp_contents_dynamic_display() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-contents-dynamic-display-deactivator.php';
	WP_Contents_Dynamic_Display_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_contents_dynamic_display' );
register_deactivation_hook( __FILE__, 'deactivate_wp_contents_dynamic_display' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-contents-dynamic-display.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_contents_dynamic_display() {

	$plugin = new WP_Contents_Dynamic_Display();
	$plugin->run();

}
run_wp_contents_dynamic_display();
