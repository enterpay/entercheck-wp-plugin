=== Entercheck Company Search ===
Contributors: Entercheck 
Donate link: https://demoshop.entercheck.eu/
Tags: company, search, registration, form
Requires at least: WordPress 6.1.4
Tested up to: WordPress 6.1.4
Stable tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Fetch company names and details from company registry API to integrate with your site's forms.

== Description ==

Entercheck's Company Search plugin allows behind-the-scenes integration with company registry APIs to populate and augment WordPress registration form fields. The plugin offers features to fetch company names and details, fetch company status and other processed details when a form is submitted, and add this information to a WordPress user during registration. The information is available at the WordPress user page and in the Entercheck backend portal. Using the Plugin requires registering at portal.entercheck.eu/register

== Installation ==

1. Upload `entercheck-company-search.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Sign up for the Entercheck service if you haven't already done so. Visit [Entercheck website](https://portal.entercheck.eu) to create an account.
4. Identify the HTML field IDs in the forms where you want to enable the functionality of the Enterpay Company Search plugin. Enter the HTML field IDs in the appropriate field or box provided.

== Frequently Asked Questions ==

= How do I integrate the company search functionality with my form? =

To integrate the company search functionality with your form, enter the HTML field IDs in the appropriate field in the settings.

= How do I submit the company data to Entercheck? =

You must include the "business id" field in the form. You can add a hidden business id field by selecting "Add automatically" from the settings.

= How do I submit the company data to during WooCommerce checkout? =

You must include the "business id" field in the form. You can add a hidden business id field by selecting "Add automatically" from the settings.

= How do I add e-invoice details? =

To create a dropdown you can add select type form element
<select id="invoice_address" name="invoice_address"></select><br><br>

if you want to allow user to edit and write, you can use input type
<label for="invoice_address">e-invoice address: </label>
<input type="text" id="invoice_address" name="invoice_address"><br><br>


== Screenshots ==

1. Screenshot of the dropdown list populated with company names from the API.
2. Details fetched for a selected company from the dropdown list.

== Changelog ==

= 1.0 =
* Initial release with key features: Authenticate with Enterhcek backend, Fetch company names and details, fetch company status, and add this information to a WordPress user.

== Upgrade Notice ==

= 1.0 =
Upgrade to get access to the company search and integration features for your forms.
