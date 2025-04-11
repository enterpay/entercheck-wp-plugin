<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://demoshop.entercheck.eu/
 * @since      1.0.0
 *
 * @package    Entercheck_Company_Search
 * @subpackage Entercheck_Company_Search/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Entercheck_Company_Search
 * @subpackage Entercheck_Company_Search/public
 * @author     Entercheck <support@entercheck.eu>
 */
class Entercheck_Company_Search_Public
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
	 * @var      string    $version    The URL of API.
	 */
	public $api_domain;
	
	/**
	 * The portal domain API.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The URL of portal API.
	 */
	public $portal_api_domain;	

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
		
		$this->api_domain = "entercheck-api.fly.dev";
		$this->portal_api_domain = "entercheck-api.fly.dev";
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
		 * defined in Entercheck_Company_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Entercheck_Company_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


		//wp_register_style($this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/entercheck-company-search-public.css', array(), $this->version, 'all' );
		wp_enqueue_style($this->plugin_name . "-CSS", plugin_dir_url(__FILE__) . 'css/entercheck-company-search-public.css', array(), $this->version, 'all');


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
		 * defined in Entercheck_Company_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Entercheck_Company_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


		//typeahead.bundle.js"
		wp_enqueue_script("typeahead", plugin_dir_url(__FILE__) . 'js/typeahead/typeahead.bundle.js', array('jquery'), $this->version, false);


		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/entercheck-company-search-public.js', array('jquery'), $this->version, false);

		$options = get_option('entercheck_plugin_options_fields');
		$plugin_options = get_option('entercheck_plugin_options');

		$variables = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'company_name_name' => isset($options['company_name']['name']) ? $options['company_name']['name'] : 'billing_company',
			'company_name_id' => isset($options['company_name']['id']) ? str_ireplace(',', ', #', $options['company_name']['id']) : 'billing_company',
			'company_name_tootltip' => isset($options['company_name']['tooltip']) ? $options['company_name']['tooltip'] : 'Search for your company details by typing a search phrase to the box',
			'vat_number_name' => isset($options['vat_number']['name']) ? $options['vat_number']['name'] : 'inputVATNumber',
			'vat_number_id' => isset($options['vat_number']['id']) ? str_ireplace(',', ', #', $options['vat_number']['id']) : 'inputVATNumber',
			'business_id_name' => isset($options['business_id']['name']) ? $options['business_id']['name'] : 'inputBusinessId',
			'business_id_name_first' => isset($options['business_id']['name']) ? array_map('trim', explode(',', $options['business_id']['name']))[0] : 'inputBusinessId',
			'business_id_id' => isset($options['business_id']['id']) ? str_ireplace(',', ', #', $options['business_id']['id']) : 'inputBusinessId',
			'business_id_id_first' => isset($options['business_id']['id']) ? array_map('trim', explode(',', $options['business_id']['id']))[0] : 'inputBusinessId',
			'business_id_auto' => isset($options['business_id']['auto']) && is_numeric($options['business_id']['auto']) ? intval($options['business_id']['auto']) : 0,
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
			
			'display_invoice_address' => isset($options['display_invoice_address']) && is_numeric($options['display_invoice_address']) ? intval($options['display_invoice_address']) : 0,
			'invoice_selector_name' => isset($options['invoice_selector']['name']) ? $options['invoice_selector']['name'] : 'invoice_selector',
			'invoice_selector_id' => isset($options['invoice_selector']['id']) ? str_ireplace(',', ', #', $options['invoice_selector']['id']) : 'invoice_selector',
			'invoice_address_name' => isset($options['invoice_address']['name']) ? $options['invoice_address']['name'] : 'invoice_address',
			'invoice_address_id' => isset($options['invoice_address']['id']) ? str_ireplace(',', ', #', $options['invoice_address']['id']) : 'invoice_address',
			'invoice_operator_code_name' => isset($options['invoice_operator_code']['name']) ? $options['invoice_operator_code']['name'] : 'invoice_operator_code',
			'invoice_operator_code_id' => isset($options['invoice_operator_code']['id']) ? str_ireplace(',', ', #', $options['invoice_operator_code']['id']) : 'invoice_operator_code',
			
			'revenue_class_name' => isset($options['revenue_class']['name']) ? $options['revenue_class']['name'] : 'revenue_class',
			'revenue_class_id' => isset($options['revenue_class']['id']) ? str_ireplace(',', ', #', $options['revenue_class']['id']) : 'revenue_class',
			'revenue_name' => isset($options['revenue']['name']) ? $options['revenue']['name'] : 'revenue',
			'revenue_id' => isset($options['revenue']['id']) ? str_ireplace(',', ', #', $options['revenue']['id']) : 'revenue',
			'result_name' => isset($options['result']['name']) ? $options['result']['name'] : 'result',
			'result_id' => isset($options['result']['id']) ? str_ireplace(',', ', #', $options['result']['id']) : 'result',
			'employees_name' => isset($options['employees']['name']) ? $options['employees']['name'] : 'employees',
			'employees_id' => isset($options['employees']['id']) ? str_ireplace(',', ', #', $options['employees']['id']) : 'employees',

			
			'allow_search_country' => isset($options['allow_search_country']) && is_numeric($options['allow_search_country']) ? intval($options['allow_search_country']) : 0,
			'default_country' => !empty($options['default_country']) ? $options['default_country'] : 'FI',
			'search_country_name' => isset($options['search_country']['name']) ? $options['search_country']['name'] : 'search_country',
			'search_country_id' => isset($options['search_country']['id']) ? str_ireplace(',', ', #', $options['search_country']['id']) : 'search_country',
			'search_country_list' => [],
			
			'entercheck_nonce_field' => wp_nonce_field( 'entercheck_nonce_action', 'entercheck_nonce', false, false ),
			'search_token' => $this->get_search_token(),
			'search_url' => 'https://'.$this->api_domain.'/search/company',
			
		);
		
		if (isset($options['allow_search_country']) && is_numeric($options['allow_search_country']) && $options['allow_search_country'] == 1){
			$search_country_list = array_filter(explode(',', $options['search_country_list']));
			
			$variables['search_country_list'] = array_filter(
														EntercheckCountry::getInstance()->get_country_list(),
														function ($key) use ($search_country_list) {return in_array($key, $search_country_list);} ,
														ARRAY_FILTER_USE_KEY
													);
		}
		
		
		wp_localize_script($this->plugin_name, "entercheckjs", $variables);
	}

	public function get_search_token(){
		$options = get_option('entercheck_plugin_options');
		
		$request_url = 'https://'.$this->api_domain.'/auth/anonymous';
		$data = $this->send_API_request($request_url, "POST");
		
		if (!empty($data)) {
			return json_decode($data)->token;			
		}
		
		return '';
	}
	
	public function send_API_request($endpoint_url, $method, $fileds = [], $retries = 0)
	{
		$options = get_option('entercheck_plugin_options');
		
		$api_key = !empty($options["api_key"]) ? $options["api_key"] : '';
				
		$send_data = array(
			'method' => $method,		
			'headers'  => array(
				'Content-Type' => 'application/json',
				'Authorization' => 'Bearer ' . $api_key,
				'Cache-control' => 'no-cache',
				'Accept: */*',
				'Connection: keep-alive'
			)
		);
		
		if ($method == "POST"){
			$fileds = wp_json_encode($fileds);
			
			$send_data['body'] = $fileds;
			
			$my_request = wp_remote_post($endpoint_url, $send_data);
		} else {
			$my_request = wp_remote_get($endpoint_url, $send_data);
		}
		
		
		if ( ! is_wp_error( $my_request ) && ( 200 == $my_request['response']['code'] || 201 == $my_request['response']['code'] ) ) {
			$resp = wp_remote_retrieve_body( $my_request );
		} else {
			if ($retries < 5) {
				$retries++;
				sleep(2);
					
				return $this->send_API_request($endpoint_url, $method, $fileds, $retries);
			} else {
				return null;
			}
		}
		
		if (!empty($resp)) {
			return $resp;
		}
		
		return null;
	}
	
	public function search_company()
	{
		if (isset($_REQUEST['admin_nonce'])){
			if (!wp_verify_nonce( sanitize_text_field( wp_unslash ($_REQUEST['admin_nonce'])), 'entercheck_admin_nonce' )){
				echo '';
				die();
			}
		} else if (isset($_REQUEST['nonce'])){
			if (!wp_verify_nonce( sanitize_text_field( wp_unslash ($_REQUEST['nonce'])), 'entercheck_nonce_action' )) {
				echo '';
				die();
			}
		} else {
			echo '';
			die();
		}
		
		$name = urlencode(sanitize_text_field( wp_unslash ($_REQUEST["name"])));
		
		$options = get_option('entercheck_plugin_options_fields');
		$country_code = !empty($_REQUEST["country"]) ? sanitize_text_field($_REQUEST["country"]) : (!empty($options['default_country']) ? $options['default_country'] : 'FI');

		$endpoint = '/search/company';
		$endpoint_url = "https://".$this->api_domain.$endpoint."?country=" . $country_code . "&name=" . $name;
		
		if (isset($options["use_advanced_search"]) && $options["use_advanced_search"] == '1')
			$endpoint_url .= "&advancedSearch=true";
		
		$data = $this->send_API_request($endpoint_url, "GET");
		
		print_r($data);
		die();
	}

	public function get_company_detail($is_return = false)
	{				
		if (!isset($_REQUEST['nonce']) || !wp_verify_nonce( sanitize_text_field( wp_unslash ($_REQUEST['nonce'])), 'entercheck_nonce_action' )){
			echo '';
			die();
		}
	
		$bid = sanitize_text_field($_REQUEST["bid"]);
		
		$options = get_option('entercheck_plugin_options_fields');
		$country_code = !empty($_REQUEST["country"]) ? sanitize_text_field($_REQUEST["country"]) : (!empty($options['default_country']) ? $options['default_country'] : 'FI');
		
		$endpoint = '/search/company/details';
		$endpoint_url = "https://".$this->api_domain.$endpoint."?country=" . $country_code . "&id=" . $bid;
		
		$data = $this->send_API_request($endpoint_url, "GET");

		if ($is_return)
			return $data;

		print_r($data);
		die();
	}

	function woocommerce_register_post_customer($username, $email, $errors)
	{
		if (!wp_verify_nonce( sanitize_text_field( wp_unslash ($_REQUEST['entercheck_nonce'])), 'entercheck_nonce_action' )) 
			return;
		
		$options  = get_option( 'entercheck_plugin_options_fields', array() ); 

		if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name'])) {
			$errors->add('billing_first_name_error', esc_attr__('First name is required!', 'entercheck-company-search'));
		}
		if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name'])) {
			$errors->add('billing_last_name_error', esc_attr__('Last name is required!', 'entercheck-company-search'));
		}
			
		$field_names = isset($options['company_name']['name']) ? explode(",", $options['company_name']['name']) : ['billing_company'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name]) && empty($_POST[$field_name])) {
				$errors->add('billing_last_name_error', esc_attr__('Company name is required!', 'entercheck-company-search'));
				break;
			}
		}
		
		$field_names = isset($options['business_id']['name']) ? explode(",", $options['business_id']['name']) : ['inputBusinessId'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name]) && empty($_POST[$field_name])) {
				$errors->add('billing_last_name_error', esc_attr__('Business ID is required!', 'entercheck-company-search'));
				break;
			}
		}
		
		$field_names = isset($options['vat_number']['name']) ? explode(",", $options['vat_number']['name']) : ['inputVATNumber'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name]) && empty($_POST[$field_name])) {
				$errors->add('billing_last_name_error', esc_attr__('VAT NUMBER is required!', 'entercheck-company-search'));
				break;
			}
		}
		
		$field_names = isset($options['street']['name']) ? explode(",", $options['street']['name']) : ['billing_address_1'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name]) && empty($_POST[$field_name])) {
				$errors->add('billing_last_name_error', esc_attr__('Company address is required!', 'entercheck-company-search'));
				break;
			}
		}
		
		$field_names = isset($options['postal_code']['name']) ? explode(",", $options['postal_code']['name']) : ['billing_postcode'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name]) && empty($_POST[$field_name])) {
				$errors->add('billing_last_name_error', esc_attr__('Postcode is required!', 'entercheck-company-search'));
				break;
			}
		}
		
		$field_names = isset($options['city']['name']) ? explode(",", $options['city']['name']) : ['billing_city'];		
		foreach ($field_names as $field_name){		
			if (isset($_POST[$field_name]) && empty($_POST[$field_name])) {
				$errors->add('billing_last_name_error', esc_attr__('City is required!', 'entercheck-company-search'));
				break;
			}
		}	
		
		if (isset($_POST['email']) && empty($_POST['email'])) {
			$errors->add('billing_last_name_error', esc_attr__('Email address is required!', 'entercheck-company-search'));
		}
		if (isset($_POST['password']) && empty($_POST['password'])) {
			$errors->add('billing_last_name_error', esc_attr__('Password is required!', 'entercheck-company-search'));
		}
		return $errors;
	}

	function woocommerce_created_customer_data($customer_id)
	{
		if (!wp_verify_nonce( sanitize_text_field( wp_unslash ($_REQUEST['entercheck_nonce'])), 'entercheck_nonce_action' )) 
			return;
		
		$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
		
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
		
		$field_names = isset($options['business_id']['name']) ? explode(",", $options['business_id']['name']) : ['inputBusinessId'];		
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

	function get_form_search_country(){
		$options  = get_option( 'entercheck_plugin_options_fields', array() );	
		
		$field_country = isset($options['search_country']['name']) ? explode(",", $options['search_country']['name']) : ['search_country'];
		$field_allow_search_country = isset($options['allow_search_country']) && is_numeric($options['allow_search_country']) && $options['allow_search_country'] == 1;
		
		$country = !empty($options['default_country']) ? $options['default_country'] : 'FI';
		
		if ($field_allow_search_country){
			foreach ($field_country as $field_name){
				if (!empty($_REQUEST[$field_name])) {
					$country = sanitize_text_field($_REQUEST[$field_name]);
				}
			}
		}
		
		return $country;
	}
	
	function send_post_request(){		
		if (isset($GLOBALS["entercheck_post_request_already_sent"]) && $GLOBALS["entercheck_post_request_already_sent"] == 1)
			return;
				
		$options  = get_option( 'entercheck_plugin_options', array() );
						
		//if (isset($options["request_mode"]) && $options["request_mode"] == "smart"){
			$options_fields  = get_option( 'entercheck_plugin_options_fields', array() );			
			$company_name_fields = isset($options_fields['company_name']['name']) ? explode(",", $options_fields['company_name']['name']) : ['billing_company'];
			/*if (isset($form_mapping_options["smartFormId"]) && $form_mapping_options["smartFormId"]['value'] != ""){*/
			foreach ($company_name_fields as $company_name_field){	
				if (isset($_REQUEST[$company_name_field])){
					$form_mapping_options  = get_option( 'entercheck_plugin_options_form_mapping', array() );	
					$smartFormId = !empty($options["smart_form_id"]) ? $options["smart_form_id"] : '';
					$businessId = "";
					$country = $this->get_form_search_country();
						
					$field_names = isset($options_fields['business_id']['name']) ? explode(",", $options_fields['business_id']['name']) : ['inputBusinessId'];
					foreach ($field_names as $field_name){
						if (isset($_REQUEST[$field_name])) {
							$businessId = sanitize_text_field($_REQUEST[$field_name]);
						}
					}
					
					$fields = ["businessId" => $businessId, "country" => $country];
					if (!empty($smartFormId)){
						$fields["workflowId"] = $smartFormId;
					}
						
					$additional_data = ["field1" => "", "field2" => ""];
					
					foreach($form_mapping_options as $post_field_name => $form_mapping_field){
						if (isset($form_mapping_field["field"])) {
							if (($post_field_name == 'additionalData1')){
								$additional_data["field1"] = isset($_REQUEST[$form_mapping_field["field"]]) ? sanitize_text_field($_REQUEST[$form_mapping_field["field"]]) : "";
							} else if (($post_field_name == 'additionalData2')){
								$additional_data["field2"] = isset($_REQUEST[$form_mapping_field["field"]]) ? sanitize_text_field($_REQUEST[$form_mapping_field["field"]]) : "";
							} else if (($post_field_name == 'country')){
								$additional_data["field2"] = isset($_REQUEST[$form_mapping_field["field"]]) ? sanitize_text_field($_REQUEST[$form_mapping_field["field"]]) : "FI";							
							} else if (($post_field_name == 'phoneNumber')){
								if (!empty($_REQUEST[$form_mapping_field["field"]]))
									$additional_data["field2"] = sanitize_text_field($_REQUEST[$form_mapping_field["field"]]);
							} else {
								$fields[$post_field_name] = isset($_REQUEST[$form_mapping_field["field"]]) ? sanitize_text_field($_REQUEST[$form_mapping_field["field"]]) : "";
							}
						}
					}

					$fields["additionalData"] = $additional_data;
					
					$endpoint_url = 'https://'.$this->api_domain.'/workflow/start';
					$data =	$this->send_API_request($endpoint_url, "POST", $fields);
					
					$GLOBALS["entercheck_post_request_already_sent"] = 1;
				
					
					break;
				}
			}
		//}		
	}

	function request_after_registration_submission($user_id)
	{
		if (isset($_REQUEST['entercheck_nonce'])){
			if (!wp_verify_nonce( sanitize_text_field( wp_unslash ($_REQUEST['entercheck_nonce'])), 'entercheck_nonce_action' )) 
				return;
		}
		
		$this->save_custom_data();
		$this->send_post_request();
		
		//return;
		/*
		$options  = get_option( 'entercheck_plugin_options', array() );						
		if (!isset($options["request_mode"]) || $options["request_mode"] != "smart"){		
			$options_fields  = get_option( 'entercheck_plugin_options_fields', array() );		
			$field_names = isset($options_fields['business_id']['name']) ? explode(",", $options_fields['business_id']['name']) : ['inputBusinessId'];
			
			$country = $this->get_form_search_country();
			
			foreach ($field_names as $field_name){
				if (isset($_REQUEST[$field_name])) {
					$business_id =  sanitize_text_field($_REQUEST[$field_name]);
					$_REQUEST["entercheck_portal_link"] = 'https://'.$this->portal_api_domain.'/companies/buid/'.$business_id;
					$GLOBALS["entercheck_portal_link"] = 'https://'.$this->portal_api_domain.'/companies/buid/'.$business_id;
					
					$fields = [];
					$fields["businessId"] = $business_id;
					$fields["countryCode"] = $country;
					$fields["companyKeyFigures"] = false;
					$fields["companyRating"] = false;
					$fields["companyRepresentatives"] = false;
					$fields["companyPaymentRemarks"] = false;
									
					$endpoint_url = 'https://'.$this->api_domain.'/companies'; //company/add
					$data =	$this->send_API_request($endpoint_url, "POST", $fields);
					
					if (!empty($data)) {
						update_user_meta($user_id, 'company_info', sanitize_text_field($data));
					}
					
					break;
				}
			}
		}
		*/
	}
	
	function request_after_submission_form()
	{
		if (isset($_REQUEST['entercheck_nonce'])){
			if (!wp_verify_nonce( sanitize_text_field( wp_unslash ($_REQUEST['entercheck_nonce'])), 'entercheck_nonce_action' )) 
				return;
		}
		
		$this->save_custom_data();
		$this->send_post_request();
		
		//return;
	
		$options  = get_option( 'entercheck_plugin_options', array() );						
		if (!isset($options["request_mode"]) || $options["request_mode"] != "smart"){		
			$options_fields  = get_option( 'entercheck_plugin_options_fields', array() ); 		
			$field_names = isset($options_fields['business_id']['name']) ? explode(",", $options_fields['business_id']['name']) : ['inputBusinessId'];
			
			$country = $this->get_form_search_country();
			
			foreach ($field_names as $field_name){			
				if (isset($_REQUEST[$field_name])) {
					$business_id =  sanitize_text_field($_REQUEST[$field_name]);
					$_REQUEST["entercheck_portal_link"] = 'https://'.$this->portal_api_domain.'/companies/buid/'.$business_id;
					$GLOBALS["entercheck_portal_link"] = 'https://'.$this->portal_api_domain.'/companies/buid/'.$business_id;
					
					$fields = [];
					$fields["businessId"] = $business_id;
					$fields["countryCode"] = $country;
					$fields["companyKeyFigures"] = false;
					$fields["companyRating"] = false;
					$fields["companyRepresentatives"] = false;
					$fields["companyPaymentRemarks"] = false;
									
					$endpoint_url = 'https://'.$this->api_domain.'/companies'; // company/add
					$data =	$this->send_API_request($endpoint_url, "POST", $fields);
					
					if (!empty($data)) {
						$current_user = wp_get_current_user();
						if ($current_user instanceof WP_User && $current_user->ID > 0){	
							update_user_meta($current_user->ID, 'company_info', sanitize_text_field($data));
						}
					}
						
					/*
					$endpoint_url = 'https://'.$this->api_domain.'/v2/decision/company/base?businessId=' . $business_id . '&country='.$country.'&refresh=true';
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
					*/
					break;
				}
			}
		}
	}	

	function save_custom_data($user_id = -1){
		$options  = get_option( 'entercheck_plugin_options_fields', array() ); 		
		$field_invoice_selector = isset($options['invoice_selector']['name']) ? explode(",", $options['invoice_selector']['name']) : ['invoice_selector'];
		$field_invoice_address = isset($options['invoice_address']['name']) ? explode(",", $options['invoice_address']['name']) : ['invoice_address'];
		$field_invoice_operator_code = isset($options['invoice_operator_code']['name']) ? explode(",", $options['invoice_operator_code']['name']) : ['invoice_operator_code'];
		
		$invoice_address = "";
		$invoice_operator_code = "";
		
		foreach ($field_invoice_address as $field_name){
			if (isset($_REQUEST[$field_name])) {
				$invoice_address = sanitize_text_field($_REQUEST[$field_name]);
			}
		}
		
		foreach ($field_invoice_operator_code as $field_name){
			if (isset($_REQUEST[$field_name])) {
				$invoice_operator_code = sanitize_text_field($_REQUEST[$field_name]);
			}
		}
		
		if (!empty($invoice_address) && !empty($invoice_operator_code)){
			$invoice_address = $invoice_address.' / '.$invoice_operator_code;
		} else {
			foreach ($field_invoice_selector as $field_name){
				if (isset($_REQUEST[$field_name])) {
					$invoice_address = sanitize_text_field($_REQUEST[$field_name]);
				}
			}
		}
		
		if (!empty($invoice_address)) {
			if ($user_id > 0){
				update_user_meta($user_id, 'invoice_address', sanitize_text_field($_REQUEST[$field_name]));
			} else {
				$current_user = wp_get_current_user();
				if ($current_user instanceof WP_User && $current_user->ID > 0){	
					update_user_meta($current_user->ID, 'invoice_address', sanitize_text_field($invoice_address));
				}
			}
		}		
	}

	// save options to database
	function entercheck_plugin_options_validate($input)
	{
		$options = get_option('entercheck_plugin_options');
		$options['start_date'] = trim($input['start_date']);
		//$options['request_mode'] = trim($input['request_mode']);
		$options['smart_form_id'] = trim($input['smart_form_id']);
		$options['api_key'] = trim($input['api_key']);
		return $options;
	}

	function entercheck_save_custom_checkout_fields($order)
	{
		if (!wp_verify_nonce( sanitize_text_field( wp_unslash ($_REQUEST['entercheck_nonce'])), 'entercheck_nonce_action' )) 
			return;
		
		$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
		
		$field_names = isset($options['business_id']['name']) ? explode(",", $options['business_id']['name']) : ['inputBusinessId'];
		
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
	function entercheck_save_custom_fields_to_user_meta($order_id)
	{
		if (!wp_verify_nonce( sanitize_text_field( wp_unslash ($_REQUEST['entercheck_nonce'])), 'entercheck_nonce_action' )) 
			return;
		
		$order = wc_get_order($order_id);
		$user_id = $order->get_user_id();
		
		$options  = get_option( 'entercheck_plugin_options_fields', array() );		
		$field_names = isset($options['business_id']['name']) ? explode(",", $options['business_id']['name']) : ['inputBusinessId'];
		
		foreach ($field_names as $field_name){
			if (isset($_POST[$field_name])) {		
				$bizid = sanitize_text_field($_POST[$field_name]);
				update_user_meta($user_id, 'entercheck_bsuiness_id', $bizid);
				
				break;
			}
		}

		$field_names = isset($options['vat_number']['name']) ? explode(",", $options['vat_number']['name']) : ['vat'];
		
		foreach ($field_names as $field_name){
			if (isset($_POST[$field_name])) {	
				$vat = sanitize_text_field($_POST[$field_name]);
				update_user_meta($user_id, 'entercheck_vat_id', $vat);
				
				break;
			}
		}
	}
}
