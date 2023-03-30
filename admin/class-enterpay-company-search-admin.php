<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://demoshop.entercheck.eu/
 * @since      1.0.0
 *
 * @package    Enterpay_Company_Search
 * @subpackage Enterpay_Company_Search/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Enterpay_Company_Search
 * @subpackage Enterpay_Company_Search/admin
 * @author     Ha Nguyen <nd.dungha@gmail.com>
 */
class Enterpay_Company_Search_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
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
		 * defined in Enterpay_Company_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Enterpay_Company_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/enterpay-company-search-admin.css', array(), $this->version, 'all' );

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
		 * defined in Enterpay_Company_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Enterpay_Company_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/enterpay-company-search-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the menu for the admin area.
	 *
	 * @since    1.0.0
	 */
	
	
	

	public function add_menu(){
        // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        add_menu_page( "Enterpay", "Enterpay", 'manage_options', $this->plugin_name . '-enterpay', array( $this, 'page_enterpay_admin' ));
    }

    public function page_enterpay_admin() {
        include( plugin_dir_path( __FILE__ ) . 'partials/enterpay-company-search-admin-display.php' );
    }

    public function admin_register_settings(){
		
	    register_setting( 'dbi_example_plugin_options', 'dbi_example_plugin_options', 'dbi_example_plugin_options_validate' );
	    
	    add_settings_section( 'api_settings', 'API Credentials', 'dbi_plugin_section_text', 'dbi_example_plugin' );

	    add_settings_field( 'dbi_plugin_setting_username', 'Username', 'dbi_plugin_setting_username', 'dbi_example_plugin', 'api_settings' );
	    add_settings_field( 'dbi_plugin_setting_password', 'Password', 'dbi_plugin_setting_password', 'dbi_example_plugin', 'api_settings' );

	    add_settings_field( 'dbi_plugin_setting_enterpaytoken', 'Token', 'dbi_plugin_setting_enterpaytoken', 'dbi_example_plugin', 'api_settings' );
	 
	}

	

	

	

}
