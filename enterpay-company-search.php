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
 * @package           Enterpay_Company_Search
 *
 * @wordpress-plugin
 * Plugin Name:       Entercheck
 * Plugin URI:        https://entercheck.eu/en
 * Description:       enterpay company search 
 * Version:           1.0.4
 * Author:            Enterpay <technical@enterpay.fi>
 * Author URI:        https://demoshop.entercheck.eu/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       entercheck-company-search
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ENTERPAY_COMPANY_SEARCH_VERSION', '1.0.4' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-enterpay-company-search-activator.php
 */
function activate_enterpay_company_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-enterpay-company-search-activator.php';
	Enterpay_Company_Search_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-enterpay-company-search-deactivator.php
 */
function deactivate_enterpay_company_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-enterpay-company-search-deactivator.php';
	Enterpay_Company_Search_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_enterpay_company_search' );
register_deactivation_hook( __FILE__, 'deactivate_enterpay_company_search' );


require_once plugin_dir_path( __FILE__ ) . 'includes/class-enterpay-country.php';
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-enterpay-company-search.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_enterpay_company_search() {

	$plugin = new Enterpay_Company_Search();
	$plugin->run();

}
run_enterpay_company_search();
