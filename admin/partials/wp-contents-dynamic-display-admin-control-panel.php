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
?>
<form id="wpcdd-control-panel-options" method="post" action="options.php"> 
<?php 
	settings_fields( 'wpcdd_admin_menu_control_panel' );
	do_settings_sections( 'wpcdd_admin_menu_control_panel' ); 
	submit_button(); 
?>
</form>