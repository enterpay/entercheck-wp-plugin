<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://demoshop.entercheck.eu/
 * @since      1.0.0
 *
 * @package    Entercheck_Company_Search
 * @subpackage Entercheck_Company_Search/includes
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Entercheck_Company_Search
 * @subpackage Entercheck_Company_Search/includes
 * @author     Entercheck <support@entercheck.eu>
 */
class Entercheck_Company_Search {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Entercheck_Company_Search_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ENTERCHECK_COMPANY_SEARCH_VERSION' ) ) {
			$this->version = ENTERCHECK_COMPANY_SEARCH_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'entercheck-company-search';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_options();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Entercheck_Company_Search_Loader. Orchestrates the hooks of the plugin.
	 * - Entercheck_Company_Search_i18n. Defines internationalization functionality.
	 * - Entercheck_Company_Search_Admin. Defines all hooks for the admin area.
	 * - Entercheck_Company_Search_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-entercheck-company-search-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-entercheck-company-search-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-entercheck-company-search-public.php';

		$this->loader = new Entercheck_Company_Search_Loader();

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Entercheck_Company_Search_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu' );
		
		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_register_settings' );	

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Entercheck_Company_Search_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'wp_ajax_search_company', $plugin_public, 'search_company' );
		$this->loader->add_action( 'wp_ajax_nopriv_search_company', $plugin_public, 'search_company' );

		$this->loader->add_action( 'wp_ajax_company_detail', $plugin_public, 'get_company_detail' );
		$this->loader->add_action( 'wp_ajax_nopriv_company_detail', $plugin_public, 'get_company_detail' );
		////$this->loader->add_action( 'woocommerce_register_form_start', $plugin_public, 'woocommerce_register_form_data');
		////$this->loader->add_action( 'woocommerce_register_form', $plugin_public, 'woocommerce_register_form_data_pass');
		$this->loader->add_action( 'woocommerce_created_customer', $plugin_public, 'woocommerce_created_customer_data');
		////$this->loader->add_action( 'woocommerce_registration_errors', $plugin_public, 'wooc_extra_register_fields_validation');
		$this->loader->add_action( 'user_register', $plugin_public, 'request_after_registration_submission', 10, 1 );
		$this->loader->add_action( 'gform_user_registered', $plugin_public, 'request_after_registration_submission', 10, 1 );
		//$this->loader->add_action( 'template_redirect', $plugin_public, 'request_after_submission_form' );
		$this->loader->add_action( 'init', $plugin_public, 'request_after_submission_form', 1 );
		$this->loader->add_action( 'woocommerce_register_post', $plugin_public, 'woocommerce_register_post_customer', 10, 3  );
		
		////$this->loader->add_action( 'woocommerce_before_checkout_billing_form', $plugin_public, 'custom_checkout_field_select' );
		
		$this->loader->add_action( 'woocommerce_checkout_create_order', $plugin_public, 'entercheck_save_custom_checkout_fields' );
		$this->loader->add_action( 'woocommerce_new_order', $plugin_public, 'entercheck_save_custom_fields_to_user_meta' );

		//$this->loader->add_shortcode( 'company_search_form', $plugin_public, 'company_search_form_render' );
		
		////$this->loader->add_filter( 'woocommerce_save_account_details_required_fields', $plugin_public, 'woocommerce_save_account_details_required_fields_custom' );
		////$this->loader->add_filter( 'woocommerce_billing_fields', $plugin_public, 'custom_woocommerce_billing_fields' );
		////$this->loader->add_filter("woocommerce_checkout_fields", $plugin_public, "custom_override_checkout_fields");

		////$this->loader->add_filter( 'woocommerce_checkout_posted_data', $plugin_public, 'update_billing_phone_requirement' );

		////$this->loader->add_filter("woocommerce_get_price_html", $plugin_public, "bbloomer_hide_price_addcart_not_logged_in",10,2);
		
		
	}
	
	private function define_options(){
		$options_fields = get_option('entercheck_plugin_options_fields');		
		if ($options_fields === false || !is_array($options_fields)){
			$options_fields = [];
			update_option('entercheck_plugin_options_fields', $options_fields, false);
		}
		
		$options = get_option('entercheck_plugin_options');		
		if ($options === false || !is_array($options)){
			$options = [];
			update_option('entercheck_plugin_options', $options, false);
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Entercheck_Company_Search_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
