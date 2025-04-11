<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'EntercheckCompanySearchFormMapping' ) ) {
	class EntercheckCompanySearchFormMapping {
		public function __construct() {
			add_action( 'admin_init', array( $this, 'register_settings') );
			
			add_action( 'admin_menu', array( $this, 'menu_settings' ), 999 );
		}
		
		public function menu_settings(){
			add_submenu_page('entercheck-company-search-entercheck', 'Form mapping', 'Form mapping', 'manage_options', 'entercheck-company-search-entercheck-form-mapping', array($this, 'display_settings'));
		}
		
		public function register_settings(){
			register_setting( 'entercheck_plugin_options_form_mapping', 'entercheck_plugin_options_form_mapping', [$this, 'sanitize'] );
			
			add_settings_section('entercheck-company-search-form_mapping', '', array($this, 'mapping_section_callback'), 'entercheck_plugin_options_form_mapping' );
			//add_settings_field( 'entercheck_smartFormId', 'smartFormId', array($this, 'smartFormId_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_businessId', 'businessId*', array($this, 'businessId_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_country', 'country*', array($this, 'country_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );			
			add_settings_field( 'entercheck_firstName', 'First Name', array($this, 'firstName_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			add_settings_field( 'entercheck_lastName', 'Last Name', array($this, 'lastName_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			add_settings_field( 'entercheck_email', 'Email', array($this, 'email_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			add_settings_field( 'entercheck_phoneNumber', 'Phone Number', array($this, 'phoneNumber_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			add_settings_field( 'entercheck_businessName', 'Business Name', array($this, 'businessName_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_jobTitle', 'Job Title', array($this, 'jobTitle_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_dateOfBirth', 'Date of Birth', array($this, 'dateOfBirth_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_preferredContactMethod', 'Preferred Contact Method', array($this, 'preferredContactMethod_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_allowMarketing', 'Allow Marketing', array($this, 'allowMarketing_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_subscribeToNewsLetter', 'Subscribe to NewsLetter', array($this, 'subscribeToNewsLetter_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_acceptedTos', 'Accepted TOS', array($this, 'acceptedTos_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_acceptedPrivacyPolicy', 'Accepted Privacy Policy', array($this, 'acceptedPrivacyPolicy_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_orderTotal', 'Order Total', array($this, 'orderTotal_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_orderCurrency', 'Order Currency', array($this, 'orderCurrency_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_targetCompletionDate', 'Target Completion Date', array($this, 'targetCompletionDate_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_referralSource', 'Referral Source', array($this, 'referralSource_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_freeText1', 'Free Text 1', array($this, 'freeText1_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_freeText2', 'Free Text 2', array($this, 'freeText2_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_additionalData1', 'Additional Data 1', array($this, 'additionalData1_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
			//add_settings_field( 'entercheck_additionalData2', 'Additional Data 2', array($this, 'additionalData2_callback'), 'entercheck_plugin_options_form_mapping', 'entercheck-company-search-form_mapping' );
		}
		
		public function sanitize( $input )
		{
			return $input;
		}
		
		public function mapping_section_callback(){
			echo '<p>'.esc_attr('The form mapping determines what data is routed to the Entercheck backend process. Set the HTML field names for input according to the workflow.').'</p>';
		}
		
		public function smartFormId_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['smartFormId']['field'])) {
				$options['smartFormId']['field'] = '';
			}
			if (!isset($options['smartFormId']['value'])) {
				$options['smartFormId']['value'] = '';
			}
			?>
			<div class="box_row_mapping">
				<label for="company_name-id"><?php esc_attr_e('“Workflow ID - null uses default value', 'entercheck-company-search'); ?></label>
			</div>
			<div class="box_row">
				<input type="text" id="smartFormId-field" name="entercheck_plugin_options_form_mapping[smartFormId][field]" value="<?php echo esc_attr($options['smartFormId']['field']); ?>" />
			</div>
			<?php
		}	
		
		public function businessId_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['businessId']['field'])) {
				$options['businessId']['field'] = '';
			}
			if (!isset($options['businessId']['default'])) {
				$options['businessId']['default'] = '2538754-7';
			}
			?>
			<div class="box_row_mapping">
				<label for="company_name-id"><?php esc_html_e('HTML Form Element name', 'entercheck-company-search'); ?></label>
			</div>
			<div class="box_row">
				<input type="text" id="businessId-field" name="entercheck_plugin_options_form_mapping[businessId][field]" value="<?php echo esc_attr($options['businessId']['field']); ?>" />
			</div>
			<?php
		}			
		
		public function country_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['country']['field'])) {
				$options['country']['field'] = '';
			}
			if (!isset($options['country']['default'])) {
				$options['country']['default'] = 'FI';
			}
			?>
			<div class="box_row">
				<input type="text" id="country-field" name="entercheck_plugin_options_form_mapping[country][field]" value="<?php echo esc_attr($options['country']['field']); ?>" />
			</div>
			<?php
		}			
				
		public function firstName_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['firstName']['field'])) {
				$options['firstName']['field'] = '';
			}
			if (!isset($options['firstName']['default'])) {
				$options['firstName']['default'] = '';
			}
			?>
			<div class="box_row">
				<input type="text" id="firstName-field" name="entercheck_plugin_options_form_mapping[firstName][field]" value="<?php echo esc_attr($options['firstName']['field']); ?>" />
			</div>
			<?php
		}
		
		public function lastName_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['lastName']['field'])) {
				$options['lastName']['field'] = '';
			}
			if (!isset($options['lastName']['default'])) {
				$options['lastName']['default'] = '';
			}
			?>
			<div class="box_row">
				<input type="text" id="lastName-field" name="entercheck_plugin_options_form_mapping[lastName][field]" value="<?php echo esc_attr($options['lastName']['field']); ?>" />
			</div>
			<?php
		}
		
		public function email_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['email']['field'])) {
				$options['email']['field'] = '';
			}
			if (!isset($options['email']['default'])) {
				$options['email']['default'] = 'john.doe@example.com';
			}
			?>
			<div class="box_row">
				<input type="text" id="email-field" name="entercheck_plugin_options_form_mapping[email][field]" value="<?php echo esc_attr($options['email']['field']); ?>" />
			</div>
			<?php
		}			
		
		public function phoneNumber_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['phoneNumber']['field'])) {
				$options['phoneNumber']['field'] = '';
			}
			if (!isset($options['phoneNumber']['default'])) {
				$options['phoneNumber']['default'] = '+1234567890';
			}
			?>
			<div class="box_row">
				<input type="text" id="phoneNumber-field" name="entercheck_plugin_options_form_mapping[phoneNumber][field]" value="<?php echo esc_attr($options['phoneNumber']['field']); ?>" />
			</div>
			<?php
		}			
		
		public function businessName_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['businessName']['field'])) {
				$options['businessName']['field'] = '';
			}
			if (!isset($options['businessName']['default'])) {
				$options['businessName']['default'] = 'ABC Company';
			}
			?>
			<div class="box_row">
				<input type="text" id="businessName-field" name="entercheck_plugin_options_form_mapping[businessName][field]" value="<?php echo esc_attr($options['businessName']['field']); ?>" />
			</div>
			<?php
		}			
		
		public function jobTitle_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['jobTitle']['field'])) {
				$options['jobTitle']['field'] = '';
			}
			if (!isset($options['jobTitle']['default'])) {
				$options['jobTitle']['default'] = 'Manager';
			}
			?>
			<div class="box_row">
				<input type="text" id="jobTitle-field" name="entercheck_plugin_options_form_mapping[jobTitle][field]" value="<?php echo esc_attr($options['jobTitle']['field']); ?>" />
			</div>
			<?php
		}
		
		public function dateOfBirth_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['dateOfBirth']['field'])) {
				$options['dateOfBirth']['field'] = '';
			}
			if (!isset($options['dateOfBirth']['default'])) {
				$options['dateOfBirth']['default'] = '1990-01-01';
			}
			?>
			<div class="box_row">
				<input type="text" id="dateOfBirth-field" name="entercheck_plugin_options_form_mapping[dateOfBirth][field]" value="<?php echo esc_attr($options['dateOfBirth']['field']); ?>" />
			</div>
			<?php
		}
		
		public function preferredContactMethod_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['preferredContactMethod']['field'])) {
				$options['preferredContactMethod']['field'] = '';
			}
			if (!isset($options['preferredContactMethod']['default'])) {
				$options['preferredContactMethod']['default'] = 'Email';
			}
			?>
			<div class="box_row">
				<input type="text" id="preferredContactMethod-field" name="entercheck_plugin_options_form_mapping[preferredContactMethod][field]" value="<?php echo esc_attr($options['preferredContactMethod']['field']); ?>" />
			</div>
			<?php
		}
		
		public function allowMarketing_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['allowMarketing']['field'])) {
				$options['allowMarketing']['field'] = '';
			}
			if (!isset($options['allowMarketing']['default'])) {
				$options['allowMarketing']['default'] = 'true';
			}
			?>
			<div class="box_row">
				<input type="text" id="allowMarketing-field" name="entercheck_plugin_options_form_mapping[allowMarketing][field]" value="<?php echo esc_attr($options['allowMarketing']['field']); ?>" />
			</div>
			<?php
		}
		
		public function subscribeToNewsLetter_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['subscribeToNewsLetter']['field'])) {
				$options['subscribeToNewsLetter']['field'] = '';
			}
			if (!isset($options['subscribeToNewsLetter']['default'])) {
				$options['subscribeToNewsLetter']['default'] = 'false';
			}
			?>
			<div class="box_row">
				<input type="text" id="subscribeToNewsLetter-field" name="entercheck_plugin_options_form_mapping[subscribeToNewsLetter][field]" value="<?php echo esc_attr($options['subscribeToNewsLetter']['field']); ?>" />
			</div>
			<?php
		}
		
		public function acceptedTos_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['acceptedTos']['field'])) {
				$options['acceptedTos']['field'] = '';
			}
			if (!isset($options['acceptedTos']['default'])) {
				$options['acceptedTos']['default'] = 'true';
			}
			?>
			<div class="box_row">
				<input type="text" id="acceptedTos-field" name="entercheck_plugin_options_form_mapping[acceptedTos][field]" value="<?php echo esc_attr($options['acceptedTos']['field']); ?>" />
		</div>
			<?php
		}
		
		public function acceptedPrivacyPolicy_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['acceptedPrivacyPolicy']['field'])) {
				$options['acceptedPrivacyPolicy']['field'] = '';
			}
			if (!isset($options['acceptedPrivacyPolicy']['default'])) {
				$options['acceptedPrivacyPolicy']['default'] = 'true';
			}
			?>
			<div class="box_row">
				<input type="text" id="acceptedPrivacyPolicy-field" name="entercheck_plugin_options_form_mapping[acceptedPrivacyPolicy][field]" value="<?php echo esc_attr($options['acceptedPrivacyPolicy']['field']); ?>" />
			</div>
			<?php
		}
		
		public function orderTotal_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['orderTotal']['field'])) {
				$options['orderTotal']['field'] = '';
			}
			if (!isset($options['orderTotal']['default'])) {
				$options['orderTotal']['default'] = '100';
			}
			?>
			<div class="box_row">
				<input type="text" id="orderTotal-field" name="entercheck_plugin_options_form_mapping[orderTotal][field]" value="<?php echo esc_attr($options['orderTotal']['field']); ?>" />
			</div>
			<?php
		}
		
		public function orderCurrency_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['orderCurrency']['field'])) {
				$options['orderCurrency']['field'] = '';
			}
			if (!isset($options['orderCurrency']['default'])) {
				$options['orderCurrency']['default'] = 'USD';
			}
			?>
			<div class="box_row">
				<input type="text" id="orderCurrency-field" name="entercheck_plugin_options_form_mapping[orderCurrency][field]" value="<?php echo esc_attr($options['orderCurrency']['field']); ?>" />
			</div>
			<?php
		}
		
		public function targetCompletionDate_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['targetCompletionDate']['field'])) {
				$options['targetCompletionDate']['field'] = '';
			}
			if (!isset($options['targetCompletionDate']['default'])) {
				$options['targetCompletionDate']['default'] = '1990-01-01';
			}
			?>
			<div class="box_row">
				<input type="text" id="targetCompletionDate-field" name="entercheck_plugin_options_form_mapping[targetCompletionDate][field]" value="<?php echo esc_attr($options['targetCompletionDate']['field']); ?>" />
			</div>
			<?php
		}
		
		public function referralSource_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['referralSource']['field'])) {
				$options['referralSource']['field'] = '';
			}
			if (!isset($options['referralSource']['default'])) {
				$options['referralSource']['default'] = 'Google';
			}
			?>
			<div class="box_row">
				<input type="text" id="referralSource-field" name="entercheck_plugin_options_form_mapping[referralSource][field]" value="<?php echo esc_attr($options['referralSource']['field']); ?>" />
			</div>
			<?php
		}
		
		public function freeText1_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['freeText1']['field'])) {
				$options['freeText1']['field'] = '';
			}
			if (!isset($options['freeText1']['default'])) {
				$options['freeText1']['default'] = 'Lorem ipsum dolor sit amet';
			}
			?>
			<div class="box_row">
				<input type="text" id="freeText1-field" name="entercheck_plugin_options_form_mapping[freeText1][field]" value="<?php echo esc_attr($options['freeText1']['field']); ?>" />
			</div>
			<?php
		}
		
		public function freeText2_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['freeText2']['field'])) {
				$options['freeText2']['field'] = '';
			}
			if (!isset($options['freeText2']['default'])) {
				$options['freeText2']['default'] = 'Lorem ipsum dolor sit amet';
			}
			?>
			<div class="box_row">
				<input type="text" id="freeText2-field" name="entercheck_plugin_options_form_mapping[freeText2][field]" value="<?php echo esc_attr($options['freeText2']['field']); ?>" />
			</div>
			<?php
		}
				
		public function additionalData1_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['additionalData1']['field'])) {
				$options['additionalData1']['field'] = '';
			}
			if (!isset($options['additionalData1']['default'])) {
				$options['additionalData1']['default'] = '';
			}
			?>
			<div class="box_row">
				<input type="text" id="additionalData1-field" name="entercheck_plugin_options_form_mapping[additionalData1][field]" value="<?php echo esc_attr($options['additionalData1']['field']); ?>" />
			</div>
			<?php
		}
		
		public function additionalData2_callback(){
			$options  = get_option( 'entercheck_plugin_options_form_mapping', array() ); 
			
			if (!isset($options['additionalData2']['field'])) {
				$options['additionalData2']['field'] = '';
			}
			if (!isset($options['additionalData2']['default'])) {
				$options['additionalData2']['default'] = '';
			}
			?>
			<div class="box_row">
				<input type="text" id="additionalData2-field" name="entercheck_plugin_options_form_mapping[additionalData2][field]" value="<?php echo esc_attr($options['additionalData2']['field']); ?>" />
			</div>
			<?php
		}
							
		public function settings_section_callback(){}
				
		function display_settings(){ ?>
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
						
			<div id="mapping_form_block">
				<form action='options.php' method='post'> <?php
					settings_fields( 'entercheck_plugin_options_form_mapping' );
					
					do_settings_sections( 'entercheck_plugin_options_form_mapping' );
					submit_button(); ?>
				</form>
			</div>
			<?php
		}		
	}
}

new EntercheckCompanySearchFormMapping();