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

<div id="credentials_settings_block">
<form action="options.php" method="post">
    <?php
    settings_fields('entercheck_plugin_options');
    do_settings_sections('dbi_example_plugin'); ?>
    <p><input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save', 'entercheck-company-search'); ?>" /></p>
	
    <?php
    function entercheck_plugin_section_text()
    {
        // translate text 
        echo '<p>'.esc_attr__('Here you can set all the options for using the API', 'entercheck-company-search').'</p>';
		echo '<p>'.esc_attr__('Read more at', 'entercheck-company-search').' <a href="https://docs.entercheck.eu/">https://docs.entercheck.eu/</a></p>';
    }
	
	function entercheck_plugin_processing_section_text(){
		//echo '<p><strong>'.esc_html__('Simple', 'entercheck-company-search').'</strong> '.esc_html__('processing registers new business to the Entercheck backend.', 'entercheck-company-search').'<br>';
		echo '<strong>'.esc_html__('Workflow', 'entercheck-company-search').'</strong> '.esc_html__('processing mode forwards data specified on the form mapping page and executes the workflow.', 'entercheck-company-search').'</p>';
	}
	
    function entercheck_plugin_setting_request_mode()
    {
		$options = get_option('entercheck_plugin_options', array());
		
		if (!isset($options['request_mode'])) { $options['request_mode'] = "simple"; }
?>
		<select name="entercheck_plugin_options[request_mode]">
			<option value="simple" <?php if ($options['request_mode'] == 'simple') echo 'selected="selected"'; ?>>Simple</option>
			<option value="smart" <?php if ($options['request_mode'] == 'smart') echo 'selected="selected"'; ?>>Workflow</option>
		</select>
<?php 	
    }
	
	
	
	function entercheck_plugin_setting_smart_form_id(){
		$options = get_option('entercheck_plugin_options', array());

        if (!isset($options['smart_form_id'])) {
            $options['smart_form_id'] = "";
        }

		echo '<label for="company_name-id">'.esc_attr__('Workflow ID - null uses default value', 'entercheck-company-search').'</label><br>';
		echo "<input id='entercheck_plugin_setting_smart_form_id' name='entercheck_plugin_options[smart_form_id]' type='text' value='" . esc_attr($options['smart_form_id']) . "' />";
	}
	
	
	function entercheck_plugin_setting_api_key()
    {
        $options = get_option('entercheck_plugin_options', array());

        if (!isset($options['api_key'])) {
            $options['api_key'] = "";
        }

        echo "<textarea rows='3' cols='100' id='entercheck_plugin_setting_api_key' name='entercheck_plugin_options[api_key]'>" . esc_attr($options['api_key']) . "</textarea>";
    }
	
	
    function entercheck_plugin_setting_start_date()
    {
        $options = get_option('entercheck_plugin_options', array());

        if (!isset($options['start_date'])) {
            $options['start_date'] = "";
        }

        echo "<input id='entercheck_plugin_setting_start_date' name='entercheck_plugin_options[start_date]' type='text' value='" . esc_attr($options['start_date']) . "' />";
    }

    function entercheck_plugin_setting_enterchecktoken()
    {
    }
    ?>

</form>
</div>

<h2>Test API call</h2>
<p><?php esc_attr_e('You can verify that your credentials are valid for the given environment by sending a test request.', 'entercheck-company-search'); ?></p>
<button id="test-call-btn" onclick="search_company()"><?php esc_attr_e('Make a test API call', 'entercheck-company-search'); ?></button>
<div id="search_company_result"></div>