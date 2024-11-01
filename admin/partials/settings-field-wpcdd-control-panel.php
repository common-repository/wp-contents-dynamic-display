<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 *
 * @link       https://icanwp.com/plugins/portfolio-gallery/
 * @since      1.0.0
 *
 * @package    iCanWP_Portfolio_Gallery
 * @subpackage iCanWP_Portfolio_Gallery/admin/partials
 */
 $wpcdd_cp_options = get_option( 'settings_field_wpcdd_control_panel' );
 $wpcdd_txt_shortcode = isset( $wpcdd_cp_options['shortcode'] ) ? $wpcdd_cp_options['shortcode'] : '0';
?>
<div id="wpcdd-control-panel">
	<div class="wpcdd-cp-option">
		<label>Use shortcode from text widget <input type="checkbox" class="wpcdd-cp-checkbox" name="settings_field_wpcdd_control_panel[shortcode]" value="1" <?php checked( 1, $wpcdd_txt_shortcode, true ); ?> /></label>
	</div>
</div>