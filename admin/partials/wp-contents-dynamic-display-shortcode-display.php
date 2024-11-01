<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/*
 * @link       https://icanwp.com/plugins/portfolio-gallery/
 * @since      1.0.0
 *
 * @package    WP_Post_Ticker_Pro
 * @subpackage WP_Post_Ticker_Pro/admin/partials
 */
 ?>
<h4 style="margin-bottom:0;">Copy and Paste the Following Shortcode</h4>
<?php
	$wpcdd_id = get_the_ID();
	if ( get_post_status( $wpcdd_id ) == 'publish' ) {
		echo '<input class="wpcdd-shortcode-select" type="text" value="[dynamic-contents id=&quot;' . $wpcdd_id . '&quot;]" size="30" readonly>';
		echo '<br /><h4 style="margin-bottom:0;">Use the following for editing php file</h4>';
		echo '<input class="wpcdd-shortcode-select" type="text" value="echo do_shortcode( &#39;[dynamic-contents id=&quot;' . $wpcdd_id . '&quot;]&#39; );" size="30" readonly>';
		echo '<br />(If you are pasting into the html section, please wrap the above code in <strong>&lt;?php</strong> [above code] <strong>?&gt</strong>)';
	} else {
		echo '<div class="wpcdd-warning">Please publish this setting to see the shortcode.</div>';
	}
?>