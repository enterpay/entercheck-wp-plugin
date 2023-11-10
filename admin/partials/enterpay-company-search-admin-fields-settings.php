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
			register_setting( 'enterpay_plugin_options_fields', 'enterpay_plugin_options_fields', [$this, 'sanitize'] );
						
			
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
			
			add_settings_section('enterpay-invoice-company-fields_settings', __('Invoice address', 'enterpay-company-search'), array($this, 'settings_section_callback'), 'enterpay_plugin_options_fields' );
			//add_settings_field( 'display_invoice_address', __('Display invoice address', 'enterpay-company-search'), array($this, 'display_invoice_address_callback'), 'enterpay_plugin_options_fields', 'enterpay-invoice-company-fields_settings' );
			add_settings_field( 'invoice_selector', __('Invoice selector', 'enterpay-company-search'), array($this, 'invoice_selector_callback'), 'enterpay_plugin_options_fields', 'enterpay-invoice-company-fields_settings' );
			add_settings_field( 'invoice_address', __('Invoice address', 'enterpay-company-search'), array($this, 'invoice_address_callback'), 'enterpay_plugin_options_fields', 'enterpay-invoice-company-fields_settings' );
			add_settings_field( 'invoice_operator_code', __('Invoice operator code', 'enterpay-company-search'), array($this, 'invoice_operator_code_callback'), 'enterpay_plugin_options_fields', 'enterpay-invoice-company-fields_settings' );
			
		}
		
		public function sanitize( $input )
		{
			//$options = get_option('enterpay_plugin_options_fields');	
			$fields = ['company_name', 'vat_number', 'business_id', 'business_line', 'country', 'city', 'street', 'street_second', 'postal_code']; 
						
			foreach ($fields as $field){
				if( isset( $input[$field]['id'] ) ){ $input[$field]['id'] = implode(',', array_unique(array_map('trim', explode(',', $input[$field]['id'])))); }
				if( isset( $input[$field]['name'] ) ){ $input[$field]['name'] = implode(',', array_unique(array_map('trim', explode(',', $input[$field]['name'])))); }
				//if( isset( $input[$field]['tooltip'] ) ){ $input[$field]['tooltip'] = $input[$field]['name']; }
				
				if ($field == 'business_id'){
					if( isset( $input[$field]['auto'] ) && $input[$field]['auto'] == 1 ) $input[$field]['auto'] = 1; else $input[$field]['auto'] = 0;
				}
				/*
				if ($field == 'display_invoice_address'){
					if( isset( $input['display_invoice_address'] ) && $input['display_invoice_address'] == 1 ) $input['display_invoice_address'] = 1; else $input['display_invoice_address'] = 0;
				}
				*/
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
		
		public function company_name_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
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
				<label for="company_name-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
				<input type="text" id="company_name-name" name="enterpay_plugin_options_fields[company_name][name]" value="<?php echo $options['company_name']['name']; ?>" />
			</div>
			<div class="box_row">
				<label for="company_name-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
				<input type="text" id="company_name-id" name="enterpay_plugin_options_fields[company_name][id]" value="<?php echo $options['company_name']['id']; ?>" />
			</div>
			<div class="box_row">
				<label for="company_name-tooltip"><?php _e('ToolTip', 'enterpay-company-search'); ?>:</label>			
				<input type="text" id="company_name-tooltip" name="enterpay_plugin_options_fields[company_name][tooltip]" value="<?php echo $options['company_name']['tooltip']; ?>" />
			</div>				
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
			<div class="box_row">
				<label for="vat_number-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
				<input type="text" id="vat_number-name" name="enterpay_plugin_options_fields[vat_number][name]" value="<?php echo $options['vat_number']['name']; ?>" />
			</div>
			<div class="box_row">
				<label for="vat_number-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
				<input type="text" id="vat_number-id" name="enterpay_plugin_options_fields[vat_number][id]" value="<?php echo $options['vat_number']['id']; ?>" />
			</div>			
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
			if (!isset($options['business_id']['auto'])) {
				$options['business_id']['auto'] = '0';
			}
			?>
			<div class="box_row">
				<label for="business_id-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
				<input type="text" id="business_id-name" name="enterpay_plugin_options_fields[business_id][name]" value="<?php echo $options['business_id']['name']; ?>" />
			</div>
			<div class="box_row">
				<label for="business_id-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
				<input type="text" id="business_id-id" name="enterpay_plugin_options_fields[business_id][id]" value="<?php echo $options['business_id']['id']; ?>" />
			</div>
			<div class="box_row">					
				<input type="checkbox" <?php if ($options['business_id']['auto'] == 1) echo 'checked'; ?> id="business_id-auto" name="enterpay_plugin_options_fields[business_id][auto]" value="1" />
				<label class="chb" for="business_id-auto"><?php _e('Add automatically', 'enterpay-company-search'); ?></label>
			</div>				
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
			<div class="box_row">
				<label for="business_line-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
				<input type="text" id="business_line-name" name="enterpay_plugin_options_fields[business_line][name]" value="<?php echo $options['business_line']['name']; ?>" />
			</div>
			<div class="box_row">
				<label for="business_line-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
				<input type="text" id="business_line-id" name="enterpay_plugin_options_fields[business_line][id]" value="<?php echo $options['business_line']['id']; ?>" />
			</div>			
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
			<div class="box_row">
				<label for="country-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
				<input type="text" id="country-name" name="enterpay_plugin_options_fields[country][name]" value="<?php echo $options['country']['name']; ?>" />
			</div>
			<div class="box_row">
				<label for="country-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
				<input type="text" id="country-id" name="enterpay_plugin_options_fields[country][id]" value="<?php echo $options['country']['id']; ?>" />
			</div>			
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
			<div class="box_row">
				<label for="city-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
				<input type="text" id="city-name" name="enterpay_plugin_options_fields[city][name]" value="<?php echo $options['city']['name']; ?>" />
			</div>
			<div class="box_row">
				<label for="city-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
				<input type="text" id="city-id" name="enterpay_plugin_options_fields[city][id]" value="<?php echo $options['city']['id']; ?>" />
			</div>			
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
			<div class="box_row">
				<label for="street-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
				<input type="text" id="street-name" name="enterpay_plugin_options_fields[street][name]" value="<?php echo $options['street']['name']; ?>" />
			</div>
			<div class="box_row">
				<label for="street-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
				<input type="text" id="street-id" name="enterpay_plugin_options_fields[street][id]" value="<?php echo $options['street']['id']; ?>" />
			</div>			
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
			<div class="box_row">
				<label for="street_second-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
				<input type="text" id="street_second-name" name="enterpay_plugin_options_fields[street_second][name]" value="<?php echo $options['street_second']['name']; ?>" />
			</div>
			<div class="box_row">
				<label for="street_second-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
				<input type="text" id="street_second-id" name="enterpay_plugin_options_fields[street_second][id]" value="<?php echo $options['street_second']['id']; ?>" />
			</div>	
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
			<div class="box_row">
				<label for="postal_code-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
				<input type="text" id="postal_code-name" name="enterpay_plugin_options_fields[postal_code][name]" value="<?php echo $options['postal_code']['name']; ?>" />
			</div>
			<div class="box_row">
				<label for="postal_code-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
				<input type="text" id="postal_code-id" name="enterpay_plugin_options_fields[postal_code][id]" value="<?php echo $options['postal_code']['id']; ?>" />
			</div>			
			<?php
		}
		
		public function display_invoice_address_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
						
			if (!isset($options['display_invoice_address'])) {
				$options['display_invoice_address'] = '0';
			}
			?>			
			<div class="box_row">					
				<input type="checkbox" <?php if ($options['display_invoice_address'] == 1) echo 'checked'; ?> id="display_invoice_address" name="enterpay_plugin_options_fields[display_invoice_address]" value="1" />
				<!--<label class="chb" for="display_invoice_address"><?php _e('Display invoice address', 'enterpay-company-search'); ?></label>-->
			</div>				
			<?php
		}
		
		public function invoice_selector_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
			
			if (!isset($options['invoice_selector']['name'])) {
				$options['invoice_selector']['name'] = 'invoice_selector';
			}
			if (!isset($options['invoice_selector']['id'])) {
				$options['invoice_selector']['id'] = 'invoice_selector';
			}
			?>
			<div id="display_invoice_box">
				<div class="box_row">
					<label for="invoice_selector-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
					<input type="text" id="invoice_selector-name" name="enterpay_plugin_options_fields[invoice_selector][name]" value="<?php echo $options['invoice_selector']['name']; ?>" />
				</div>
				<div class="box_row">
					<label for="invoice_selector-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
					<input type="text" id="invoice_selector-id" name="enterpay_plugin_options_fields[invoice_selector][id]" value="<?php echo $options['invoice_selector']['id']; ?>" />
				</div>
			</div>
			<?php
		}
		
		public function invoice_address_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
			
			if (!isset($options['invoice_address']['name'])) {
				$options['invoice_address']['name'] = 'invoice_address';
			}
			if (!isset($options['invoice_address']['id'])) {
				$options['invoice_address']['id'] = 'invoice_address';
			}
			?>
			<div id="display_invoice_box">
				<div class="box_row">
					<label for="invoice_address-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
					<input type="text" id="invoice_address-name" name="enterpay_plugin_options_fields[invoice_address][name]" value="<?php echo $options['invoice_address']['name']; ?>" />
				</div>
				<div class="box_row">
					<label for="invoice_address-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
					<input type="text" id="invoice_address-id" name="enterpay_plugin_options_fields[invoice_address][id]" value="<?php echo $options['invoice_address']['id']; ?>" />
				</div>
			</div>
			<?php
		}
		
		public function invoice_operator_code_callback(){
			$options  = get_option( 'enterpay_plugin_options_fields', array() ); 
			
			if (!isset($options['invoice_operator_code']['name'])) {
				$options['invoice_operator_code']['name'] = 'invoice_operator_code';
			}
			if (!isset($options['invoice_operator_code']['id'])) {
				$options['invoice_operator_code']['id'] = 'invoice_operator_code';
			}
			?>
			<div id="display_invoice_box">
				<div class="box_row">
					<label for="invoice_operator_code-name"><?php _e('Field name', 'enterpay-company-search'); ?>:</label>
					<input type="text" id="invoice_operator_code-name" name="enterpay_plugin_options_fields[invoice_operator_code][name]" value="<?php echo $options['invoice_operator_code']['name']; ?>" />
				</div>
				<div class="box_row">
					<label for="invoice_operator_code-id"><?php _e('Field ID', 'enterpay-company-search'); ?>:</label>			
					<input type="text" id="invoice_operator_code-id" name="enterpay_plugin_options_fields[invoice_operator_code][id]" value="<?php echo $options['invoice_operator_code']['id']; ?>" />
				</div>
			</div>
			<?php
		}
						
		
		public function settings_section_callback(){}
				
		function display_settings(){ ?>
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<h4>Please enter the unique identifier of the element you want to modify in both the field_id and field_name cells. To enable functionality in multiple forms, you can add multiple values separated by a comma.</h4>
			<!--<div id="preset_wc_fields"><?php _e('Click here to add fields to WooCommerce checkout', 'enterpay-company-search'); ?></div>-->
			
			<form action='options.php' method='post'> <?php
				//settings_fields( 'enterpay-company-search-fields' );
				settings_fields( 'enterpay_plugin_options_fields' );
				
				do_settings_sections( 'enterpay_plugin_options_fields' );
				do_settings_sections( 'enterpay_plugin_options_company_fields' );
				submit_button(); ?>
			</form>
			
			<input type="button" class="button button-primary" id="preset_wc_fields" value="Add default WooCommerce fields">
			
			<?php
		}		
	}
}

new EnterpayCompanySearchFields();