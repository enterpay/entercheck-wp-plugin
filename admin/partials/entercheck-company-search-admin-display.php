<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://demoshop.entercheck.eu/
 * @since      1.0.0
 *
 * @package    Entercheck_Company_Search
 * @subpackage Entercheck_Company_Search/admin/partials
 */
 
 if ( ! defined( 'ABSPATH' ) ) exit;
 
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->


<form action="options.php" method="post">
    <?php
    settings_fields('enterpay_plugin_options');
    do_settings_sections('dbi_example_plugin'); ?>
    <p><input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save'); ?>" /></p>
	
	<style>
		.form-table th {
			vertical-align: bottom !important;
			padding: 5px 10px 5px 0 !important;
		}
		
		.form-table td {
			padding: 5px 10px 5px 10px !important;
		}
	</style>

    <?php
    function entercheck_plugin_section_text()
    {
        // translate text 
        echo '<p>'.esc_attr__('Here you can set all the options for using the API', 'entercheck-company-search').'</p>';
		echo '<p>'.esc_attr__('Read more at', 'entercheck-company-search').' <a href="https://docs.entercheck.eu/">https://docs.entercheck.eu/</a></p>';
    }
	
	function entercheck_plugin_processing_section_text(){
		echo '<p>'.__('<strong>Simple</strong> processing registers new business to the Entercheck backend.<br>', 'entercheck-company-search');		
		echo __('<strong>Smart</strong> processing mode forwards data specified on the form mapping page and executes the "Smart Form" workflow.', 'entercheck-company-search').'</p>';
	}

    function entercheck_plugin_setting_username()
    {
        $options = get_option('enterpay_plugin_options');

        if (!isset($options['username'])) {
            $options['username'] = "";
        }

        echo "<input id='enterpay_plugin_setting_username' name='enterpay_plugin_options[username]' type='text' value='" . esc_attr($options['username']) . "' />";
    }

    function entercheck_plugin_setting_password()
    {
        $options = get_option('enterpay_plugin_options');

        if (!isset($options['password'])) {
            $options['password'] = "";
        }

        echo "<input id='enterpay_plugin_setting_password' name='enterpay_plugin_options[password]' type='password' value='" . esc_attr($options['password']) . "' />";
		echo "<img id='display_password' src='".plugin_dir_url( dirname( __FILE__ ) )."images/hidden_eye_icon.png' width='24' heigth='24'>";
    }
	
    function entercheck_plugin_setting_request_mode()
    {
		$options = get_option('enterpay_plugin_options');
		
		if (!isset($options['request_mode'])) { $options['request_mode'] = "simple"; }
?>
		<select name="enterpay_plugin_options[request_mode]">
			<option value="simple" <?php if ($options['request_mode'] == 'simple') echo 'selected="selected"'; ?>>Simple</option>
			<option value="smart" <?php if ($options['request_mode'] == 'smart') echo 'selected="selected"'; ?>>Smart</option>
		</select>
<?php 	
/*
        $options = get_option('enterpay_plugin_options');

        if (!isset($options['display_form_mapping'])) {
			$options['display_form_mapping'] = '0';
		}
*/
       ?>			
						
			<!--<input type="checkbox" <?php /*if ($options['display_form_mapping'] == 1) echo 'checked';*/ ?> id="display_form_mapping" name="enterpay_plugin_options[display_form_mapping]" value="1" />-->
			<!--<label class="chb" for="display_invoice_address"><?php esc_attr_e('Allow form mapping', 'entercheck-company-search'); ?></label>-->
			
		<?php
    }
	
	function entercheck_plugin_setting_smart_form_id(){
		$options = get_option('enterpay_plugin_options');

        if (!isset($options['smart_form_id'])) {
            $options['smart_form_id'] = "";
        }

		echo '<label for="company_name-id">'.esc_attr__('Smart form ID - null uses default value', 'entercheck-company-search').'</label><br>';
		echo "<input id='enterpay_plugin_setting_smart_form_id' name='enterpay_plugin_options[smart_form_id]' type='text' value='" . esc_attr($options['smart_form_id']) . "' />";
	}
	
	
	function entercheck_plugin_setting_environment(){
		$options = get_option('enterpay_plugin_options');
		
		if (!isset($options['environment'])) { $options['environment'] = "test"; }
?>
		<select name="enterpay_plugin_options[environment]">
			<option value="test" <?php if ($options['environment'] == 'test') echo 'selected="selected"'; ?>>Test</option>
			<option value="production" <?php if ($options['environment'] == 'production') echo 'selected="selected"'; ?>>Production</option>
		</select>
<?php 		
		
	}
	
    function entercheck_plugin_setting_start_date()
    {
        $options = get_option('enterpay_plugin_options');

        if (!isset($options['start_date'])) {
            $options['start_date'] = "";
        }

        echo "<input id='enterpay_plugin_setting_start_date' name='enterpay_plugin_options[start_date]' type='text' value='" . esc_attr($options['start_date']) . "' />";
    }

    function entercheck_plugin_setting_enterchecktoken()
    {
    }
    ?>

</form>

<?php
$options = get_option('enterpay_plugin_options');

$api_domain = "api.entercheck.eu"; 
if (!isset($options['environment']) || empty($options['environment']) || $options['environment'] == 'test') { 
	$api_domain = "api.test.entercheck.eu"; 
}	

if (!isset($options['username']) || !isset($options['password'])) {
    echo "<p><b><i>API credentials are not set!</i></b></p>";
    return;
}
$data = array(
    "username" => $options['username'],
    "password" => $options['password']
);
$data = wp_json_encode($data);

$request_url = 'https://'.$api_domain.'/v1/auth';

$send_data = array(
	'method' => 'POST',		
	'headers'  => array(
		'Content-Type' => 'application/json',
		'Content-Length' => strlen($data),
		'Cache-control' => 'no-cache',
	),
	'body' => $data
);

$my_request = wp_remote_post($request_url, $send_data);
if ( ! is_wp_error( $my_request ) && ( 200 == $my_request['response']['code'] || 201 == $my_request['response']['code'] ) ) {
	$resp = wp_remote_retrieve_body( $my_request );
}


if (!empty($resp)) :
    $res =   json_decode($resp);
    if (!isset($res->error)) :
        $token = $res->token;
        if (!empty($token)) :
            update_option('entercheck_token', $token);
?>
			<h2>Test API call</h2>
			<p><?php esc_attr_e('You can verify that your credentials are valid for the given environment by sending a test request.', 'entercheck-company-search'); ?></p>
            <p style="border:1px solid gray;padding:10px;margin-top:30px;width:100%;overflow: scroll;max-width: 90%;"><b><?php esc_attr_e('Token') ?>: </b><?php echo $token; ?></p>
            <br>
            <button id="test-call-btn" onclick="search_company()"><?php esc_attr_e('Make a test API call', 'entercheck-company-search'); ?></button>
            <div id="search_company_result"></div>
<?php
        else :
            echo "<p><b><i>API credentials are incorrect!</i></b></p>";
        endif;
    endif;
endif;