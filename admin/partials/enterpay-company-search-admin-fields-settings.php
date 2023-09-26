<?php

if ( !class_exists( 'EnterpayCompanySearchFields' ) ) {
	class EnterpayCompanySearchFields {
		public function __construct() {
			add_action( 'admin_init', array( $this, 'register_settings') );
			
			//$this->register_settings();
			//$this->display_settings();
			add_action( 'admin_menu', array( $this, 'menu_settings' ), 999 );
		}
		
		public function menu_settings(){
			add_submenu_page('enterpay-company-search-entercheck', 'Field settings', 'Field settings', 'manage_options', 'enterpay-company-search-enterpay-fields', array($this, 'display_settings'));
			/*
			$page = add_options_page(
				'Field settings',
				'Field settings',
				'manage_options',
				'enterpay_plugin_options_fields',
				array($this,'display_settings')
			);
			*/
		}
		
		public function register_settings(){
			register_setting( 'enterpay_plugin_options_fields', 'enterpay_plugin_options_fields' );
						
			
			add_settings_section('enterpay-company-search-fields_settings', '' /*__('Fields settings', 'enterpay-company-search')*/, array($this, 'settings_section_callback'), 'enterpay_plugin_options_fields' );
			add_settings_field( 'company_name', __('Company name', 'enterpay-company-search'), array($this, 'company_name_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-fields_settings' );
			add_settings_field( 'vat_number', __('VAT Number', 'enterpay-company-search'), array($this, 'vat_number_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-fields_settings' );
			add_settings_field( 'business_id', __('Business Id', 'enterpay-company-search'), array($this, 'business_id_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-fields_settings' );
			add_settings_field( 'business_line', __('Business Line', 'enterpay-company-search'), array($this, 'business_line_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-fields_settings' );
			
			add_settings_section('enterpay-company-search-relevant-company-fields_settings', __('Relevant company fields', 'enterpay-company-search'), array($this, 'settings_section_callback'), 'enterpay_plugin_options_fields' );
			add_settings_field( 'country', __('Country', 'enterpay-company-search'), array($this, 'country_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-relevant-company-fields_settings' );
			add_settings_field( 'city', __('City', 'enterpay-company-search'), array($this, 'city_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-relevant-company-fields_settings' );
			add_settings_field( 'street', __('Street', 'enterpay-company-search'), array($this, 'street_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-relevant-company-fields_settings' );
			add_settings_field( 'street_second', __('Street second row', 'enterpay-company-search'), array($this, 'street_second_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-relevant-company-fields_settings' );
			add_settings_field( 'postal_code', __('Postal code', 'enterpay-company-search'), array($this, 'postal_code_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-relevant-company-fields_settings' );
		}
		
		
		public function company_name_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
			//if (!isset($options['company_name'])) $options['company_name'] = [];
				
			if (!isset($options['company_name']['name'])) {
				
				$options['company_name']['name'] = 'billing_company';
			}
			if (!isset($options['company_name']['id'])) {
				$options['company_name']['id'] = 'billing_company';
			}
			?>
			<label for="company_name-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="company_name-name" name="enterpay_plugin_options_fields[company_name][name]" value="<?php echo $options['company_name']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="company_name-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="company_name-id" name="enterpay_plugin_options_fields[company_name][id]" value="<?php echo $options['company_name']['id']; ?>" />
						
			<?php
		}	

		public function vat_number_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
			
			if (!isset($options['vat_number']['name'])) {
				$options['vat_number']['name'] = 'inputVATNumber';
			}
			if (!isset($options['vat_number']['id'])) {
				$options['vat_number']['id'] = 'inputVATNumber';
			}
			?>
			<label for="vat_number-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="vat_number-name" name="enterpay_plugin_options_fields[vat_number][name]" value="<?php echo $options['vat_number']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="vat_number-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="vat_number-id" name="enterpay_plugin_options_fields[vat_number][id]" value="<?php echo $options['vat_number']['id']; ?>" />
						
			<?php
		}	
		
		public function business_id_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
			
			if (!isset($options['business_id']['name'])) {
				$options['business_id']['name'] = 'inputBusinessId';
			}
			if (!isset($options['business_id']['id'])) {
				$options['business_id']['id'] = 'inputBusinessId';
			}
			?>
			<label for="business_id-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="business_id-name" name="enterpay_plugin_options_fields[business_id][name]" value="<?php echo $options['business_id']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="business_id-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="business_id-id" name="enterpay_plugin_options_fields[business_id][id]" value="<?php echo $options['business_id']['id']; ?>" />
						
			<?php
		}
		
		public function business_line_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
			
			if (!isset($options['business_line']['name'])) {
				$options['business_line']['name'] = 'companyBusinessLine';
			}
			if (!isset($options['business_line']['id'])) {
				$options['business_line']['id'] = 'companyBusinessLine';
			}
			?>
			<label for="business_line-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="business_line-name" name="enterpay_plugin_options_fields[business_line][name]" value="<?php echo $options['business_line']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="business_line-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="business_line-id" name="enterpay_plugin_options_fields[business_line][id]" value="<?php echo $options['business_line']['id']; ?>" />
						
			<?php
		}
		
			

		public function country_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
			
			if (!isset($options['country']['name'])) {
				$options['country']['name'] = 'billing_country';
			}
			if (!isset($options['country']['id'])) {
				$options['country']['id'] = 'billing_country';
			}
			?>
			<label for="country-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="country-name" name="enterpay_plugin_options_fields[country][name]" value="<?php echo $options['country']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="country-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="country-id" name="enterpay_plugin_options_fields[country][id]" value="<?php echo $options['country']['id']; ?>" />
						
			<?php
		}

		public function city_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
			
			if (!isset($options['city']['name'])) {
				$options['city']['name'] = 'billing_city';
			}
			if (!isset($options['city']['id'])) {
				$options['city']['id'] = 'billing_city';
			}
			?>
			<label for="city-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="city-name" name="enterpay_plugin_options_fields[city][name]" value="<?php echo $options['city']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="city-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="city-id" name="enterpay_plugin_options_fields[city][id]" value="<?php echo $options['city']['id']; ?>" />
						
			<?php
		}

		public function street_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
			
			if (!isset($options['street']['name'])) {
				$options['street']['name'] = 'billing_address_1';
			}
			if (!isset($options['street']['id'])) {
				$options['street']['id'] = 'billing_address_1';
			}
			?>
			<label for="street-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="street-name" name="enterpay_plugin_options_fields[street][name]" value="<?php echo $options['street']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="street-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="street-id" name="enterpay_plugin_options_fields[street][id]" value="<?php echo $options['street']['id']; ?>" />
						
			<?php
		}

		public function street_second_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
			
			if (!isset($options['street_second']['name'])) {
				$options['street_second']['name'] = 'billing_address_2';
			}
			if (!isset($options['street_second']['id'])) {
				$options['street_second']['id'] = 'billing_address_2';
			}
			?>
			<label for="street_second-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="street_second-name" name="enterpay_plugin_options_fields[street_second][name]" value="<?php echo $options['street_second']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="street_second-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="street_second-id" name="enterpay_plugin_options_fields[street_second][id]" value="<?php echo $options['street_second']['id']; ?>" />
						
			<?php
		}		
				
		public function postal_code_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
			
			if (!isset($options['postal_code']['name'])) {
				$options['postal_code']['name'] = 'billing_postcode';
			}
			if (!isset($options['postal_code']['id'])) {
				$options['postal_code']['id'] = 'billing_postcode';
			}
			?>
			<label for="postal_code-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="postal_code-name" name="enterpay_plugin_options_fields[postal_code][name]" value="<?php echo $options['postal_code']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="postal_code-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="postal_code-id" name="enterpay_plugin_options_fields[postal_code][id]" value="<?php echo $options['postal_code']['id']; ?>" />
						
			<?php
		}
		
				
		
		public function settings_section_callback(){}
				
		function display_settings(){ ?>
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<div id="preset_wc_fields"><?php _e('Click here to add fields to WooCommerce checkout', 'enterpay-company-search'); ?></div>
			
			<form action='options.php' method='post'> <?php
				//settings_fields( 'enterpay-company-search-fields' );
				settings_fields( 'enterpay_plugin_options_fields' );
				
				do_settings_sections( 'enterpay_plugin_options_fields' );
				do_settings_sections( 'enterpay_plugin_options_company_fields' );
				submit_button(); ?>
			</form>
			
			<?php
		}		
	}
}

new EnterpayCompanySearchFields();