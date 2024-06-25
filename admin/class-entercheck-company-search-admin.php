<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://demoshop.entercheck.eu/
 * @since      1.0.0
 *
 * @package    Entercheck_Company_Search
 * @subpackage Entercheck_Company_Search/admin
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Entercheck_Company_Search
 * @subpackage Entercheck_Company_Search/admin
 * @author     Entercheck <support@entercheck.eu>
 */
class Entercheck_Company_Search_Admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		include(plugin_dir_path(__FILE__) . 'partials/entercheck-company-search-admin-fields-settings.php');
		
		$options = get_option('enterpay_plugin_options');
		
		if (isset($options['request_mode']) && $options['request_mode'] == 'smart')
			include(plugin_dir_path(__FILE__) . 'partials/entercheck-company-search-admin-form-mapping-settings.php');
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/entercheck-company-search-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/entercheck-company-search-admin.js', array('jquery'), $this->version, false);
		
		$variables = [
						'ajaxurl' => admin_url('admin-ajax.php'),
						'nonce' => wp_create_nonce("entercheck_admin_nonce")
					];
		wp_localize_script($this->plugin_name, "entercheckjs", $variables);
	}

	/**
	 * Register the menu for the admin area.
	 *
	 * @since    1.0.0
	 */




	public function add_menu()
	{
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page("Entercheck", "Entercheck", 'manage_options', $this->plugin_name . '-entercheck', array($this, 'page_entercheck_admin'));
		add_submenu_page($this->plugin_name . '-entercheck', 'Credentials', 'Credentials', 'manage_options', $this->plugin_name . '-credentials', array($this, 'page_entercheck_admin'));
		//add_submenu_page($this->plugin_name . '-entercheck', 'Field settings', 'Field settings', 'manage_options', $this->plugin_name . '-entercheck-fields', array($this, 'page_entercheck_fields_admin'));
		remove_submenu_page($this->plugin_name . '-entercheck', $this->plugin_name . '-entercheck');
	}

	public function page_entercheck_admin()
	{
		include(plugin_dir_path(__FILE__) . 'partials/entercheck-company-search-admin-display.php');
	}	
		
	public function page_entercheck_fields_admin()
	{
		include(plugin_dir_path(__FILE__) . 'partials/entercheck-company-search-admin-fields-settings.php');
	}

	public function admin_register_settings()
	{

		register_setting('enterpay_plugin_options', 'enterpay_plugin_options', 'entercheck_plugin_options_validate');

		add_settings_section('api_settings', 'API Credentials', 'entercheck_plugin_section_text', 'dbi_example_plugin');

		add_settings_field('entercheck_plugin_setting_username', 'Username', 'entercheck_plugin_setting_username', 'dbi_example_plugin', 'api_settings');
		add_settings_field('entercheck_plugin_setting_password', 'Password', 'entercheck_plugin_setting_password', 'dbi_example_plugin', 'api_settings');
		add_settings_field('entercheck_plugin_setting_environment', 'Environment', 'entercheck_plugin_setting_environment', 'dbi_example_plugin', 'api_settings');
		
		add_settings_section('processing_settings', 'Processing settings', 'entercheck_plugin_processing_section_text', 'dbi_example_plugin');
		
		add_settings_field('entercheck_plugin_setting_request_mode', 'Processing Mode', 'entercheck_plugin_setting_request_mode', 'dbi_example_plugin', 'processing_settings');
		add_settings_field('entercheck_plugin_setting_smart_form_id', 'Smart Form Id', 'entercheck_plugin_setting_smart_form_id', 'dbi_example_plugin', 'processing_settings');
		
		//add_settings_section('api_call', 'Test API call', 'entercheck_plugin_api_call_section_text', 'dbi_example_plugin');
		
		//add_settings_field('entercheck_plugin_setting_enterchecktoken', 'Token', 'entercheck_plugin_setting_enterchecktoken', 'dbi_example_plugin', 'api_call');

		// add meta box to user profile page
		add_action('show_user_profile', array($this, 'entercheck_user_profile_fields'));
		add_action('edit_user_profile', array($this, 'entercheck_user_profile_fields'));
		add_action('personal_options_update', array($this, 'entercheck_user_profile_fields_save'));
		add_action('edit_user_profile_update', array($this, 'entercheck_user_profile_fields_save'));
	}

	// add meta box to user profile page table Customer Organization  VAT ID, Bsuiness ID
	public function entercheck_user_profile_fields($user)
	{
		$user_id = $user->ID;
		
		$company_base = get_user_meta($user_id, 'company_base', true);
		$invoice_address = get_user_meta($user_id, 'invoice_address', true);
		if (!empty($company_base)) {
			$company_base = json_decode($company_base, true);
		}
		$company_info = get_user_meta($user_id, 'company_info', true);

		if (!empty($company_info)) {
			$company_info = json_decode($company_info, true);
		}
		if (!empty($company_info)) {
			//$uuid = $company_base['uuid'];
			if (!empty($company_base) && isset($company_base['companyId']))
				$companyId = $company_base['companyId'];
			else
				$companyId = $company_info['id'];

			// get Bsuiness ID and VAT ID from company_info
			if (isset($company_info['ids'])){
				$business_id = $company_info['ids'][0]['idValue'];
				$vat_id = $company_info['ids'][1]['idValue'];
				$status = $company_info['status'];
			} else {
				$business_id = $company_info['primaryBusinessId'];				
				$vat_id = count($company_info['additionalCompanyIds']) > 0 && !empty($company_info['additionalCompanyIds'][1]['idValue']) ? $company_info['additionalCompanyIds'][1]['idValue'] : '';
				$status = $company_info['status'];
			}
			
			$invoiceAddresses = [];			
			/*
			$company_name = "";
			$address = "";
			$operatorCode = "";
			$operator = "";
			$ovt = "";
			*/
			foreach($company_info['receivingFinvoiceAddress'] as $invoice){
				if (empty($invoice_address) || $invoice_address == $invoice['address'].' / '.$invoice['operatorCode']){
					$invoiceAddresses[] = [
						'company_name' => $invoice['name'],
						'address' => $invoice['address'],
						'operatorCode' => $invoice['operatorCode'],
						'operator' => $invoice['operator'],
						'ovt' => $invoice['ovt']	
					];
				}
			}
			
			if (empty($invoiceAddresses) && !empty($invoice_address)){
				$invoice_address_arr = explode(' / ', $invoice_address);
				$invoiceAddresses[] = [
					'company_name' => "",
					'address' => $invoice_address_arr[0] ?? '',
					'operatorCode' => $invoice_address_arr[1] ?? '',
					'operator' => '',
					'ovt' => ''
				];
			}
			
			$status = $company_info['status'];
			
			$options = get_option('enterpay_plugin_options');
			$api_domain = "portal.entercheck.eu"; 
			if (!isset($options['environment']) || empty($options['environment']) || $options['environment'] == 'test') { 
				$api_domain = "portal.test.entercheck.eu"; 
			}	

?>
			<h3><?php esc_html_e("Customer Organization", 'entercheck-company-search'); ?></h3>
			<table class="form-table">
				<tr>
					<th><label for="entercheck_vat_id"><?php esc_html_e("Link to Entercheck", 'entercheck-company-search'); ?></label></th>
					<td>
						<a target="_blank" href="https://<?php echo esc_attr($api_domain); ?>/companies/<?php echo esc_attr($companyId); ?>">Link to Entercheck</a>
					</td>
				</tr>
				<tr>
					<th><label for="entercheck_bsuiness_id"><?php esc_html_e("Bsuiness ID", 'entercheck-company-search'); ?></label></th>
					<td>
						<input type="text" name="entercheck_bsuiness_id" id="entercheck_bsuiness_id" readonly value="<?php echo esc_attr($business_id); ?>" class="regular-text" /><br />
					</td>
				</tr>
				<tr>
					<th><label for="entercheck_vat_id"><?php esc_html_e("VAT ID", 'entercheck-company-search'); ?></label></th>
					<td>
						<input type="text" name="entercheck_vat_id" id="entercheck_vat_id" readonly value="<?php echo esc_attr($vat_id); ?>" class="regular-text" /><br />
					</td>
				</tr>
				<tr>
					<th><label for="entercheck_vat_id"><?php esc_html_e("Status", 'entercheck-company-search'); ?></label></th>
					<td>
						<input type="text" name="entercheck_vat_id" id="entercheck_vat_id" readonly value="<?php echo esc_attr($status); ?>" class="regular-text" /><br />
					</td>
				</tr>
			</table>
			
			<?php 
			$ind = 1;
			foreach ($invoiceAddresses as $invoiceAddress) { ?>			
				<h3><?php esc_html_e("Invoice Address", 'entercheck-company-search'); ?> <?php if (count($invoiceAddresses) > 1) echo $ind; ?></h3>
				<table class="form-table">
					<tr>
						<th><label for="entercheck_bsuiness_id"><?php esc_html_e("Company name", 'entercheck-company-search'); ?></label></th>
						<td>
							<input type="text" readonly value="<?php echo esc_attr($invoiceAddress['company_name']); ?>" class="regular-text" /><br />
						</td>
					</tr>
					<tr>
						<th><label for="entercheck_bsuiness_id"><?php esc_html_e("Address", 'entercheck-company-search'); ?></label></th>
						<td>
							<input type="text"  readonly value="<?php echo esc_attr($invoiceAddress['address']); ?>" class="regular-text" /><br />
						</td>
					</tr>
					<tr>
						<th><label for="entercheck_vat_id"><?php esc_html_e("Operator code", 'entercheck-company-search'); ?></label></th>
						<td>
							<input type="text"  readonly value="<?php echo esc_attr($invoiceAddress['operatorCode']); ?>" class="regular-text" /><br />
						</td>
					</tr>
					<tr>
						<th><label for="entercheck_vat_id"><?php esc_html_e("Operator", 'entercheck-company-search'); ?></label></th>
						<td>
							<input type="text"  readonly value="<?php echo esc_attr($invoiceAddress['operator']); ?>" class="regular-text" /><br />
						</td>
					</tr>	
					<tr>
					<th><label for="entercheck_vat_id"><?php esc_html_e("OVT", 'entercheck-company-search'); ?></label></th>
						<td>
							<input type="text"  readonly value="<?php echo esc_attr($invoiceAddress['ovt']); ?>" class="regular-text" /><br />
						</td>				
					</tr>
				</table>
			<?php 
				$ind++;
			} 
			?> 			
<?php
		}
	}
}
