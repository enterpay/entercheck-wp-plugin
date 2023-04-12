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

		$variables = array(
			'ajaxurl' => admin_url('admin-ajax.php')
		);
		wp_localize_script($this->plugin_name, "enterpayjs", $variables);
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

		// close curl resource to free up system resources
		curl_close($ch);
		return $data;
	}

	public function search_company()
	{
		$name = $_REQUEST["name"];
		$country_code = 'fi';


		$endpoint_url = "https://api.test.entercheck.eu/company/search?country=" . $country_code . "&name=" . $name;

		print_r($this->send_API_request($endpoint_url, "GET"));
		die();
	}

	public function get_company_detail()
	{
		$bid = $_REQUEST["bid"];
		$country_code = 'fi';
		$endpoint_url = "https://api.test.entercheck.eu/company/details?country=" . $country_code . "&id=" . $bid;

		print_r($this->send_API_request($endpoint_url, "GET"));
		die();
	}

	public function company_search_form_render()
	{
		ob_start();

		include(plugin_dir_path(__FILE__) . 'partials/form-shortcode.php');

		return ob_get_clean();
	}

	public function custom_checkout_field()
	{

		echo '<div id="custom_checkout_field"><h2>' . __('Company details') . '</h2>';

		woocommerce_form_field(
			'name',
			array(

				'type' => 'text',

				'class' => array(

					'my-field-class form-row-wide',
					'typeahead'

				),
				'id' => 'inputCompanyName',
				'name' => 'name',

				'label' => __('Company Name'),
				'required' => true

			),

			//$checkout->get_value('custom_field_name')
		);

		woocommerce_form_field(
			'bizid',
			array(

				'type' => 'text',

				'class' => array(

					'my-field-class form-row-wide'

				),
				'id' => 'inputBusinessId',
				'name' => 'bizid',

				'label' => __('Business ID'),
				'required' => true

			),

			//$checkout->get_value('custom_field_name')
		);

		//inputVATNumber

		woocommerce_form_field(
			'vat',
			array(

				'type' => 'text',

				'class' => array(

					'my-field-class form-row-wide'

				),
				'id' => 'inputVATNumber',
				'name' => 'VAT',

				'label' => __('VAT NUMBER'),
				'required' => true

			),

			//$checkout->get_value('custom_field_name')
		);
		//inputStreetAddress

		woocommerce_form_field(
			'StreetAddress',
			array(

				'type' => 'text',

				'class' => array(

					'my-field-class form-row-wide'

				),
				'id' => 'inputStreetAddress',
				'name' => 'StreetAddress',

				'label' => __('Street address'),
				'required' => true

			),

			//$checkout->get_value('custom_field_name')
		);

		//inputCity

		woocommerce_form_field(
			'inputCity',
			array(

				'type' => 'text',

				'class' => array(

					'my-field-class form-row-wide'

				),
				'id' => 'inputCity',
				'name' => 'inputCity',

				'label' => __('CITY'),
				'required' => true

			),

			//$checkout->get_value('custom_field_name')
		);

		//inputPostalCode

		woocommerce_form_field(
			'inputPostalCode',
			array(

				'type' => 'text',

				'class' => array(

					'my-field-class form-row-wide'

				),
				'id' => 'inputPostalCode',
				'name' => 'inputPostalCode',

				'label' => __('Postal code'),
				'required' => true

			),

			//$checkout->get_value('custom_field_name')
		);
		echo '</div>';
	}

	function custom_woocommerce_billing_fields($fields)
	{

		$fields['vat'] = array(
			'label' => __('VAT number', 'woocommerce'), // Add custom field label
			'placeholder' => "", // Add custom field placeholder
			'required' => true, // if field is required or not
			'clear' => false, // add clear or not
			'type' => 'text', // add field type
			'id' => 'inputVATNumber',
			'class' => array(' form-row-wide')    // add class name
		);

		$fields['bizid'] = array(
			'label' => __('Business ID', 'woocommerce'), // Add custom field label
			'placeholder' => "", // Add custom field placeholder
			'required' => true, // if field is required or not
			'clear' => false, // add clear or not
			'type' => 'text', // add field type
			'id' => 'inputBusinessId',
			'class' => array(' form-row-wide')    // add class name
		);
		return $fields;
	}

	function custom_override_checkout_fields($fields){

		$fields['billing']['billing_first_name']['priority'] = 1;
		$fields['billing']['billing_last_name']['priority'] = 2;
		$fields['billing']['billing_company']['priority'] = 3;
		$fields['bizid']['priority'] = 4;
		$fields['vat']['priority'] = 5;
		$fields['billing']['billing_address_1']['priority'] = 6;
		$fields['billing']['billing_address_2']['priority'] = 7;
		$fields['billing']['billing_city']['priority'] = 8;		
		$fields['billing']['billing_state']['priority'] = 9;
		$fields['billing']['billing_postcode']['priority'] = 10;
		$fields['billing']['billing_country']['priority'] = 11;		
		$fields['billing']['billing_email']['priority'] = 12;
		$fields['billing']['billing_phone']['priority'] = 13;
		return $fields;

	}
}
