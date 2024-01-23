<?php

if ( !class_exists( 'EnterpayCompanySearchFormMapping' ) ) {
	class EnterpayCompanySearchFormMapping {
		public function __construct() {
			add_action( 'admin_init', array( $this, 'register_settings') );
			
			add_action( 'admin_menu', array( $this, 'menu_settings' ), 999 );
		}
		
		public function menu_settings(){
			add_submenu_page('enterpay-company-search-entercheck', 'Form mapping', 'Form mapping', 'manage_options', 'enterpay-company-search-enterpay-form-mapping', array($this, 'display_settings'));
		}
		
		public function register_settings(){
			register_setting( 'enterpay_plugin_options_form_mapping', 'enterpay_plugin_options_form_mapping', [$this, 'sanitize'] );
			
			add_settings_section('enterpay-company-search-form_mapping', '', array($this, 'settings_section_callback'), 'enterpay_plugin_options_form_mapping' );
			//add_settings_field( 'smartFormId', 'smartFormId', array($this, 'smartFormId_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			//add_settings_field( 'businessId', 'businessId*', array($this, 'businessId_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			//add_settings_field( 'country', 'country*', array($this, 'country_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );			
			add_settings_field( 'firstName', 'First Name', array($this, 'firstName_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'lastName', 'Last Name', array($this, 'lastName_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'email', 'Email', array($this, 'email_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'phoneNumber', 'Phone Number', array($this, 'phoneNumber_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'businessName', 'Business Name', array($this, 'businessName_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'jobTitle', 'Job Title', array($this, 'jobTitle_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'dateOfBirth', 'Date of Birth', array($this, 'dateOfBirth_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'preferredContactMethod', 'Preferred Contact Method', array($this, 'preferredContactMethod_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'allowMarketing', 'allowMarketing', array($this, 'allowMarketing_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'subscribeToNewsLetter', 'Subscribe to NewsLetter', array($this, 'subscribeToNewsLetter_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'acceptedTos', 'Accepted TOS', array($this, 'acceptedTos_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'acceptedPrivacyPolicy', 'Accepted Privacy Policy', array($this, 'acceptedPrivacyPolicy_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'orderTotal', 'Order Total', array($this, 'orderTotal_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'orderCurrency', 'Order Currency', array($this, 'orderCurrency_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'targetCompletionDate', 'Target Completion Date', array($this, 'targetCompletionDate_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'referralSource', 'Referral Source', array($this, 'referralSource_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'freeText1', 'Free Text 1', array($this, 'freeText1_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'freeText2', 'Free Text 2', array($this, 'freeText2_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'additionalData1', 'Additional Data 1', array($this, 'additionalData1_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
			add_settings_field( 'additionalData2', 'Additional Data 2', array($this, 'additionalData2_callback'), 'enterpay_plugin_options_form_mapping', 'enterpay-company-search-form_mapping' );
		}
		
		public function sanitize( $input )
		{
			//$options = get_option('enterpay_plugin_options_form_mapping');	
			/*
			$fields = ['business_id', 'country', 'firstName', 'lastName', 'email', 'phoneNumber', 'businessName', 'jobTitle', 'dateOfBirth', 'preferredContactMethod', 'allowMarketing', 'subscribeToNewsLetter', 'acceptedTos', 'acceptedPrivacyPolicy', 'orderTotal', 'orderCurrency', 'targetCompletionDate', 'referralSource', 'freeText1', 'freeText2', 'additionalData1', 'additionalData2']; 
						
			foreach ($fields as $field){
				if( isset( $input[$field]['field'] ) ){ $input[$field]['field'] = implode(',', array_unique(array_map('trim', explode(',', $input[$field]['field'])))); }
				if( isset( $input[$field]['default'] ) ){ $input[$field]['default'] = trim($input[$field]['default']); }
				if( isset( $input[$field]['value'] ) ){ $input[$field]['value'] = trim($input[$field]['value']); }				
			}
			*/
			return $input;
		}
		
		public function smartFormId_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['smartFormId']['field'])) {
				$options['smartFormId']['field'] = 'inputsmartFormId';
			}
			if (!isset($options['smartFormId']['value'])) {
				$options['smartFormId']['value'] = '';
			}
			?>
			<div class="box_row_mapping">
				<label for="company_name-id"><?php _e('Smart form ID - null uses default value', 'enterpay-company-search'); ?></label>
			</div>
			<div class="box_row">
				<input type="text" id="smartFormId-field" name="enterpay_plugin_options_form_mapping[smartFormId][field]" value="<?php echo $options['smartFormId']['field']; ?>" />
				<!--<input type="text" id="smartFormId-value" name="enterpay_plugin_options_form_mapping[smartFormId][value]" value="<?php echo $options['smartFormId']['value']; ?>" />-->
			</div>
			<?php
		}	
		
		public function businessId_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['businessId']['field'])) {
				$options['businessId']['field'] = 'inputBusinessId';
			}
			if (!isset($options['businessId']['default'])) {
				$options['businessId']['default'] = '2538754-7';
			}
			?>
			<div class="box_row_mapping">
				<label for="company_name-id"><?php _e('HTML Form Element name', 'enterpay-company-search'); ?></label>
			</div>
			<div class="box_row">
				<input type="text" id="businessId-field" name="enterpay_plugin_options_form_mapping[businessId][field]" value="<?php echo $options['businessId']['field']; ?>" />
				<!--<input type="text" id="businessId-default" name="enterpay_plugin_options_form_mapping[businessId][default]" value="<?php echo $options['businessId']['default']; ?>" />-->
			</div>
			<?php
		}			
		
		public function country_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['country']['field'])) {
				$options['country']['field'] = 'inputCountry';
			}
			if (!isset($options['country']['default'])) {
				$options['country']['default'] = 'FI';
			}
			?>
			<div class="box_row">
				<input type="text" id="country-field" name="enterpay_plugin_options_form_mapping[country][field]" value="<?php echo $options['country']['field']; ?>" />
				<!--<input type="text" id="country-default" name="enterpay_plugin_options_form_mapping[country][default]" value="<?php echo $options['country']['default']; ?>" />-->
			</div>
			<?php
		}			
				
		public function firstName_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['firstName']['field'])) {
				$options['firstName']['field'] = 'inputFirstName';
			}
			if (!isset($options['firstName']['default'])) {
				$options['firstName']['default'] = '';
			}
			?>
			<div class="box_row">
				<input type="text" id="firstName-field" name="enterpay_plugin_options_form_mapping[firstName][field]" value="<?php echo $options['firstName']['field']; ?>" />
				<!--<input type="text" id="firstName-default" name="enterpay_plugin_options_form_mapping[firstName][default]" value="<?php echo $options['firstName']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function lastName_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['lastName']['field'])) {
				$options['lastName']['field'] = 'inputLastName';
			}
			if (!isset($options['lastName']['default'])) {
				$options['lastName']['default'] = '';
			}
			?>
			<div class="box_row">
				<input type="text" id="lastName-field" name="enterpay_plugin_options_form_mapping[lastName][field]" value="<?php echo $options['lastName']['field']; ?>" />
				<!--<input type="text" id="lastName-default" name="enterpay_plugin_options_form_mapping[lastName][default]" value="<?php echo $options['lastName']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function email_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['email']['field'])) {
				$options['email']['field'] = 'inputEmail';
			}
			if (!isset($options['email']['default'])) {
				$options['email']['default'] = 'john.doe@example.com';
			}
			?>
			<div class="box_row">
				<input type="text" id="email-field" name="enterpay_plugin_options_form_mapping[email][field]" value="<?php echo $options['email']['field']; ?>" />
				<!--<input type="text" id="email-default" name="enterpay_plugin_options_form_mapping[email][default]" value="<?php echo $options['email']['default']; ?>" />-->
			</div>
			<?php
		}			
		
		public function phoneNumber_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['phoneNumber']['field'])) {
				$options['phoneNumber']['field'] = 'inputPhoneNumber';
			}
			if (!isset($options['phoneNumber']['default'])) {
				$options['phoneNumber']['default'] = '+1234567890';
			}
			?>
			<div class="box_row">
				<input type="text" id="phoneNumber-field" name="enterpay_plugin_options_form_mapping[phoneNumber][field]" value="<?php echo $options['phoneNumber']['field']; ?>" />
				<!--<input type="text" id="phoneNumber-default" name="enterpay_plugin_options_form_mapping[phoneNumber][default]" value="<?php echo $options['phoneNumber']['default']; ?>" />-->
			</div>
			<?php
		}			
		
		public function businessName_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['businessName']['field'])) {
				$options['businessName']['field'] = 'inputBusinessName';
			}
			if (!isset($options['businessName']['default'])) {
				$options['businessName']['default'] = 'ABC Company';
			}
			?>
			<div class="box_row">
				<input type="text" id="businessName-field" name="enterpay_plugin_options_form_mapping[businessName][field]" value="<?php echo $options['businessName']['field']; ?>" />
				<!--<input type="text" id="businessName-default" name="enterpay_plugin_options_form_mapping[businessName][default]" value="<?php echo $options['businessName']['default']; ?>" />-->
			</div>
			<?php
		}			
		
		public function jobTitle_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['jobTitle']['field'])) {
				$options['jobTitle']['field'] = 'inputJobTitle';
			}
			if (!isset($options['jobTitle']['default'])) {
				$options['jobTitle']['default'] = 'Manager';
			}
			?>
			<div class="box_row">
				<input type="text" id="jobTitle-field" name="enterpay_plugin_options_form_mapping[jobTitle][field]" value="<?php echo $options['jobTitle']['field']; ?>" />
				<!--<input type="text" id="jobTitle-default" name="enterpay_plugin_options_form_mapping[jobTitle][default]" value="<?php echo $options['jobTitle']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function dateOfBirth_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['dateOfBirth']['field'])) {
				$options['dateOfBirth']['field'] = 'inputDateOfBirth';
			}
			if (!isset($options['dateOfBirth']['default'])) {
				$options['dateOfBirth']['default'] = '1990-01-01';
			}
			?>
			<div class="box_row">
				<input type="text" id="dateOfBirth-field" name="enterpay_plugin_options_form_mapping[dateOfBirth][field]" value="<?php echo $options['dateOfBirth']['field']; ?>" />
				<!--<input type="text" id="dateOfBirth-default" name="enterpay_plugin_options_form_mapping[dateOfBirth][default]" value="<?php echo $options['dateOfBirth']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function preferredContactMethod_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['preferredContactMethod']['field'])) {
				$options['preferredContactMethod']['field'] = 'inputPreferredContactMethod';
			}
			if (!isset($options['preferredContactMethod']['default'])) {
				$options['preferredContactMethod']['default'] = 'Email';
			}
			?>
			<div class="box_row">
				<input type="text" id="preferredContactMethod-field" name="enterpay_plugin_options_form_mapping[preferredContactMethod][field]" value="<?php echo $options['preferredContactMethod']['field']; ?>" />
				<!--<input type="text" id="preferredContactMethod-default" name="enterpay_plugin_options_form_mapping[preferredContactMethod][default]" value="<?php echo $options['preferredContactMethod']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function allowMarketing_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['allowMarketing']['field'])) {
				$options['allowMarketing']['field'] = 'inputAllowMarketing';
			}
			if (!isset($options['allowMarketing']['default'])) {
				$options['allowMarketing']['default'] = 'true';
			}
			?>
			<div class="box_row">
				<input type="text" id="allowMarketing-field" name="enterpay_plugin_options_form_mapping[allowMarketing][field]" value="<?php echo $options['allowMarketing']['field']; ?>" />
				<!--<input type="text" id="allowMarketing-default" name="enterpay_plugin_options_form_mapping[allowMarketing][default]" value="<?php echo $options['allowMarketing']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function subscribeToNewsLetter_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['subscribeToNewsLetter']['field'])) {
				$options['subscribeToNewsLetter']['field'] = 'inputSubscribeToNewsLetter';
			}
			if (!isset($options['subscribeToNewsLetter']['default'])) {
				$options['subscribeToNewsLetter']['default'] = 'false';
			}
			?>
			<div class="box_row">
				<input type="text" id="subscribeToNewsLetter-field" name="enterpay_plugin_options_form_mapping[subscribeToNewsLetter][field]" value="<?php echo $options['subscribeToNewsLetter']['field']; ?>" />
				<!--<input type="text" id="subscribeToNewsLetter-default" name="enterpay_plugin_options_form_mapping[subscribeToNewsLetter][default]" value="<?php echo $options['subscribeToNewsLetter']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function acceptedTos_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['acceptedTos']['field'])) {
				$options['acceptedTos']['field'] = 'inputAcceptedTos';
			}
			if (!isset($options['acceptedTos']['default'])) {
				$options['acceptedTos']['default'] = 'true';
			}
			?>
			<div class="box_row">
				<input type="text" id="acceptedTos-field" name="enterpay_plugin_options_form_mapping[acceptedTos][field]" value="<?php echo $options['acceptedTos']['field']; ?>" />
				<!--<input type="text" id="acceptedTos-default" name="enterpay_plugin_options_form_mapping[acceptedTos][default]" value="<?php echo $options['acceptedTos']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function acceptedPrivacyPolicy_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['acceptedPrivacyPolicy']['field'])) {
				$options['acceptedPrivacyPolicy']['field'] = 'inputAcceptedPrivacyPolicy';
			}
			if (!isset($options['acceptedPrivacyPolicy']['default'])) {
				$options['acceptedPrivacyPolicy']['default'] = 'true';
			}
			?>
			<div class="box_row">
				<input type="text" id="acceptedPrivacyPolicy-field" name="enterpay_plugin_options_form_mapping[acceptedPrivacyPolicy][field]" value="<?php echo $options['acceptedPrivacyPolicy']['field']; ?>" />
				<!--<input type="text" id="acceptedPrivacyPolicy-default" name="enterpay_plugin_options_form_mapping[acceptedPrivacyPolicy][default]" value="<?php echo $options['acceptedPrivacyPolicy']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function orderTotal_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['orderTotal']['field'])) {
				$options['orderTotal']['field'] = 'inputOrderTotal';
			}
			if (!isset($options['orderTotal']['default'])) {
				$options['orderTotal']['default'] = '100';
			}
			?>
			<div class="box_row">
				<input type="text" id="orderTotal-field" name="enterpay_plugin_options_form_mapping[orderTotal][field]" value="<?php echo $options['orderTotal']['field']; ?>" />
				<!--<input type="text" id="orderTotal-default" name="enterpay_plugin_options_form_mapping[orderTotal][default]" value="<?php echo $options['orderTotal']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function orderCurrency_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['orderCurrency']['field'])) {
				$options['orderCurrency']['field'] = 'inputOrderCurrency';
			}
			if (!isset($options['orderCurrency']['default'])) {
				$options['orderCurrency']['default'] = 'USD';
			}
			?>
			<div class="box_row">
				<input type="text" id="orderCurrency-field" name="enterpay_plugin_options_form_mapping[orderCurrency][field]" value="<?php echo $options['orderCurrency']['field']; ?>" />
				<!--<input type="text" id="orderCurrency-default" name="enterpay_plugin_options_form_mapping[orderCurrency][default]" value="<?php echo $options['orderCurrency']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function targetCompletionDate_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['targetCompletionDate']['field'])) {
				$options['targetCompletionDate']['field'] = 'inputTargetCompletionDate';
			}
			if (!isset($options['targetCompletionDate']['default'])) {
				$options['targetCompletionDate']['default'] = '1990-01-01';
			}
			?>
			<div class="box_row">
				<input type="text" id="targetCompletionDate-field" name="enterpay_plugin_options_form_mapping[targetCompletionDate][field]" value="<?php echo $options['targetCompletionDate']['field']; ?>" />
				<!--<input type="text" id="targetCompletionDate-default" name="enterpay_plugin_options_form_mapping[targetCompletionDate][default]" value="<?php echo $options['targetCompletionDate']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function referralSource_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['referralSource']['field'])) {
				$options['referralSource']['field'] = 'inputReferralSource';
			}
			if (!isset($options['referralSource']['default'])) {
				$options['referralSource']['default'] = 'Google';
			}
			?>
			<div class="box_row">
				<input type="text" id="referralSource-field" name="enterpay_plugin_options_form_mapping[referralSource][field]" value="<?php echo $options['referralSource']['field']; ?>" />
				<!--<input type="text" id="referralSource-default" name="enterpay_plugin_options_form_mapping[referralSource][default]" value="<?php echo $options['referralSource']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function freeText1_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['freeText1']['field'])) {
				$options['freeText1']['field'] = 'inputFreeText1';
			}
			if (!isset($options['freeText1']['default'])) {
				$options['freeText1']['default'] = 'Lorem ipsum dolor sit amet';
			}
			?>
			<div class="box_row">
				<input type="text" id="freeText1-field" name="enterpay_plugin_options_form_mapping[freeText1][field]" value="<?php echo $options['freeText1']['field']; ?>" />
				<!--<input type="text" id="freeText1-default" name="enterpay_plugin_options_form_mapping[freeText1][default]" value="<?php echo $options['freeText1']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function freeText2_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['freeText2']['field'])) {
				$options['freeText2']['field'] = 'inputFreeText2';
			}
			if (!isset($options['freeText2']['default'])) {
				$options['freeText2']['default'] = 'Lorem ipsum dolor sit amet';
			}
			?>
			<div class="box_row">
				<input type="text" id="freeText2-field" name="enterpay_plugin_options_form_mapping[freeText2][field]" value="<?php echo $options['freeText2']['field']; ?>" />
				<!--<input type="text" id="freeText2-default" name="enterpay_plugin_options_form_mapping[freeText2][default]" value="<?php echo $options['freeText2']['default']; ?>" />-->
			</div>
			<?php
		}
				
		public function additionalData1_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['additionalData1']['field'])) {
				$options['additionalData1']['field'] = 'inputAdditionalData1';
			}
			if (!isset($options['additionalData1']['default'])) {
				$options['additionalData1']['default'] = '';
			}
			?>
			<div class="box_row">
				<input type="text" id="additionalData1-field" name="enterpay_plugin_options_form_mapping[additionalData1][field]" value="<?php echo $options['additionalData1']['field']; ?>" />
				<!--<input type="text" id="additionalData1-default" name="enterpay_plugin_options_form_mapping[additionalData1][default]" value="<?php echo $options['additionalData1']['default']; ?>" />-->
			</div>
			<?php
		}
		
		public function additionalData2_callback(){
			$options  = get_option( 'enterpay_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['additionalData2']['field'])) {
				$options['additionalData2']['field'] = 'inputAdditionalData2';
			}
			if (!isset($options['additionalData2']['default'])) {
				$options['additionalData2']['default'] = '';
			}
			?>
			<div class="box_row">
				<input type="text" id="additionalData2-field" name="enterpay_plugin_options_form_mapping[additionalData2][field]" value="<?php echo $options['additionalData2']['field']; ?>" />
				<!--<input type="text" id="additionalData2-default" name="enterpay_plugin_options_form_mapping[additionalData2][default]" value="<?php echo $options['additionalData2']['default']; ?>" />-->
			</div>
			<?php
		}
							
		public function settings_section_callback(){}
				
		function display_settings(){ ?>
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
									
			<form action='options.php' method='post'> <?php
				//settings_fields( 'enterpay-company-search-fields' );
				settings_fields( 'enterpay_plugin_options_form_mapping' );
				
				do_settings_sections( 'enterpay_plugin_options_form_mapping' );
				//do_settings_sections( 'enterpay_plugin_options_company_fields' );
				submit_button(); ?>
			</form>		


			<style>
				.form-table th {
					vertical-align: inherit !important;
					padding: 10px 10px 10px 0;
				}
				
				.form-table td {
					padding: 10px 10px 10px 10px !important;
				}
			</style>
			<?php
		}		
	}
}

new EnterpayCompanySearchFormMapping();