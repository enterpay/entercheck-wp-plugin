=== Entercheck Company Search ===
Contributors: Entercheck
Donate link: https://demoshop.entercheck.eu/
Tags: company, search, registration, form
Requires at least: 6.1.4
Tested up to: 6.5.4
Stable tag: 1.0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Fetch company names and details from company registry API to integrate with your site's forms.

== Description ==

Entercheck's Company Search plugin allows behind-the-scenes integration with company registry APIs to populate and augment WordPress registration form fields. The plugin offers features to fetch company names and details, fetch company status and other processed details when a form is submitted, and add this information to a WordPress user during registration. The information is available at the WordPress user page and in the Entercheck backend portal. Using the Plugin requires registering at portal.entercheck.eu/register

== Installation ==

1. Upload `entercheck-company-search.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the provided hooks or shortcodes in your forms to integrate the company search functionality.

== Frequently Asked Questions ==

= How do I integrate the company search functionality with my form? =

To integrate the company search functionality with your form, use the following shortcodes:

**[company_name_dropdown]**

This shortcode displays a dropdown list of company names fetched from the company registry API.

**[company_details company_id='123']**

This shortcode fetches and displays details for a specific selected company based on its ID.

**[company_status company_id='123']**

This shortcode retrieves and displays the status of a company based on its ID.

Use these shortcodes appropriately within your form to provide the desired functionality.

== External Services ==
The plugin depends on Entercheck, a service used to integrate with various 3rd party information providers.

- More information about the service can be found here: [https://docs.entercheck.eu/](https://docs.entercheck.eu/)
- Production API: [api.entercheck.eu](https://api.entercheck.eu)
- Test API: [api.test.entercheck.eu](https://api.test.entercheck.eu)
- Developer Docs: [https://developer.entercheck.eu/](https://developer.entercheck.eu/)
- Terms of Service: [https://www.entercheck.eu/terms-of-service/](https://www.entercheck.eu/terms-of-service/)
- Privacy Policy: [https://www.entercheck.eu/privacy-policy/](https://www.entercheck.eu/privacy-policy/)

== Changelog ==

= 1.0 =
* Initial release with key features: Authenticate with Enterhcek backend, Fetch company names and details, fetch company status, and add this information to a WordPress user.
