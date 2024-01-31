<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://demoshop.entercheck.eu/
 * @since      1.0.0
 *
 * @package    Enterpay_Company_Search
 * @subpackage Enterpay_Company_Search/admin/partials
 */
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
    function enterpay_plugin_section_text()
    {
        // translate text 
        echo '<p>'.__('Here you can set all the options for using the API', 'enterpay-company-search').'</p>';
		echo '<p>'.__('Read more at', 'enterpay-company-search').' <a href="https://docs.entercheck.eu/">https://docs.entercheck.eu/</a></p>';
    }
	
	function enterpay_plugin_processing_section_text(){
		echo '<p>'.__('<strong>Simple</strong> processing registers new business to the Entercheck backend.<br>', 'enterpay-company-search');		
		echo __('<strong>Smart</strong> processing mode forwards data specified on the form mapping page and executes the "Smart Form" workflow.', 'enterpay-company-search').'</p>';
	}

    function enterpay_plugin_setting_username()
    {
        $options = get_option('enterpay_plugin_options');

        if (!isset($options['username'])) {
            $options['username'] = "";
        }

        echo "<input id='enterpay_plugin_setting_username' name='enterpay_plugin_options[username]' type='text' value='" . esc_attr($options['username']) . "' />";
    }

    function enterpay_plugin_setting_password()
    {
        $options = get_option('enterpay_plugin_options');

        if (!isset($options['password'])) {
            $options['password'] = "";
        }

        echo "<input id='enterpay_plugin_setting_password' name='enterpay_plugin_options[password]' type='password' value='" . esc_attr($options['password']) . "' />";
		echo "<img id='display_password' src='".plugin_dir_url( dirname( __FILE__ ) )."images/hidden_eye_icon.png' width='24' heigth='24'>";
    }
	
    function enterpay_plugin_setting_request_mode()
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
			<!--<label class="chb" for="display_invoice_address"><?php _e('Allow form mapping', 'enterpay-company-search'); ?></label>-->
			
		<?php
    }
	
	function enterpay_plugin_setting_smart_form_id(){
		$options = get_option('enterpay_plugin_options');

        if (!isset($options['smart_form_id'])) {
            $options['smart_form_id'] = "";
        }

		echo '<label for="company_name-id">'.__('Smart form ID - null uses default value', 'enterpay-company-search').'</label><br>';
		echo "<input id='enterpay_plugin_setting_smart_form_id' name='enterpay_plugin_options[smart_form_id]' type='text' value='" . esc_attr($options['smart_form_id']) . "' />";
	}
	
	
	function enterpay_plugin_setting_environment(){
		$options = get_option('enterpay_plugin_options');
		
		if (!isset($options['environment'])) { $options['environment'] = "test"; }
?>
		<select name="enterpay_plugin_options[environment]">
			<option value="test" <?php if ($options['environment'] == 'test') echo 'selected="selected"'; ?>>Test</option>
			<option value="production" <?php if ($options['environment'] == 'production') echo 'selected="selected"'; ?>>Production</option>
		</select>
<?php 		
		
	}
	
    function enterpay_plugin_setting_start_date()
    {
        $options = get_option('enterpay_plugin_options');

        if (!isset($options['start_date'])) {
            $options['start_date'] = "";
        }

        echo "<input id='enterpay_plugin_setting_start_date' name='enterpay_plugin_options[start_date]' type='text' value='" . esc_attr($options['start_date']) . "' />";
    }

    function enterpay_plugin_setting_enterpaytoken()
    {
    }
    ?>

</form>

<?php

$curl = curl_init();
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
$data = json_encode($data);
$options = array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://'.$api_domain.'/v1/auth',
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

if (!empty($resp)) :
    $res =   json_decode($resp);
    if (!isset($res->error)) :
        $token = $res->token;
        if (!empty($token)) :
            update_option('enterpay_token', $token);
?>
			<h2>Test API call</h2>
			<?php _e('<p>You can verify that your credentials are valid for the given environment by sending a test request.</p>', 'enterpay-company-search'); ?>
            <p style="border:1px solid gray;padding:10px;margin-top:30px;width:100%;overflow: scroll;max-width: 90%;"><b><?php _e('Token') ?>: </b><?= $token ?></p>
            <br>
            <button id="test-call-btn" onclick="search_company()"><?php _e('Make a test API call', 'enterpay-company-search') ?></button>
            <script type="text/javascript">
                nonce = "<?= wp_create_nonce("my_user_vote_nonce") ?>"
            </script>
            <div id="search_company_result"></div>
<?php
        else :
            echo "<p><b><i>API credentials are incorrect!</i></b></p>";
        endif;
    endif;
endif;


curl_close($curl);

