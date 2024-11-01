<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://icanwp.com/plugins
 * @since      1.0.0
 *
 * @package    WP_Contents_Dynamic_Display
 * @subpackage WP_Contents_Dynamic_Display/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Contents_Dynamic_Display
 * @subpackage WP_Contents_Dynamic_Display/public
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class WP_Contents_Dynamic_Display_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wp_contents_dynamic_display    The ID of this plugin.
	 */
	private $wp_contents_dynamic_display;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wp_contents_dynamic_display       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wp_contents_dynamic_display, $version ) {

		$this->wp_contents_dynamic_display = $wp_contents_dynamic_display;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Contents_Dynamic_Display_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Contents_Dynamic_Display_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->wp_contents_dynamic_display, plugin_dir_url( __FILE__ ) . 'css/wp-contents-dynamic-display-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Contents_Dynamic_Display_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Contents_Dynamic_Display_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->wp_contents_dynamic_display, plugin_dir_url( __FILE__ ) . 'js/wp-contents-dynamic-display-public.js', array( 'jquery' ), $this->version, false );

	}
	
	public function wpcdd_register_shortcode(){
		add_shortcode( 'dynamic-contents', array( $this, 'wpcdd_shortcode' ) );
	}
	
	protected function wpcdd_get_display( $type, $bool, $terms ){
		$is_condition = false;
		if( $type == 'page' ){
			if( empty( $terms ) ){
				$is_condition = is_page();
			} elseif( $terms[0] == 'home' ){
				$is_condition = is_front_page();
				if( !$is_condition ){
					array_shift( $terms );
					if( !empty( $terms ) ){
						$is_condition = is_page( $terms );
					}
				}
			} else {
				$is_condition = is_page( $terms );
			}
		} elseif( $type == 'page-template' ){
			if( empty( $terms ) ){
				$is_condition = is_page_template();
			} else {
				$is_condition = is_page_template( $terms );
			}
		} elseif ( $type == 'post' ){
			if( empty( $terms ) ){
				$is_condition = is_single();
			} else {
				$is_condition = is_single( $terms );
			}
		} elseif ( $type == 'post-category' ){
			if( empty( $terms ) ){
				$is_condition = is_category();
			} else {
				$is_condition = is_category( $terms );
			}
		}
		
		if ( $bool == 'is' ){
			return $is_condition;
		} else{
			return !$is_condition;
		}
	}
	
	public function wpcdd_shortcode( $atts ){
		$atts = shortcode_atts( 
			array(
				'id' => 'default'
			), $atts, 'wp_contents_dynamic_display' 
		);
		$wpcdd_id = $atts['id'];
		$wpcdd_data = get_post_meta( $wpcdd_id, '_wpcdd', false );
		$wpcdd_data = $wpcdd_data['0'];
		$wpcdd_default = get_post_meta( $wpcdd_id, '_wpcdd_default', false );
		$wpcdd_default = $wpcdd_default['0'];
		$output = $wpcdd_default['content']['value'];
		
		//return '<pre>' . print_r( $wpcdd_data, true ) . '</pre><br /><br /><pre>' . print_r( $wpcdd_default, true ) . '</pre>';
		
		foreach( $wpcdd_data as $key => $rule ){
			$type = $rule['condition']['type'];
			$bool = $rule['condition']['bool'];
			$terms = $rule['condition']['terms']; // this should be an array
			
			$wpcdd_rule_id = $this->wpcdd_get_display( $type, $bool, $terms );
			
			if( $wpcdd_rule_id !== false ){
				$output = $rule['content']['value'];
				break;
			}
		}

		return $output;
	}
}
