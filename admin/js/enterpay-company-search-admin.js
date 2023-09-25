(function ($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 
	 $( document ).on('click', '#preset_wc_fields', function(){
		 if (confirm('Are you sure you want to replace the current fields?')){
			 $('#company_name-name').val('billing_company');
			 $('#company_name-id').val('billing_company');
			 
			 $('#country-name').val('billing_country');
			 $('#country-id').val('billing_country');
			 $('#city-name').val('billing_city');
			 $('#city-id').val('billing_city');
			 $('#street-name').val('billing_address_1');
			 $('#street-id').val('billing_address_1');
			 $('#street_second-name').val('billing_address_2');
			 $('#street_second-id').val('billing_address_2');
			 $('#postal_code-name').val('billing_postcode');
			 $('#postal_code-id').val('billing_postcode');
		 }
	 });

})(jQuery);


function search_company() {
	//var e = document.getElementById("search_company_result");

	jQuery.ajax({
		type: "post",
		dataType: "json",
		url: ajaxurl+"?name=a",
		data: { action: "search_company", nonce: nonce }
	}).done(function (e) {
		jQuery("#search_company_result").html("<pre>" + JSON.stringify(e) + "</pre>");
	});
}
