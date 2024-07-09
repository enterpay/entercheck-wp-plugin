<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'EntercheckCompanySearchFields' ) ) {
	class EntercheckCompanySearchFields {
		public function __construct() {
			add_action( 'admin_init', array( $this, 'register_settings') );
			
			//$this->register_settings();
			//$this->display_settings();
			add_action( 'admin_menu', array( $this, 'menu_settings' ), 999 );
		}
		
		public function menu_settings(){
			add_submenu_page('entercheck-company-search-entercheck', 'Field settings', 'Field settings', 'manage_options', 'entercheck-company-search-entercheck-fields', array($this, 'display_settings'));
			/*
			$page = add_options_page(
				'Field settings',
				'Field settings',
				'manage_options',
				'entercheck_plugin_options_fields',
				array($this,'display_settings')
			);
			*/
		}
		
		public function register_settings(){
			register_setting( 'entercheck_plugin_options_fields', 'entercheck_plugin_options_fields', [$this, 'sanitize'] );
						
			
			add_settings_section('entercheck-company-search-company_search', esc_attr__('Company search', 'entercheck-company-search'), array($this, 'company_name_section_callback'), 'entercheck_plugin_options_fields', [
				'after_section' => '<p class="after_field">Company id can be prefilled for the customer and backend processing by defining the field name and id.</p>'
			] );
			add_settings_field( 'entercheck_company_name', esc_attr__('Company name', 'entercheck-company-search'), array($this, 'company_name_callback'), 'entercheck_plugin_options_fields', 'entercheck-company-search-company_search' );
			
			add_settings_section('entercheck-company-search-business_id_search', '' /*esc_attr__('Company search', 'entercheck-company-search')*/, array($this, 'business_id_name_section_callback'), 'entercheck_plugin_options_fields' );
			add_settings_field( 'entercheck_business_id', esc_attr__('Business Id', 'entercheck-company-search'), array($this, 'business_id_callback'), 'entercheck_plugin_options_fields', 'entercheck-company-search-business_id_search' );
			add_settings_field( 'entercheck_use_advanced_search', esc_attr__('Use Advanced Search', 'entercheck-company-search'), array($this, 'use_advanced_search_callback'), 'entercheck_plugin_options_fields', 'entercheck-company-search-business_id_search' );
			
			

			
			add_settings_section('entercheck-search-country_fields_settings', esc_attr__('Regional Settings', 'entercheck-company-search'), array($this, 'settings_section_callback'), 'entercheck_plugin_options_fields' );
			add_settings_field( 'entercheck_search_country', esc_attr__('Country Selection', 'entercheck-company-search'), array($this, 'search_country_callback'), 'entercheck_plugin_options_fields', 'entercheck-search-country_fields_settings' );
			add_settings_field( 'entercheck_default_country', esc_attr__('Default country', 'entercheck-company-search'), array($this, 'default_country_callback'), 'entercheck_plugin_options_fields', 'entercheck-search-country_fields_settings');
			add_settings_field( 'entercheck_allow_search_country', esc_attr__('Enable Searching Multiple Regions', 'entercheck-company-search'), array($this, 'allow_search_country_callback'), 'entercheck_plugin_options_fields', 'entercheck-search-country_fields_settings' );
			add_settings_field( 'entercheck_search_country_list', esc_attr__('Allowed Countries', 'entercheck-company-search'), array($this, 'search_country_list_callback'), 'entercheck_plugin_options_fields', 'entercheck-search-country_fields_settings' );




						
			add_settings_section('entercheck-company-search-prefill_settings', esc_attr__('Prefill Settings', 'entercheck-company-search'), array($this, 'prefill_settings_section_callback'), 'entercheck_plugin_options_fields' );
			//echo '<h3>Relevant company fields</h3>';
			add_settings_field( 'entercheck_business_line', esc_attr__('Business Line', 'entercheck-company-search'), array($this, 'business_line_callback'), 'entercheck_plugin_options_fields', 'entercheck-company-search-prefill_settings' );
			add_settings_field( 'entercheck_vat_number', esc_attr__('VAT Number', 'entercheck-company-search'), array($this, 'vat_number_callback'), 'entercheck_plugin_options_fields', 'entercheck-company-search-prefill_settings' );
			
			//echo '<h3>Billing address</h3>';
			add_settings_section('entercheck-company-search-relevant-company-fields_settings', '' /*esc_attr__('Relevant company fields', 'entercheck-company-search')*/, array($this, 'billing_section_callback'), 'entercheck_plugin_options_fields' );
			add_settings_field( 'entercheck_country', esc_attr__('Country', 'entercheck-company-search'), array($this, 'country_callback'), 'entercheck_plugin_options_fields', 'entercheck-company-search-relevant-company-fields_settings' );
			add_settings_field( 'entercheck_city', esc_attr__('City', 'entercheck-company-search'), array($this, 'city_callback'), 'entercheck_plugin_options_fields', 'entercheck-company-search-relevant-company-fields_settings' );
			add_settings_field( 'entercheck_street', esc_attr__('Street', 'entercheck-company-search'), array($this, 'street_callback'), 'entercheck_plugin_options_fields', 'entercheck-company-search-relevant-company-fields_settings' );
			add_settings_field( 'entercheck_street_second', esc_attr__('Street second row', 'entercheck-company-search'), array($this, 'street_second_callback'), 'entercheck-company-search-relevant-company-fields_settings' );
			add_settings_field( 'entercheck_postal_code', esc_attr__('Postal code', 'entercheck-company-search'), array($this, 'postal_code_callback'), 'entercheck_plugin_options_fields', 'entercheck-company-search-relevant-company-fields_settings' );
			
			//echo '<h3>Invoice address</h3>';
			add_settings_section('entercheck-invoice-company-fields_settings', '', array($this, 'invoice_section_callback'), 'entercheck_plugin_options_fields' );
			add_settings_field( 'entercheck_invoice_selector', esc_attr__('Invoice selector', 'entercheck-company-search'), array($this, 'invoice_selector_callback'), 'entercheck_plugin_options_fields', 'entercheck-invoice-company-fields_settings' );
			add_settings_field( 'entercheck_invoice_address', esc_attr__('Invoice address', 'entercheck-company-search'), array($this, 'invoice_address_callback'), 'entercheck_plugin_options_fields', 'entercheck-invoice-company-fields_settings' );
			add_settings_field( 'entercheck_invoice_operator_code', esc_attr__('Invoice operator code', 'entercheck-company-search'), array($this, 'invoice_operator_code_callback'), 'entercheck_plugin_options_fields', 'entercheck-invoice-company-fields_settings' );

		}
		
		public function sanitize( $input )
		{
			$fields = ['company_name', 'vat_number', 'business_id', 'business_line', 'country', 'city', 'street', 'street_second', 'postal_code', 'invoice_selector', 'invoice_address', 'invoice_operator_code', 'search_country', 'search_country_list']; 
						
			foreach ($fields as $field){
				if( isset( $input[$field]['id'] ) ){ $input[$field]['id'] = implode(',', array_unique(array_map('trim', explode(',', $input[$field]['id'])))); }
				if( isset( $input[$field]['name'] ) ){ $input[$field]['name'] = implode(',', array_unique(array_map('trim', explode(',', $input[$field]['name'])))); }
				//if( isset( $input[$field]['tooltip'] ) ){ $input[$field]['tooltip'] = $input[$field]['name']; }
				
				if ($field == 'business_id'){
					if( isset( $input[$field]['auto'] ) && $input[$field]['auto'] == 1 ) $input[$field]['auto'] = 1; else $input[$field]['auto'] = 0;
				}
				
				if ($field == 'allow_search_country'){
					if( isset( $input['allow_search_country'] ) && $input['allow_search_country'] == 1 ) $input['allow_search_country'] = 1; else $input['allow_search_country'] = 0;
				}
				
				if ($field == 'use_advanced_search'){
					if( isset( $input['use_advanced_search'] ) && $input['use_advanced_search'] == 1 ) $input['use_advanced_search'] = 1; else $input['use_advanced_search'] = 0;
				}
				
				if ($field == 'search_country_list'){
					if( isset( $input['search_country_list'] ) && is_array($input['search_country_list']))	$input['search_country_list'] = implode(',', $input['search_country_list']);
					else $input['search_country_list'] = '';
				}
				
			}
			/*
			if( isset( $input['company_name']['id'] ) ){ 
				array_map('trim', explode(',', $input['company_name']['id'])); 
				$options['company_name']['id'] = 
			}
			if( isset( $input['company_name']['name'] ) ){ $options['company_name']['name'] = array_map('trim', explode(',', $input['company_name']['name'])); }
			if( isset( $input['vat_number']['id'] ) ){ $options['vat_number']['id'] = array_map('trim', explode(',', $input['vat_number']['id'])); }
			if( isset( $input['vat_number']['name'] ) ){ $options['vat_number']['name'] = array_map('trim', explode(',', $input['vat_number']['name'])); }
			if( isset( $input['business_id']['id'] ) ){ $options['business_id']['id'] = array_map('trim', explode(',', $input['business_id']['id'])); }
			if( isset( $input['business_id']['name'] ) ){ $options['business_id']['name'] = array_map('trim', explode(',', $input['business_id']['name'])); }
			if( isset( $input['business_line']['id'] ) ){ $options['business_line']['id'] = array_map('trim', explode(',', $input['business_line']['id'])); }
			if( isset( $input['business_line']['name'] ) ){ $options['business_line']['name'] = array_map('trim', explode(',', $input['business_line']['name'])); }
			
			if( isset( $input['country']['id'] ) ){ $options['country']['id'] = array_map('trim', explode(',', $input['country']['id'])); }
			if( isset( $input['country']['name'] ) ){ $options['country']['name'] = array_map('trim', explode(',', $input['country']['name'])); }
			if( isset( $input['city']['id'] ) ){ $options['city']['id'] = array_map('trim', explode(',', $input['city']['id'])); }
			if( isset( $input['city']['name'] ) ){ $options['city']['name'] = array_map('trim', explode(',', $input['city']['name'])); }
			if( isset( $input['street']['id'] ) ){ $options['street']['id'] = array_map('trim', explode(',', $input['street']['id'])); }
			if( isset( $input['street']['name'] ) ){ $options['street']['name'] = array_map('trim', explode(',', $input['street']['name'])); }
			if( isset( $input['street_second']['id'] ) ){ $options['street_second']['id'] = array_map('trim', explode(',', $input['street_second']['id'])); }
			if( isset( $input['street_second']['name'] ) ){ $options['street_second']['name'] = array_map('trim', explode(',', $input['street_second']['name'])); }
			if( isset( $input['postal_code']['id'] ) ){ $options['postal_code']['id'] = array_map('trim', explode(',', $input['postal_code']['id'])); }
			if( isset( $input['postal_code']['name'] ) ){ $options['postal_code']['name'] = array_map('trim', explode(',', $input['postal_code']['name'])); }
*/
			return $input;
		}
		
		public function company_name_section_callback(){
			echo '<p class="before_field">Definie a field here and the company search dropdown will appear to the specified form element.</p>';
		}
		public function business_id_name_section_callback(){
			echo '<p class="before_field">It can be automatically specified as a hidden field for backend processing by selecting "add automatically"</p>';
		}
		
		public function prefill_settings_section_callback(){
			echo '<h3>Relevant company fields</h3>';
		}
		
		public function invoice_section_callback(){
			//echo '<h3>Relevant company fields</h3>';
			echo '<h3>Invoice address</h3>';
		}
		
		public function billing_section_callback(){
			//echo '<h3>Relevant company fields</h3>';
			echo '<h3>Billing address</h3>';
		}
		
		
		public function company_name_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			//if (!isset($options['company_name'])) $options['company_name'] = [];
				
			if (!isset($options['company_name']['name'])) {
				
				$options['company_name']['name'] = 'billing_company';
			}
			if (!isset($options['company_name']['id'])) {
				$options['company_name']['id'] = 'billing_company';
			}
			if (!isset($options['company_name']['tooltip'])) {
				$options['company_name']['tooltip'] = 'Search for your company details by typing a search phrase to the box';
			}
			
			// class="regular-text" 
			?>
			<div class="box_row">
				<label for="company_name-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
				<input type="text" id="company_name-name" name="entercheck_plugin_options_fields[company_name][name]" value="<?php echo esc_html($options['company_name']['name']); ?>" />
			</div>
			<div class="box_row">
				<label for="company_name-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="company_name-id" name="entercheck_plugin_options_fields[company_name][id]" value="<?php echo esc_html($options['company_name']['id']); ?>" />
			</div>
			<div class="box_row">
				<label for="company_name-tooltip"><?php esc_html_e('ToolTip', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="company_name-tooltip" name="entercheck_plugin_options_fields[company_name][tooltip]" value="<?php echo esc_html($options['company_name']['tooltip']); ?>" />
			</div>				
			<?php
		}	

		public function vat_number_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['vat_number']['name'])) {
				$options['vat_number']['name'] = 'inputVATNumber';
			}
			if (!isset($options['vat_number']['id'])) {
				$options['vat_number']['id'] = 'inputVATNumber';
			}
			?>
			<div class="box_row">
				<label for="vat_number-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
				<input type="text" id="vat_number-name" name="entercheck_plugin_options_fields[vat_number][name]" value="<?php echo esc_html($options['vat_number']['name']); ?>" />
			</div>
			<div class="box_row">
				<label for="vat_number-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="vat_number-id" name="entercheck_plugin_options_fields[vat_number][id]" value="<?php echo esc_html($options['vat_number']['id']); ?>" />
			</div>			
			<?php
		}	
		
		public function business_id_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['business_id']['name'])) {
				$options['business_id']['name'] = 'inputBusinessId';
			}
			if (!isset($options['business_id']['id'])) {
				$options['business_id']['id'] = 'inputBusinessId';
			}
			if (!isset($options['business_id']['auto'])) {
				$options['business_id']['auto'] = '0';
			}
			?>
			<div class="box_row">
				<label for="business_id-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
				<input type="text" id="business_id-name" name="entercheck_plugin_options_fields[business_id][name]" value="<?php echo esc_html($options['business_id']['name']); ?>" />
			</div>
			<div class="box_row">
				<label for="business_id-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="business_id-id" name="entercheck_plugin_options_fields[business_id][id]" value="<?php echo esc_html($options['business_id']['id']); ?>" />
			</div>
			<div class="box_row">					
				<input type="checkbox" <?php if ($options['business_id']['auto'] == 1) echo 'checked'; ?> id="business_id-auto" name="entercheck_plugin_options_fields[business_id][auto]" value="1" />
				<label class="chb" for="business_id-auto"><?php esc_html_e('Add automatically', 'entercheck-company-search'); ?></label>
			</div>				
			<?php
		}
		
		public function use_advanced_search_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
						
			if (!isset($options['use_advanced_search'])) {
				$options['use_advanced_search'] = '0';
			}
			?>			
			<div class="box_row">					
				<input type="checkbox" <?php if ($options['use_advanced_search'] == 1) echo 'checked'; ?> id="use_advanced_search" name="entercheck_plugin_options_fields[use_advanced_search]" value="1" />
			</div>				
			<?php
		}
		
		public function business_line_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['business_line']['name'])) {
				$options['business_line']['name'] = 'companyBusinessLine';
			}
			if (!isset($options['business_line']['id'])) {
				$options['business_line']['id'] = 'companyBusinessLine';
			}
			?>
			<div class="box_row">
				<label for="business_line-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
				<input type="text" id="business_line-name" name="entercheck_plugin_options_fields[business_line][name]" value="<?php echo esc_html($options['business_line']['name']); ?>" />
			</div>
			<div class="box_row">
				<label for="business_line-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="business_line-id" name="entercheck_plugin_options_fields[business_line][id]" value="<?php echo esc_html($options['business_line']['id']); ?>" />
			</div>			
			<?php
		}
		
			

		public function country_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['country']['name'])) {
				$options['country']['name'] = 'billing_country';
			}
			if (!isset($options['country']['id'])) {
				$options['country']['id'] = 'billing_country';
			}
			?>
			
			<div class="box_row">
				<label for="country-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
				<input type="text" id="country-name" name="entercheck_plugin_options_fields[country][name]" value="<?php echo esc_html($options['country']['name']); ?>" />
			</div>
			<div class="box_row">
				<label for="country-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="country-id" name="entercheck_plugin_options_fields[country][id]" value="<?php echo esc_html($options['country']['id']); ?>" />
			</div>			
			<?php
		}

		public function city_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['city']['name'])) {
				$options['city']['name'] = 'billing_city';
			}
			if (!isset($options['city']['id'])) {
				$options['city']['id'] = 'billing_city';
			}
			?>
			<div class="box_row">
				<label for="city-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
				<input type="text" id="city-name" name="entercheck_plugin_options_fields[city][name]" value="<?php echo esc_html($options['city']['name']); ?>" />
			</div>
			<div class="box_row">
				<label for="city-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="city-id" name="entercheck_plugin_options_fields[city][id]" value="<?php echo esc_html($options['city']['id']); ?>" />
			</div>			
			<?php
		}

		public function street_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['street']['name'])) {
				$options['street']['name'] = 'billing_address_1';
			}
			if (!isset($options['street']['id'])) {
				$options['street']['id'] = 'billing_address_1';
			}
			?>
			<div class="box_row">
				<label for="street-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
				<input type="text" id="street-name" name="entercheck_plugin_options_fields[street][name]" value="<?php echo esc_html($options['street']['name']); ?>" />
			</div>
			<div class="box_row">
				<label for="street-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="street-id" name="entercheck_plugin_options_fields[street][id]" value="<?php echo esc_html($options['street']['id']); ?>" />
			</div>			
			<?php
		}

		public function street_second_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['street_second']['name'])) {
				$options['street_second']['name'] = 'billing_address_2';
			}
			if (!isset($options['street_second']['id'])) {
				$options['street_second']['id'] = 'billing_address_2';
			}
			?>
			<div class="box_row">
				<label for="street_second-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
				<input type="text" id="street_second-name" name="entercheck_plugin_options_fields[street_second][name]" value="<?php echo esc_html($options['street_second']['name']); ?>" />
			</div>
			<div class="box_row">
				<label for="street_second-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="street_second-id" name="entercheck_plugin_options_fields[street_second][id]" value="<?php echo esc_html($options['street_second']['id']); ?>" />
			</div>	
			<?php
		}		
				
		public function postal_code_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['postal_code']['name'])) {
				$options['postal_code']['name'] = 'billing_postcode';
			}
			if (!isset($options['postal_code']['id'])) {
				$options['postal_code']['id'] = 'billing_postcode';
			}
			?>
			<div class="box_row">
				<label for="postal_code-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
				<input type="text" id="postal_code-name" name="entercheck_plugin_options_fields[postal_code][name]" value="<?php echo esc_html($options['postal_code']['name']); ?>" />
			</div>
			<div class="box_row">
				<label for="postal_code-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="postal_code-id" name="entercheck_plugin_options_fields[postal_code][id]" value="<?php echo esc_html($options['postal_code']['id']); ?>" />
			</div>			
			<?php
		}
		
		public function display_invoice_address_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
						
			if (!isset($options['display_invoice_address'])) {
				$options['display_invoice_address'] = '0';
			}
			?>			
			<div class="box_row">					
				<input type="checkbox" <?php if ($options['display_invoice_address'] == 1) echo 'checked'; ?> id="display_invoice_address" name="entercheck_plugin_options_fields[display_invoice_address]" value="1" />
				<!--<label class="chb" for="display_invoice_address"><?php esc_html_e('Display invoice address', 'entercheck-company-search'); ?></label>-->
			</div>				
			<?php
		}
		
		public function invoice_selector_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['invoice_selector']['name'])) {
				$options['invoice_selector']['name'] = 'invoice_selector';
			}
			if (!isset($options['invoice_selector']['id'])) {
				$options['invoice_selector']['id'] = 'invoice_selector';
			}
			?>
			<div class="box_row">
				<label for="invoice_selector-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
				<input type="text" id="invoice_selector-name" name="entercheck_plugin_options_fields[invoice_selector][name]" value="<?php echo esc_html($options['invoice_selector']['name']); ?>" />
			</div>
			<div class="box_row">
				<label for="invoice_selector-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="invoice_selector-id" name="entercheck_plugin_options_fields[invoice_selector][id]" value="<?php echo esc_html($options['invoice_selector']['id']); ?>" />
			</div>
			<?php
		}
		
		public function invoice_address_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['invoice_address']['name'])) {
				$options['invoice_address']['name'] = 'invoice_address';
			}
			if (!isset($options['invoice_address']['id'])) {
				$options['invoice_address']['id'] = 'invoice_address';
			}
			?>
			<div class="box_row">
				<label for="invoice_address-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
				<input type="text" id="invoice_address-name" name="entercheck_plugin_options_fields[invoice_address][name]" value="<?php echo esc_html($options['invoice_address']['name']); ?>" />
			</div>
			<div class="box_row">
				<label for="invoice_address-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="invoice_address-id" name="entercheck_plugin_options_fields[invoice_address][id]" value="<?php echo esc_html($options['invoice_address']['id']); ?>" />
			</div>
			<?php
		}
		
		public function invoice_operator_code_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['invoice_operator_code']['name'])) {
				$options['invoice_operator_code']['name'] = 'invoice_operator_code';
			}
			if (!isset($options['invoice_operator_code']['id'])) {
				$options['invoice_operator_code']['id'] = 'invoice_operator_code';
			}
			?>
			<div class="box_row">
				<label for="invoice_operator_code-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
				<input type="text" id="invoice_operator_code-name" name="entercheck_plugin_options_fields[invoice_operator_code][name]" value="<?php echo esc_html($options['invoice_operator_code']['name']); ?>" />
			</div>
			<div class="box_row">
				<label for="invoice_operator_code-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
				<input type="text" id="invoice_operator_code-id" name="entercheck_plugin_options_fields[invoice_operator_code][id]" value="<?php echo esc_html($options['invoice_operator_code']['id']); ?>" />
			</div>
			<?php
		}
					

		// Search country
		
		public function default_country_callback(){
			$options = get_option('entercheck_plugin_options_fields', array());
			
			if (!isset($options['default_country'])) { $options['default_country'] = "FI"; }		
			?>
			<div class="box_row">
				<select name="entercheck_plugin_options_fields[default_country]">
					<?php foreach(EntercheckCountry::getInstance()->get_country_list() as $code=>$name) { ?>
					<option value="<?php echo esc_html($code); ?>" <?php if ($options['default_country'] == $code) echo 'selected="selected"'; ?>><?php echo esc_html($name); ?></option>
					<?php } ?>
				</select>
			</div>	
			<?php 		
			
		}		
		
		public function allow_search_country_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
						
			if (!isset($options['allow_search_country'])) {
				$options['allow_search_country'] = '0';
			}
			?>			
			<div class="box_row">					
				<input type="checkbox" <?php if ($options['allow_search_country'] == 1) echo 'checked'; ?> id="allow_search_country" name="entercheck_plugin_options_fields[allow_search_country]" value="1" />
				<!--<label class="chb" for="display_invoice_address"><?php esc_html_e('Display invoice address', 'entercheck-company-search'); ?></label>-->
			</div>				
			<?php
		}

		public function search_country_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['search_country']['name'])) {
				$options['search_country']['name'] = 'search_country';
			}
			if (!isset($options['search_country']['id'])) {
				$options['search_country']['id'] = 'search_country';
			}
			?>
			<div class="display_search_country_box">
				<div class="box_row">
					<label for="search_country-name"><?php esc_html_e('Field name', 'entercheck-company-search'); ?>:</label>
					<input type="text" id="search_country-name" name="entercheck_plugin_options_fields[search_country][name]" value="<?php echo esc_html($options['search_country']['name']); ?>" />
				</div>
				<div class="box_row">
					<label for="search_country-id"><?php esc_html_e('Field ID', 'entercheck-company-search'); ?>:</label>			
					<input type="text" id="search_country-id" name="entercheck_plugin_options_fields[search_country][id]" value="<?php echo esc_html($options['search_country']['id']); ?>" />
				</div>
			</div>
			<?php
		}

		public function search_country_list_callback(){
			$options  = get_option( 'entercheck_plugin_options_fields', array() ); 
			
			if (!isset($options['search_country_list'])) {
				$options['search_country_list'] = '';
			}
			$search_country_list = array_filter(explode(',', $options['search_country_list']));
			$country_list = EntercheckCountry::getInstance()->get_country_list();
			
			?>
			<div class="display_search_country_box">
				<div class="box_row">
					<div class="search_country_container">
						<?php foreach($search_country_list as $code) { ?>
							<div class="search_country_item">
								<input type="checkbox" id="search_country_list_<?php echo esc_html($code); ?>" checked name="entercheck_plugin_options_fields[search_country_list][]" value="<?php echo esc_html($code); ?>" />
								<label class="chb" for="search_country_list_<?php echo esc_html($code); ?>"><?php echo isset($country_list[$code]) ? esc_html($country_list[$code]) : ''; ?></label>
							</div>
						<?php } ?>		
						<?php foreach($country_list as $code => $name) { 
								if (!in_array($code, $search_country_list)) {
						?>
							<div class="search_country_item">
								<input type="checkbox" id="search_country_list_<?php echo esc_html($code); ?>" name="entercheck_plugin_options_fields[search_country_list][]" value="<?php echo esc_html($code); ?>" />
								<label class="chb" for="search_country_list_<?php echo esc_html($code); ?>"><?php echo esc_html($name); ?></label>
							</div>								
						<?php } } ?>	
					</div>
				</div>
			</div>
			<?php
		}	
		
		public function settings_section_callback(){}
				
		function display_settings(){ ?>
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<h4>Please enter the unique identifier of the element you want to modify in both the field_id and field_name cells. To enable functionality in multiple forms, you can add multiple values separated by a comma.</h4>
			<h4>Company search funcntionality is mandatory</h4>
			<!--<div id="preset_wc_fields"><?php esc_html_e('Click here to add fields to WooCommerce checkout', 'entercheck-company-search'); ?></div>-->
			
			<div id="field_settings_block">
				<form action='options.php' method='post'> <?php
					settings_fields( 'entercheck_plugin_options_fields' );
					
					do_settings_sections( 'entercheck_plugin_options_fields' );
					do_settings_sections( 'entercheck_plugin_options_company_fields' );
					submit_button(); ?>
				</form>
			</div>
			
			<input type="button" class="button button-primary" id="preset_wc_fields" value="Add default WooCommerce fields">
			
			<?php
		}		
	}
}

new EntercheckCompanySearchFields();