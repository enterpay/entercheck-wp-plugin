<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://demoshop.entercheck.eu/
 * @since      1.0.0
 *
 * @package    Enterpay_Company_Search
 * @subpackage Enterpay_Company_Search/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Enterpay_Company_Search
 * @subpackage Enterpay_Company_Search/public
 * @author     Ha Nguyen <nd.dungha@gmail.com>
 */
class Enterpay_Company_Search_Public
{

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
	 * The domain API.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $api_domain;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		$options = get_option('enterpay_plugin_options');
		if (!isset($options['environment']) || empty($options['environment']) || $options['environment'] == 'test') { 
			$this->api_domain = "api.test.entercheck.eu"; 
		} else {
			$this->api_domain = "api.entercheck.eu";
		}		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

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


		//wp_register_style($this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/enterpay-company-search-public.css', array(), $this->version, 'all' );
		wp_enqueue_style($this->plugin_name . "-CSS", plugin_dir_url(__FILE__) . 'css/enterpay-company-search-public.css', array(), $this->version, 'all');


		wp_enqueue_style($this->plugin_name . "-ISO-BOOTSTRAP", plugin_dir_url(__FILE__) . 'css/iso_bootstrap4.0.0min.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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


		//typeahead.bundle.js"
		wp_enqueue_script("typeahead", plugin_dir_url(__FILE__) . 'js/typeahead/typeahead.bundle.js', array('jquery'), $this->version, false);


		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/enterpay-company-search-public.js', array('jquery'), $this->version, false);

		$options = get_option('enterpay_plugin_options_fields');

		$variables = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'company_name_name' => isset($options['company_name']['name']) ? $options['company_name']['name'] : 'billing_company',
			'company_name_id' => isset($options['company_name']['id']) ? str_ireplace(',', ', #', $options['company_name']['id']) : 'billing_company',
			'company_name_tootltip' => isset($options['company_name']['tooltip']) ? $options['company_name']['tooltip'] : 'Search for your company details by typing a search phrase to the box',
			'vat_number_name' => isset($options['vat_number']['name']) ? $options['vat_number']['name'] : 'inputVATNumber',
			'vat_number_id' => isset($options['vat_number']['id']) ? str_ireplace(',', ', #', $options['vat_number']['id']) : 'inputVATNumber',
			'business_id_name' => isset($options['business_id']['name']) ? $options['business_id']['name'] : 'inputBusinessId',
			'business_id_id' => isset($options['business_id']['id']) ? str_ireplace(',', ', #', $options['business_id']['id']) : 'inputBusinessId',
			'business_line_name' => isset($options['business_line']['name']) ? $options['business_line']['name'] : 'companyBusinessLine',
			'business_line_id' => isset($options['business_line']['id']) ? str_ireplace(',', ', #', $options['business_line']['id']) : 'companyBusinessLine',
			
			'country_name' => isset($options['country']['name']) ? $options['country']['name'] : 'billing_country',
			'country_id' => isset($options['country']['id']) ? str_ireplace(',', ', #', $options['country']['id']) : 'billing_country',
			'city_name' => isset($options['city']['name']) ? $options['city']['name'] : 'billing_city',
			'city_id' => isset($options['city']['id']) ? str_ireplace(',', ', #', $options['city']['id']) : 'billing_city',
			'street_name' => isset($options['street']['name']) ? $options['street']['name'] : 'billing_address_1',
			'street_id' => isset($options['street']['id']) ? str_ireplace(',', ', #', $options['street']['id']) : 'billing_address_1',
			'street_second_name' => isset($options['street_second']['name']) ? $options['street_second']['name'] : 'billing_address_2',
			'street_second_id' => isset($options['street_second']['id']) ? str_ireplace(',', ', #', $options['street_second']['id']) : 'billing_address_2',
			'postal_code_name' => isset($options['postal_code']['name']) ? $options['postal_code']['name'] : 'billing_postcode',
			'postal_code_id' => isset($options['postal_code']['id']) ? str_ireplace(',', ', #', $options['postal_code']['id']) : 'billing_postcode',
		);
		wp_localize_script($this->plugin_name, "enterpayjs", $variables);
	}

	public function auth()
	{
		$curl = curl_init();
		$options = get_option('enterpay_plugin_options');

		$data = array(
			"username" => $options['username'],
			"password" => $options['password']
		);
		$data = json_encode($data);
		$options = array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://'.$this->api_domain.'/v1/auth',
			CURLOPT_POST => true,
			CURLOPT_USERAGENT => "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)",
			CURLOPT_POSTFIELDS => $data
		);

		curl_setopt_array($curl, $options);
		curl_setopt(
			$curl,
			CURLOPT_HTTPHEADER,
			array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data)
			)
		);

		$resp = curl_exec($curl);

		if ($resp) {
			$token = json_decode($resp)->token;
			if ($token) {
				update_option('enterpay_token', $token);
			}
		}
	}

	public function send_API_request($endpoint_url, $method)
	{
		$token_str = get_option('enterpay_token');

		$ch = curl_init($endpoint_url);

		// Returns the data/output as a string instead of raw data
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

		//Set your auth headers
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token_str
		));

		// get stringified data/output. See CURLOPT_RETURNTRANSFER
		$data = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		// close curl resource to free up system resources
		curl_close($ch);

		//check the token 

		if ($http_code == 401 || $http_code == '401') {
			//auth again
			$this->auth();
			return $this->send_API_request($endpoint_url, $method);
		}

		return $data;
	}

	public function search_company()
	{
		$name = urlencode($_REQUEST["name"]);
		$country_code = 'FI';

		$endpoint_url = "https://".$this->api_domain."/company/search?country=" . $country_code . "&name=" . $name;
		$data = $this->send_API_request($endpoint_url, "GET");
				
		print_r($data);
		die();
	}

	public function get_company_detail($is_return = false)
	{
		$bid = $_REQUEST["bid"];
		$country_code = 'FI';
		$endpoint_url = "https://".$this->api_domain."/company/details?country=" . $country_code . "&id=" . $bid;
		$data = $this->send_API_request($endpoint_url, "GET");

		if ($is_return)
			return $data;

		print_r($data);
		die();
	}

	public function company_search_form_render()
	{
		// ob_start();
		// include(plugin_dir_path(__FILE__) . 'partials/form-shortcode.php');
		// return ob_get_clean();		
	}

	function woocommerce_register_post_customer($username, $email, $errors)
	{
		$options  = get_option( 'enterpay_plugin_options_fields', array() ); 

		if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name'])) {
			$errors->add('billing_first_name_error', __('First name is required!'));
		}
		if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name'])) {
			$errors->add('billing_last_name_error', __('Last name is required!'));
		}
		//if (!empty($_POST['billing_company'] && $_POST['billing_company'] != 'consumer')) {
			
			$field_names = isset($options['company_name']['name']) ? explode(",", $options['company_name']['name']) : ['billing_company'];		
			foreach ($field_names as $field_name){		
				if (isset($_POST[$field_name]) && empty($_POST[$field_name])) {
					$errors->add('billing_last_name_error', __('Company name is required!'));
					break;
				}
			}
			
			$field_names = isset($options['business_id']['name']) ? explode(",", $options['business_id']['name']) : ['inputBusinessId'];		
			foreach ($field_names as $field_name){		
				if (isset($_POST[$field_name]) && empty($_POST[$field_name])) {
					$errors->add('billing_last_name_error', __('Business ID is required!'));
					break;
				}
			}
			
			$field_names = isset($options['vat_number']['name']) ? explode(",", $options['vat_number']['name']) : ['inputVATNumber'];		
			foreach ($field_names as $field_name){		
				if (isset($_POST[$field_name]) && empty($_POST[$field_name])) {
					$errors->add('billing_last_name_error', __('VAT NUMBER is required!'));
					break;
				}
			}
		//}
		
		$field_names = isset($options['street']['name']) ? explode(",", $options['street']['name']) : ['billing_address_1'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name]) && empty($_POST[$field_name])) {
				$errors->add('billing_last_name_error', __('Company address is required!'));
				break;
			}
		}
		
		$field_names = isset($options['postal_code']['name']) ? explode(",", $options['postal_code']['name']) : ['billing_postcode'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name]) && empty($_POST[$field_name])) {
				$errors->add('billing_last_name_error', __('Postcode is required!'));
				break;
			}
		}
		
		$field_names = isset($options['city']['name']) ? explode(",", $options['city']['name']) : ['billing_city'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name]) && empty($_POST[$field_name])) {
				$errors->add('billing_last_name_error', __('City is required!'));
				break;
			}
		}
		
		
		
		if (isset($_POST['email']) && empty($_POST['email'])) {
			$errors->add('billing_last_name_error', __('Email address is required!'));
		}
		if (isset($_POST['password']) && empty($_POST['password'])) {
			$errors->add('billing_last_name_error', __('Password is required!'));
		}
		return $errors;
	}

	function woocommerce_created_customer_data($customer_id)
	{
		$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
		
		// save to database
		if (isset($_POST['billing_first_name'])) {
			update_user_meta($customer_id, 'billing_first_name', wc_clean($_POST['billing_first_name']));
		}
		if (isset($_POST['billing_last_name'])) {
			update_user_meta($customer_id, 'billing_last_name', wc_clean($_POST['billing_last_name']));
		}
		
		
		
		$field_names = isset($options['company_name']['name']) ? explode(",", $options['company_name']['name']) : ['billing_company'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name])) {
				update_user_meta($customer_id, 'billing_company', wc_clean($_POST[$field_name]));
				break;
			}
		}
		
		$field_names = isset($options['business_id']['name']) ? explode(",", $options['business_id']['name']) : ['bizid'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name])) {
				update_user_meta($customer_id, 'bizid', wc_clean($_POST[$field_name]));
				break;
			}
		}
		
		$field_names = isset($options['vat_number']['name']) ? explode(",", $options['vat_number']['name']) : ['vat'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name])) {
				update_user_meta($customer_id, 'vat', wc_clean($_POST[$field_name]));
				break;
			}
		}
		
		$field_names = isset($options['street']['name']) ? explode(",", $options['street']['name']) : ['billing_address_1'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name])) {
				update_user_meta($customer_id, 'billing_address_1', wc_clean($_POST[$field_name]));
				break;
			}
		}
		
		$field_names = isset($options['postal_code']['name']) ? explode(",", $options['postal_code']['name']) : ['billing_postcode'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name])) {
				update_user_meta($customer_id, 'billing_postcode', wc_clean($_POST[$field_name]));
				break;
			}
		}
		
		$field_names = isset($options['city']['name']) ? explode(",", $options['city']['name']) : ['billing_city'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name])) {
				update_user_meta($customer_id, 'billing_city', wc_clean($_POST[$field_name]));
				break;
			}
		}
		
		if (isset($_POST['company_info'])) {
			update_user_meta($customer_id, 'company_info', wc_clean($_POST['company_info']));
		}
	}

	function request_after_registration_submission($user_id)
	{
		$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
		
		$field_names = isset($options['business_id']['name']) ? explode(",", $options['business_id']['name']) : ['bizid'];
		
		foreach ($field_names as $field_name){
			if (isset($_REQUEST[$field_name])) {
				$business_id =  $_REQUEST[$field_name];
				$endpoint_url = 'https://'.$this->api_domain.'/v2/decision/company/base?businessId=' . $business_id . '&country=FI&refresh=true';
				$data =	$this->send_API_request($endpoint_url, "GET");
				update_user_meta($user_id, 'company_base', $data);
				
				$_REQUEST['bid'] = $business_id;				
				$data = $this->get_company_detail(true);
				if (!empty($data)) {
					update_user_meta($user_id, 'company_info', sanitize_text_field($data));
				}
				
				break;
			}
		}
	}
	
	function request_after_submission_form()
	{		
		$options  = get_option( 'enterpay_plugin_options_fields', array() ); 		
		$field_names = isset($options['business_id']['name']) ? explode(",", $options['business_id']['name']) : ['bizid'];
		
		foreach ($field_names as $field_name){			
			if (isset($_REQUEST[$field_name])) {
				$business_id =  $_REQUEST[$field_name];
				$endpoint_url = 'https://'.$this->api_domain.'/v2/decision/company/base?businessId=' . $business_id . '&country=FI&refresh=true';
				$data =	$this->send_API_request($endpoint_url, "GET");
				$current_user = wp_get_current_user();
				if ($current_user instanceof WP_User && $current_user->ID > 0){				
					update_user_meta($current_user->ID, 'company_base', $data);					
					$_REQUEST['bid'] = $business_id;				
					$data = $this->get_company_detail(true);
					if (!empty($data)) {
						update_user_meta($current_user->ID, 'company_info', sanitize_text_field($data));
					}
				}
				
				break;
			}
		}
	}	

	// save options to database
	function enterpay_plugin_options_validate($input)
	{
		$options = get_option('enterpay_plugin_options');
		$options['username'] = trim($input['username']);
		$options['password'] = trim($input['password']);
		$options['environment'] = trim($input['environment']);
		$options['start_date'] = trim($input['start_date']);
		return $options;
	}

	function enterpay_save_custom_checkout_fields($order)
	{
		$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
		
		$field_names = isset($options['business_id']['name']) ? explode(",", $options['business_id']['name']) : ['bizid'];
		
		foreach ($field_names as $field_name){
			if (isset($_POST[$field_name])) {		
				$bizid = sanitize_text_field($_POST[$field_name]);
				$order->update_meta_data('bizid', $bizid);
				
				break;
			}
		}

		$field_names = isset($options['vat_number']['name']) ? explode(",", $options['vat_number']['name']) : ['vat'];
		
		foreach ($field_names as $field_name){
			if (isset($_POST[$field_name])) {	
				$vat = sanitize_text_field($_POST[$field_name]);
				$order->update_meta_data('vat', $vat);
				
				break;
			}
		}
	}
	function enterpay_save_custom_fields_to_user_meta($order_id)
	{
		$order = wc_get_order($order_id);
		$user_id = $order->get_user_id();
		
		$options  = get_option( 'enterpay_plugin_options_fields', array() );		
		$field_names = isset($options['business_id']['name']) ? explode(",", $options['business_id']['name']) : ['bizid'];
		
		foreach ($field_names as $field_name){
			if (isset($_POST[$field_name])) {		
				$bizid = sanitize_text_field($_POST[$field_name]);
				update_user_meta($user_id, 'enterpay_bsuiness_id', $bizid);
				
				break;
			}
		}

		$field_names = isset($options['vat_number']['name']) ? explode(",", $options['vat_number']['name']) : ['vat'];
		
		foreach ($field_names as $field_name){
			if (isset($_POST[$field_name])) {	
				$vat = sanitize_text_field($_POST[$field_name]);
				update_user_meta($user_id, 'enterpay_vat_id', $vat);
				
				break;
			}
		}
	}
}
