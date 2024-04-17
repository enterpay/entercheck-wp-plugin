<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://demoshop.entercheck.eu/
 * @since             1.0.0
 * @package           Entercheck_Company_Search
 *
 * @wordpress-plugin
 * Plugin Name:       Entercheck
 * Plugin URI:        https://entercheck.eu/en
 * Description:       entercheck company search 
 * Version:           1.0.5
 * Author:            Entercheck <support@entercheck.eu>
 * Author URI:        https://demoshop.entercheck.eu/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       entercheck-company-search
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ENTERCHECK_COMPANY_SEARCH_VERSION', '1.0.4' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-entercheck-company-search-activator.php
 */
function entercheck_activate_company_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-entercheck-company-search-activator.php';
	entercheck_Company_Search_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-entercheck-company-search-deactivator.php
 */
function entercheck_deactivate_company_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-entercheck-company-search-deactivator.php';
	entercheck_Company_Search_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'entercheck_activate_company_search' );
register_deactivation_hook( __FILE__, 'entercheck_deactivate_company_search' );


require_once plugin_dir_path( __FILE__ ) . 'includes/class-entercheck-country.php';
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-entercheck-company-search.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function entercheck_run_company_search() {

	$plugin = new Entercheck_Company_Search();
	$plugin->run();

}
entercheck_run_company_search();