<?php

/**
 * Fired during plugin activation
 *
 * @link       https://icanwp.com/plugins
 * @since      1.0.0
 *
 * @package    WP_Contents_Dynamic_Display
 * @subpackage WP_Contents_Dynamic_Display/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WP_Contents_Dynamic_Display
 * @subpackage WP_Contents_Dynamic_Display/includes
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class WP_Contents_Dynamic_Display_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		//flush rewrite rules to clear possible earlier activation of plugin
		flush_rewrite_rules();
	}
}
