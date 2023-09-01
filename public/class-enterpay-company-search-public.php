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
			CURLOPT_URL => 'https://api.test.entercheck.eu/v1/auth',
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

		$endpoint_url = "https://api.test.entercheck.eu/company/search?country=" . $country_code . "&name=" . $name;
		$data = $this->send_API_request($endpoint_url, "GET");
		print_r($data);
		die();
	}

	public function get_company_detail()
	{
		$bid = $_REQUEST["bid"];
		$country_code = 'FI';
		$endpoint_url = "https://api.test.entercheck.eu/company/details?country=" . $country_code . "&id=" . $bid;

		print_r($this->send_API_request($endpoint_url, "GET"));
		die();
	}

	public function company_search_form_render()
	{
		// ob_start();
		// include(plugin_dir_path(__FILE__) . 'partials/form-shortcode.php');
		// return ob_get_clean();		
	}

	public function custom_checkout_field()
	{

		echo '<div id="custom_checkout_field"><h2>' . __('Company details') . '</h2>';
		// inputCompanyName
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
		//inputBusinessId
		woocommerce_form_field(
			'bizid',
			array(
				'custom_attributes' => array('data-length' => 500),
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
		$options = get_option('enterpay_plugin_options');
		$show_business = false;
		if (empty($options['checkbox'])) {
			$show_business = true;
			$options['checkbox'] = array();
		}
		if (count($options['checkbox']) >= 1 && array_key_exists('businesses', $options['checkbox'])) {
			$show_business = true;
		}
		if ($show_business) {
			$fields['vat'] = array(
				'custom_attributes' => array('readonly' => 'readonly'),
				'label' => __('VAT number', 'woocommerce'), // Add custom field label
				'placeholder' => "", // Add custom field placeholder
				'required' => true, // if field is required or not
				'clear' => false, // add clear or not
				'type' => 'text', // add field type
				'id' => 'inputVATNumber',
				'class' => array(' form-row-wide')    // add class name
			);
			$fields['bizid'] = array(
				'custom_attributes' => array('readonly' => 'readonly'),
				'label' => __('Business ID', 'woocommerce'), // Add custom field label
				'placeholder' => "", // Add custom field placeholder
				'required' => true, // if field is required or not
				'clear' => false, // add clear or not
				'type' => 'text', // add field type
				'id' => 'inputBusinessId',
				'class' => array(' form-row-wide')    // add class name
			);
			$fields['company_info'] = array(
				'custom_attributes' => array('readonly' => 'readonly'),
				'placeholder' => "", // Add custom field placeholder
				'required' => false, // if field is required or not
				'clear' => false, // add clear or not
				'type' => 'hidden', // add field type
				'id' => 'company_info',
			);
		}

		return $fields;
	}

	function custom_override_checkout_fields($fields)
	{

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



	function bbloomer_hide_price_addcart_not_logged_in($price,  $product)
	{
		//return "";
		$cuid = get_current_user_id();

		if ($cuid == null || $cuid == "") {
			//return "";		

			remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
			add_filter('woocommerce_is_purchasable', '__return_false');
			return '<div><a href="' . get_permalink(wc_get_page_id('myaccount')) . '">' . __('Login to see prices', 'bbloomer') . '</a></div>';
		} else {
			return $price;
		}
	}

	function wooc_extra_register_fields()
	{
?>
		<p class="form-row form-row-first">
			<label for="reg_billing_first_name"><?php _e('First name', 'woocommerce'); ?><span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if (!empty($_POST['billing_first_name'])) esc_attr_e($_POST['billing_first_name']); ?>" />
		</p>
		<p class="form-row form-row-last">
			<label for="reg_billing_last_name"><?php _e('Last name', 'woocommerce'); ?><span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if (!empty($_POST['billing_last_name'])) esc_attr_e($_POST['billing_last_name']); ?>" />
		</p>
		<p class="form-row form-row-wide">
			<label for="billing_company"><?php _e('Company name', 'woocommerce'); ?></label>
			<input type="text" class="input-text" name="billing_company" id="billing_company" value="<?php esc_attr_e($_POST['billing_company']); ?>" />
		</p>
		<p class="form-row form-row-wide">
			<label for="billing_company"><?php _e('VAT number', 'woocommerce'); ?></label>
			<input type="text" class="input-text" name="vat" id="inputVATNumber" value="<?php esc_attr_e($_POST['vat']); ?>" />
		</p>
		<?php $business_id = !empty($_POST['bizid']) ? $_POST['bizid'] : ''; ?>
		<p class="form-row form-row-wide">
			<label for="billing_company"><?php _e('Business ID', 'woocommerce'); ?><span class="required">*</span></label>
			<input type="text" class="input-text" name="bizid" id="inputBusinessId" value="<?php esc_attr_e($business_id); ?>" />
		</p>
		<p class="form-row form-row-wide">
			<label for="billing_address_1"><?php _e('Company  address', 'woocommerce'); ?></label>
			<input type="text" class="input-text" name="billing_address_1" id="billing_address_1" value="<?php esc_attr_e($_POST['billing_address_1']); ?>" />
		</p>
		<p class="form-row form-row-wide">
			<label for="billing_postcode"><?php _e('Postcode', 'woocommerce'); ?></label>
			<input type="text" class="input-text" name="billing_postcode" id="billing_postcode" value="<?php esc_attr_e($_POST['billing_postcode']); ?>" />
		</p>
		<p class="form-row form-row-wide">
			<label for="billing_city"><?php _e('City', 'woocommerce'); ?></label>
			<input type="text" class="input-text" name="billing_city" id="billing_city" value="<?php esc_attr_e($_POST['billing_city']); ?>" />
		</p>
		<div class="clear"></div>
		<hr>
	<?php
	}

	function wooc_extra_register_fields_validation($errors)
	{
		if (empty($_POST['bizid'])) {
			$errors->add('name_err', '<strong>Error</strong>: Please provide a Business ID.');
		}
		return $errors;
	}

	function request_after_registration_submission($user_id)
	{
		if (isset($_POST['bizid'])) {
			$business_id =  $_POST['bizid'];
			$endpoint_url = 'https://api.test.entercheck.eu/v2/decision/company/base?businessId=' . $business_id . '&country=FI&refresh=true';
			$this->send_API_request($endpoint_url, "GET");
		}
	}

	// save options to database
	function enterpay_plugin_options_validate($input)
	{

		if (empty($input['consumers'])) {
			$input['consumers'] = 0;
		}
		if (empty($input['businesses'])) {
			$input['businesses'] = 0;
		}

		$options = get_option('enterpay_plugin_options');
		$options['username'] = trim($input['username']);
		$options['password'] = trim($input['password']);
		$options['start_date'] = trim($input['start_date']);
		$options['consumers'] = trim($input['consumers']);
		$options['businesses'] = trim($input['businesses']);
		return $options;
	}

	// validate checkout fields
	function update_billing_phone_requirement($data)
	{
		$consumer_or_business = isset($_POST['consumer_or_business']) ? wc_clean($_POST['consumer_or_business']) : '';

		if ($consumer_or_business !== 'businesses') {
			unset($data['bizid']);
			unset($data['vat']);
		}
		return $data;
	}

	function custom_checkout_field_select()
	{
		$options = get_option('enterpay_plugin_options');

		if (empty($options['checkbox'])) {
			$options['checkbox'] = array();
		}

		if (count($options['checkbox']) <= 1) {
			return;
		}
		// add select options
		$option = array(
			'businesses' => 'Businesses',
			'consumers' => 'Consumers',
		);
		woocommerce_form_field('consumer_or_business', array(
			'type'          => 'select',
			'input_class'         => array(' input-text  '),
			'label'         => __('Consumers or Businesses'),
			'options'       => $option,
			'required'      => true,
		),  WC()->checkout->get_value('consumer_or_business'));
	}

	function enterpay_save_custom_checkout_fields($order)
	{
		$bizid = sanitize_text_field($_POST['bizid']);
		$order->update_meta_data('bizid', $bizid);

		$vat = sanitize_text_field($_POST['vat']);
		$order->update_meta_data('vat', $vat);
	}
	function enterpay_save_custom_fields_to_user_meta($order_id)
	{
		$order = wc_get_order($order_id);
		$user_id = $order->get_user_id();
		$bizid = sanitize_text_field($_POST['bizid']);
		update_user_meta($user_id, 'enterpay_bsuiness_id', $bizid);

		$vat = sanitize_text_field($_POST['vat']);
		update_user_meta($user_id, 'enterpay_vat_id', $vat);
	}

	function woocommerce_account_dashboard_customer()
	{
		$request_uri = $_SERVER['REQUEST_URI'];
		// if not billing or shipping show the company info
		if (strpos($request_uri, 'billing') !== false || strpos($request_uri, 'shipping') !== false) {
			return;
		}

	?>
		<!-- tore the VAT ID, Bsuiness ID, -->
		<div class="u-column2 col-2 woocommerce-Address">
			<header class="woocommerce-Address-title title">
				<h3><?php _e('Company details', 'enterpay-company-search') ?></h3>
				<a href="https://portal.test.entercheck.eu/companies/85ce6ccb-5dcf-4b5e-9ea3-e5bc2f541e62" class="edit"><?php _e('Customer Details', 'enterpay-company-search') ?></a>
			</header>
			<address>
				<p>
					<?php
					$user_id = get_current_user_id();
					$vat = get_user_meta($user_id, 'enterpay_vat_id', true);
					$bizid = get_user_meta($user_id, 'enterpay_bsuiness_id', true);

					// get company info
					$company_info = get_user_meta($user_id, 'company_info', true);
					if (empty($company_info)) {
						return;
					}
					$company_info = json_decode($company_info);
					$company_registers = $company_info->registers;
					$company_status = $company_info->status;



					echo "VAT ID: " . $vat . "<br>";
					echo "Bsuiness ID: " . $bizid . "<br>";
					echo "Company Status: " . $company_status . "<br>";
					echo "<br>";
					// create html  table to show company fields registers businessId registered startDate endDate
					// if company status is active then show the company info
					echo '<table class="pure-table">';
					echo '<thead>';
					echo '<tr>';
					echo '<th>' . __('Business ID') . '</th>';
					echo '<th>' . __('Registered') . '</th>';
					echo '<th>' . __('Start Date') . '</th>';
					echo '<th>' . __('End Date') . '</th>';
					echo '<tbody>';
					foreach ($company_registers as $key => $company_val) {
						$register = $company_val->registered == 1 ? __('Yes') : __('No');
						echo '<tr>';
						echo '<td>' . $company_val->businessId . '</td>';
						echo '<td>' . $register . '</td>';
						echo '<td>' . $company_val->startDate . '</td>';
						echo '<td>' . $company_val->endDate . '</td>';
						echo '</tr>';
					}
					echo '</tbody>';
					echo '</table>';

					?>
				</p>
			</address>

		</div>
<?php
	}
}
