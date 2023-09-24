<?php

if ( !class_exists( 'EnterpayCompanySearchFields' ) ) {
	class EnterpayCompanySearchFields {
		public function __construct() {
			//add_action( 'admin_init', array( $this, 'register_settings') );
			
			$this->register_settings();
			$this->display_settings();
			//add_action( 'admin_menu', array( $this, 'menu_settings' ) );
		}
		
		public function register_settings(){
			register_setting( 'enterpay_plugin_options', 'enterpay_plugin_options' );
						
			
			add_settings_section('enterpay-company-search-fields_settings', '' /*__('Fields settings', 'enterpay-company-search')*/, array($this, 'settings_section_callback'), 'enterpay_plugin_options_fields' );
			add_settings_field( 'company_name', __('Company name', 'enterpay-company-search'), array($this, 'company_name_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-fields_settings' );
			add_settings_field( 'vat_number', __('VAT Number', 'enterpay-company-search'), array($this, 'vat_number_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-fields_settings' );
			add_settings_field( 'business_id', __('Business Id', 'enterpay-company-search'), array($this, 'business_id_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-fields_settings' );
			add_settings_field( 'postal_code', __('Postal code', 'enterpay-company-search'), array($this, 'postal_code_callback'), 'enterpay_plugin_options_fields', 'enterpay-company-search-fields_settings' );
		}
		
		
		public function company_name_callback(){
			$options  = get_option( 'enterpay_plugin_options', array() ); 
						
			if (!isset($options['company_name']['name'])) {
				$options['company_name']['name'] = 'billing_company';
			}
			if (!isset($options['company_name']['id'])) {
				$options['company_name']['id'] = 'billing_company';
			}
			?>
			<label for="company_name-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="company_name-name" name="enterpay_plugin_options[company_name][name]" value="<?php echo $options['company_name']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="company_name-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="company_name-id" name="enterpay_plugin_options[company_name][id]" value="<?php echo $options['company_name']['id']; ?>" />
						
			<?php
		}	

		public function vat_number_callback(){
			$options  = get_option( 'enterpay_plugin_options', array() ); 
			
			if (!isset($options['vat_number']['name'])) {
				$options['vat_number']['name'] = 'inputVATNumber';
			}
			if (!isset($options['vat_number']['id'])) {
				$options['vat_number']['id'] = 'inputVATNumber';
			}
			?>
			<label for="vat_number-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="vat_number-name" name="enterpay_plugin_options[vat_number][name]" value="<?php echo $options['vat_number']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="vat_number-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="vat_number-id" name="enterpay_plugin_options[vat_number][id]" value="<?php echo $options['vat_number']['id']; ?>" />
						
			<?php
		}	
		
		public function business_id_callback(){
			$options  = get_option( 'enterpay_plugin_options', array() ); 
			
			if (!isset($options['business_id']['name'])) {
				$options['business_id']['name'] = 'inputBusinessId';
			}
			if (!isset($options['business_id']['id'])) {
				$options['business_id']['id'] = 'inputBusinessId';
			}
			?>
			<label for="business_id-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="business_id-name" name="enterpay_plugin_options[business_id][name]" value="<?php echo $options['business_id']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="business_id-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="business_id-id" name="enterpay_plugin_options[business_id][id]" value="<?php echo $options['business_id']['id']; ?>" />
						
			<?php
		}
		
		public function business_id_callback(){
			$options  = get_option( 'enterpay_plugin_options', array() ); 
			
			if (!isset($options['business_id']['name'])) {
				$options['business_id']['name'] = 'inputBusinessId';
			}
			if (!isset($options['business_id']['id'])) {
				$options['business_id']['id'] = 'inputBusinessId';
			}
			?>
			<label for="business_id-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="business_id-name" name="enterpay_plugin_options[business_id][name]" value="<?php echo $options['business_id']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="business_id-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="business_id-id" name="enterpay_plugin_options[business_id][id]" value="<?php echo $options['business_id']['id']; ?>" />
						
			<?php
		}			
		
		public function postal_code_callback(){
			$options  = get_option( 'enterpay_plugin_options', array() ); 
			
			if (!isset($options['postal_code']['name'])) {
				$options['postal_code']['name'] = 'billing_postcode';
			}
			if (!isset($options['postal_code']['id'])) {
				$options['postal_code']['id'] = 'billing_postcode';
			}
			?>
			<label for="postal_code-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
			<input type="text" id="postal_code-name" name="enterpay_plugin_options[postal_code][name]" value="<?php echo $options['postal_code']['name']; ?>" />&nbsp;&nbsp;&nbsp;
			<label for="postal_code-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
			<input type="text" id="postal_code-id" name="enterpay_plugin_options[postal_code][id]" value="<?php echo $options['postal_code']['id']; ?>" />
						
			<?php
		}
		
				
		
		public function settings_section_callback(){}
				
		function display_settings(){ ?>
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action='options.php' method='post'> <?php
				//settings_fields( 'enterpay-company-search-fields' );
				settings_fields( 'enterpay_plugin_options' );
				
				do_settings_sections( 'enterpay_plugin_options_fields' );
				submit_button(); ?>
			</form>
			
			<?php
		}		
	}
}

new EnterpayCompanySearchFields();