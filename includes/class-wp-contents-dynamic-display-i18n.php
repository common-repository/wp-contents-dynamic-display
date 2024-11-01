<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://icanwp.com/plugins
 * @since      1.0.0
 *
 * @package    WP_Contents_Dynamic_Display
 * @subpackage WP_Contents_Dynamic_Display/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    WP_Contents_Dynamic_Display
 * @subpackage WP_Contents_Dynamic_Display/includes
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class WP_Contents_Dynamic_Display_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-contents-dynamic-display',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
