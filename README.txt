=== Entercheck Company Search ===
Contributors: Entercheck
Donate link: https://demoshop.entercheck.eu/
Tags: company, search, registration, form
Requires at least: 6.1.4
Tested up to: 6.5.2
Stable tag: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Fetch company names and details from company registry API to integrate with your site's forms.

== Description ==
Entercheck's Company Search plugin seamlessly integrates with company registry APIs to enhance WordPress registration forms. This plugin automates the fetching and populating of company names, details, and statuses from user submissions during the registration process. This enriched data is then available on the WordPress user page and the Entercheck backend portal.

Additionally, the plugin features a smart processing mode that enables the forwarding of data to external systems, such as CRM systems. This facilitates a more connected and efficient data management workflow, making it ideal for users seeking to integrate their website's data with other business tools.

== Important Disclosure  ==
This plugin relies on external services provided by Entercheck for its functionality. Data transmitted includes company search and query details required to authenticate and retrieve company information directly from our servers. 

== External Services Used ==
- Authentication (`https://api.entercheck.eu/v1/auth`)
- Company search (`https://api.entercheck.eu/company/search`)
- Company details retrieval (`https://api.entercheck.eu/company/details`)
- Form submission endpoint (`https://api.entercheck.eu/forms/submit`)
- Company registration and modification (`https://api.entercheck.eu/companies`)

For full details on the data we process and how we manage it, please review our Privacy Policy and Terms of Service:
- [Entercheck Privacy Policy](https://entercheck.eu/privacy)
- [Entercheck Terms of Service](https://entercheck.eu/terms)

== Usage of Plugin ==
Prior use requires registration at [Entercheck Registration Portal](https://portal.entercheck.eu/register).

== Availability ==
The plugin is currently only available in the Finnish and Norwegian markets.

== Installation ==

1. Activate the plugin through the 'Plugins' menu in WordPress
2. Use the provided hooks or shortcodes in your forms to integrate the company search functionality.

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

== Screenshots ==

1. Screenshot of the dropdown list populated with company names from the API.
2. Details fetched for a selected company from the dropdown list.

== Changelog ==

= 1.0 =
* Initial release with key features: Authenticate with Enterhcek backend, Fetch company names and details, fetch company status, and add this information to a WordPress user.

= 1.0.1 =
* Add support for multiple countries

= 1.0.2 = 
* Country search settings

= 1.0.3 = 
* Enable Smart processing mode

= 1.0.4 =
* Advanced search mode in Finland

= 1.0.5 =
* Compatability with WorpPress plugin directory

== Upgrade Notice ==

= 1.0 =
Upgrade to get access to the company search and integration features for your forms.
