<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://icanwp.com/plugins
 * @since      1.0.0
 *
 * @package    WP_Contents_Dynamic_Display
 * @subpackage WP_Contents_Dynamic_Display/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Contents_Dynamic_Display
 * @subpackage WP_Contents_Dynamic_Display/admin
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class WP_Contents_Dynamic_Display_Admin {

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
	 * @param      string    $wp_contents_dynamic_display       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wp_contents_dynamic_display, $version ) {

		$this->wp_contents_dynamic_display = $wp_contents_dynamic_display;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->wp_contents_dynamic_display, plugin_dir_url( __FILE__ ) . 'css/wp-contents-dynamic-display-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->wp_contents_dynamic_display . '-jquery-ui-style-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->wp_contents_dynamic_display . '-jquery-ui-structure-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.structure.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->wp_contents_dynamic_display . '-jquery-ui-theme-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.theme.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->wp_contents_dynamic_display . '-font-awesome-css', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->wp_contents_dynamic_display . '-sol-css', plugin_dir_url( __FILE__ ) . 'css/sol.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_register_script( $this->wp_contents_dynamic_display . '-admin-js', plugin_dir_url( __FILE__ ) . 'js/wp-contents-dynamic-display-admin.js', array( 'jquery','jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-sortable', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-widget' ), $this->version, false );
		
		$wpcdd_data = $this->get_wpcdd_data();
		
		wp_localize_script( $this->wp_contents_dynamic_display . '-admin-js', 'wpcdd_localized', $wpcdd_data );
		
		wp_enqueue_script( $this->wp_contents_dynamic_display . '-admin-js' );
		
		// CREDIT to https://github.com/pbauerochse/searchable-option-list for Searchable Option List jQuery plugin
		wp_enqueue_script( $this->wp_contents_dynamic_display . '-sol-js', plugin_dir_url( __FILE__ ) . 'js/sol.js', array( 'jquery' ), $this->version, false );
		
	}
	protected function get_wpcdd_data(){
		$wpcdd_page_templates = get_page_templates();
		$wpcdd_post_categories = get_categories();
		$wpcdd_posts = get_posts();
		$wpcdd_pages = get_pages();
		
		$arr_posts = array();
		foreach( $wpcdd_posts as $post ){
			$arr_posts[ $post->ID ] = $post->post_title; 
		}
		
		$arr_pages = array();
		$arr_pages['home'] = 'Homepage (Front Page)';
		foreach( $wpcdd_pages as $page ){
			$arr_pages[$page->ID] = $page->post_title;
		}
		
		$arr_post_cat = array();
		foreach( $wpcdd_post_categories as $category ){
			$arr_post_cat[$category->cat_ID] = $category->cat_name;
		}
		
		$arr_page_templates = array();
		foreach( $wpcdd_page_templates as $template_name => $template_filename ){
			$arr_page_templates[$template_filename] = $template_name;
		}
		
		$arr_wpcdd_data = array(
			$arr_posts,
			$arr_post_cat,
			$arr_pages,
			$arr_page_templates
		);

		return $arr_wpcdd_data;
	}
	
	public function wpcdd_add_admin_menu(){
		add_menu_page(
			'WP Contents Dynamic Display', // The title to be displayed on this menu's corresponding page
			'Dynamic Contents', // The text to be displayed for this actual menu item
			'manage_options', // Which type of users can see this menu
			'wpcdd_admin_menu', // The unique ID - that is, the slug - for this menu item
			array($this, 'display_admin_menu_wpcdd'), // The name of the function to call when rendering this menu's page
			plugin_dir_url( __FILE__ ) . 'assets/admin-icon.png', // icon url
			110.139 // position
		);
		add_submenu_page(
			'wpcdd_admin_menu',
			'WordPress Contents Dynamic Display Control Panel',
			'Control Panel',
			'manage_options',
			'wpcdd_admin_menu_control_panel',
			array( $this, 'display_admin_menu_control_panel' )
		);
		add_submenu_page(
			'wpcdd_admin_menu',
			'Instructions',
			'Instructions',
			'manage_options',
			'wpcdd_admin_menu_instruction',
			array( $this, 'display_admin_menu_instruction' )
		);
	}
	
	public function wpcdd_init_options(){
		add_settings_section(
			'settings_section_wpcdd_control_panel',
			'Control Panel',
			array( $this, 'callback_section_wpcdd_control_panel' ),
			'wpcdd_admin_menu_control_panel'
		);
		add_settings_field(
			'settings_field_wpcdd_control_panel',
			'Global Settings',
			array( $this, 'callback_field_wpcdd_control_panel' ),
			'wpcdd_admin_menu_control_panel',
			'settings_section_wpcdd_control_panel',
			array( 'Control Panel for global features and options' )			
		);
		register_setting(
			'wpcdd_admin_menu_control_panel',
			'settings_field_wpcdd_control_panel'
		);
	}
	
	public function wpcdd_notice_php_version_critical( $option ){
		$notice = '<div class="notice notice-error is-dismissible wpcdd-notice-error"><p>
		<strong>Your PHP Version ' . phpversion() . '	is <a href="http://php.net/supported-versions.php" target="_blank">out of support</a></strong> and there could be <a href="https://www.cvedetails.com/vulnerability-list/vendor_id-74/product_id-128/PHP-PHP.html" target="_blank">serious security issues</a>. We strongly recommend that you upgrade your PHP version. If security and performance of your website is important, please checkout the <a href="https://icanwp.com/_link?a=we" target="_blank">Managed WordPress Hosting</a> we recommend.</p></div>';
		echo $notice;
	}
	public function wpcdd_admin_notice( $msg ){
		echo $msg;
	}
	
	public function callback_field_wpcdd_control_panel( $options ){
		require_once('partials/settings-field-wpcdd-control-panel.php');
		return false;
	}
	
	public function callback_section_wpcdd_control_panel( $arg ){
		require_once('partials/settings-section-wpcdd-control-panel.php');
		return false;
	}
	
	public function display_admin_menu_control_panel(){
		require_once('partials/wp-contents-dynamic-display-admin-control-panel.php');
		return false;
	}
	
	public function display_admin_menu_instruction(){
		require_once('partials/wp-contents-dynamic-display-admin-instruction.php');
		return false;
	}
	
	public function display_admin_menu_wpcdd(){
		return false; // main display will be overriden by a custom post type
	}
	
	public function wpcdd_register_custom_post_type(){
		$labels = array(
			'name'               => 'WP Contents Dynamic Display',
			'singular_name'      => 'WP Contents Dynamic Display',
			'menu_name'          => 'Dynamic Contents',
			'name_admin_bar'     => 'Dynamic Contents',
			'add_new'            => 'Make New Dynamic Contents',
			'add_new_item'       => 'Make New Dynamic Contents',
			'new_item'           => 'New Dynamic Contents',
			'edit_item'          => 'Edit Dynamic Contents',
			'view_item'          => 'View Dynamic Contents',
			'all_items'          => 'All Dynamic Contents',
			'search_items'       => 'Search Dynamic Contents',
			'parent_item_colon'  => 'Parent Dynamic Contents',
			'not_found'          => 'No Dynamic Contents Found',
			'not_found_in_trash' => 'No Dynamic Contents Found in Trash.'
		);

		$args = array(
			'labels'             => $labels,
			'description'        => 'WP Contents Dynamic Display',
			'public'             => true,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'wpcdd_admin_menu',
			'menu_position'			=> 20.17,
			'query_var'          => false,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => array( 'title' )
		);

		register_post_type( 'wpcdd', $args );
	}
	
	// Create custom column to display shortcode
	public function wpcdd_add_custom_column_title( $columns ){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Dynamic Content Name',
			'postid' =>'ID',
			'shortcode' => 'Shortcode',
			'date' => 'Date'
		);
		return $columns;
	}
	public function wpcdd_add_custom_column_data( $column, $post_id ){
		switch( $column ){
			case 'shortcode' :
				echo '<input class="wpcdd-shortcode-select" type="text" value="[dynamic-contents id=&quot;' . $post_id . '&quot;]" size="25" readonly>';
				break;
			case 'postid' :
				echo $post_id;
				break;
		}
	}
	public function wpcdd_add_meta_boxes( $post_type ){
		add_meta_box(
			'wpcdd_rules', 
			'WP Contents Dynamic Display Rules', 
			array($this, 'callback_wpcdd_rules_metabox'),
			'wpcdd',
			'normal',
			'high'
		);

		add_meta_box(
			'wpcdd_shortcode',
			'WP Contents Dynamic Display Shortcode',
			array( $this, 'callback_wpcdd_shortcode_metabox' ),
			'wpcdd',
			'side',
			'default'
		);
	}
	
	public function wpcdd_save_meta_boxes ( $post_id ){
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			die("You do not have sufficient previlliege to edit the post.");
		}
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		if ( isset($_POST['wpcdd']) ) {
			$result = $_POST['wpcdd'];
			//die( '<pre>' . print_r($result, true) . '</pre>');
			update_post_meta( $post_id, '_wpcdd', $result );
		}
		if ( isset($_POST['wpcdd_default']) ) {
			$result = $_POST['wpcdd_default'];
			//die( print_r($result));
			update_post_meta( $post_id, '_wpcdd_default', $result );
		}
	}

	public function callback_wpcdd_rules_metabox( $post ){
		require_once('partials/wp-contents-dynamic-display-rules-display.php');
		return false;
	}
	
	public function callback_wpcdd_shortcode_metabox( $post ){
		require_once('partials/wp-contents-dynamic-display-shortcode-display.php');
		return false;
	}
}
