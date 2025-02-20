=== Entercheck Company Search ===
Contributors: Entercheck
Donate link: https://demoshop.entercheck.eu/
Tags: company, search, registration, form
Requires at least: 6.1.4
Tested up to: 6.6.1
Stable tag: 1.0.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Fetch company names and details from company registry API to integrate with your site's forms.

== Description ==

## Entercheck's Company Search plugin integrates real-time company information into your WordPress forms, ensuring accurate and comprehensive data entry. ## 

## Helpful Links: ## 

* [Portal](https://portal.entercheck.eu/)
* [Tutorial](https://docs.entercheck.eu/)
* [Demo](https://demoshop.entercheck.eu/test/)

## Key Features: ## 

* **Type-Ahead Search & Autofill:** Enhances form input with predictive company name suggestions.
* **Seamless Integration:** Works effortlessly with existing forms to ensure accurate data capture.
* **Data Enrichment Workflows:** Triggers processes that enrich and export data post-submission.
* **CRM Export:** Easily export enriched data to your CRM systems.

Ensure all provided information is correct by adding type-ahead search for end-users. Fetch company names, details, and statuses upon form submission. Trigger workflows to enrich and export data, and incorporate this information into WordPress user profiles during registration. Manage data through the WordPress user page and the Entercheck backend portal. Registration at [portal.entercheck.eu/register](https://portal.entercheck.eu/register) is required.

## Limitations: ## 

Currently supports only Finland and Norway. For support in other countries, please reach out. The backend is prepared for global support.

== Frequently Asked Questions ==

= How do I integrate the company search functionality with my form? =

Use the following shortcodes to integrate:

**[company_name_dropdown]**  
Displays a dropdown list of company names fetched from the company registry API.

**[company_details company_id='123']**  
Fetches and displays details for a specific selected company based on its ID.

**[company_status company_id='123']**  
Retrieves and displays the status of a company based on its ID.

Incorporate these shortcodes within your form as needed to provide the desired functionality.

== Installation ==

1. Install the plugin through the WP admin console (or upload and the plugin)
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add API Credentials on the Plugin > Credentials page
4. Use the provided hooks or shortcodes in your forms to integrate the company search functionality.
== Changelog ==

= 1.0 =
* Initial release with key features: Authenticate with Entercheck backend, fetch company names and details, fetch company status, and add this information to user.

= 1.0.1 =
* Added support for multiple countries.
* Stored link to the company page in the Entercheck portal in global variables.

= 1.0.2 =
* Enabled workflow processing mode.
* Updated admin settings

= 1.0.3 =
* Updated texts.

= 1.0.4 =
* Fixed country search admin panel bug.
* Switched to POST /companies endpoint.
* Introduced advanced search mode.

= 1.0.5 =
* Refactoring.

= 1.0.6 =
* Refactoring.

= 1.0.7 =
* Refactoring.

= 1.0.8 =
* Updated workflow descriptions.
* Improved search speed by moving the search integration to the client side.

= 1.0.9 =
* The number of re-authentication attempts is limited.

= 1.0.10 =
* Fixed a requset to comany/details

= 1.0.11 =
* Fixed a requset to comany/details

== Upgrade Notice ==

= 1.0.8 =
Upgrade to get access to the search UX improvements
