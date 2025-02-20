(function ($) {
  "use strict";

  /**
   * All of the code for your public-facing JavaScript source
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

  $(document).ready(function () {
	if ($("#" + entercheckjs.company_name_id).length){  		
		$('form').each(function(){
			var form = $( this );
			var form_comp_fields = form.find("#" + entercheckjs.company_name_id);
			if (form_comp_fields.length > 0){
				if (entercheckjs.business_id_auto == 1){
					var form_buisness_fields = form.find("#" + entercheckjs.business_id_id);
					if (!form_buisness_fields.length){
						$('<input type="hidden" id="' + entercheckjs.business_id_id_first + '" name="' + entercheckjs.business_id_name_first + '">').insertAfter($("#" + entercheckjs.company_name_id));
					}
				}
				
				$(entercheckjs.entercheck_nonce_field).insertAfter($("#" + entercheckjs.company_name_id));
			}
		});
		
		 
		if ($("#" + entercheckjs.invoice_selector_id).length && $("#" + entercheckjs.invoice_selector_id).is('select')){ 
			//$("#" + entercheckjs.invoice_selector_id).attr('readonly','readonly');
			
			$("#" + entercheckjs.invoice_selector_id).on('change', function(){
				var select = $("#" + entercheckjs.invoice_selector_id + " option:selected").val().split(' / ');
				if (select.length > 0) $("#" + entercheckjs.invoice_address_id).val(select[0]);
				if (select.length > 1) $("#" + entercheckjs.invoice_operator_code_id).val(select[1]);					
			});
		}
		
		$("#" + entercheckjs.company_name_id).attr('title', entercheckjs.company_name_tootltip);
		$('<div id="company_loader"></div>').insertAfter($("#" + entercheckjs.company_name_id));	
		
		if (entercheckjs.allow_search_country == 1){
			$("#" + entercheckjs.search_country_id).html('');
			if ($("#" + entercheckjs.search_country_id).length && $("#" + entercheckjs.search_country_id).is('select')){ 
				$.each(entercheckjs.search_country_list, function(key, value) {
					 $("#" + entercheckjs.search_country_id)
						.append($("<option></option>")
						.attr("value", key)
						.text(value)); 
				});	
				$("#" + entercheckjs.search_country_id).val(entercheckjs.default_country);	
			}
		}

		function entercheckCountry(){
			if (entercheckjs.allow_search_country == 1 && $("#" + entercheckjs.search_country_id).length) return $("#" + entercheckjs.search_country_id).val();
			else if (entercheckjs.default_country.length) return entercheckjs.default_country;
			
			return 'FI';
		}

		var dataset = new Bloodhound({
		  datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
		  queryTokenizer: Bloodhound.tokenizers.whitespace,
		  remote: {
			//url: entercheckjs.ajaxurl + "?action=search_company", //&name=%QUERY&country=FI",
			url: entercheckjs.search_url,
			wildcard: "%QUERY",
			/*
			replace: function (url, query) {
				//url = 'https://api.test.entercheck.eu/search/company?country=fi&name=Entercheck&limit=5';
								
				//let nonce = $("input[name='entercheck_nonce']").val();
				//return url + "&name=" + encodeURI($("#" + entercheckjs.company_name_id).val()) + "&country=" + entercheckCountry() + "&nonce=" + nonce; //%QUERY
				return url + "?name=" + encodeURI($("#" + entercheckjs.company_name_id).val()) + "&country=" + entercheckCountry(); //%QUERY
			},
			*/
			prepare: function (query, settings) {
				settings.url = settings.url + "?name=" + encodeURI($("#" + entercheckjs.company_name_id).val()) + "&country=" + entercheckCountry();
				settings.headers = {
				  'X-Entercheck-Authorization': entercheckjs.search_token
				};

				return settings;
			},
		  },
		});

		$("#" + entercheckjs.company_name_id).typeahead(null, {
		  name: "company-search",
		  display: "name",
		  source: dataset,
		  templates: {
			empty: [
			  '<div class="empty-message">No results found</div>'
			]		
		  }	  
		});

		$("#" + entercheckjs.company_name_id).bind("typeahead:asyncrequest", function (ev, query, dataset) {
			$('#company_loader').addClass('spinner');
		});
		$("#" + entercheckjs.company_name_id).bind("typeahead:asynccancel", function (ev, query, dataset) {
			$('#company_loader').removeClass('spinner');
		});
		$("#" + entercheckjs.company_name_id).bind("typeahead:asyncreceive", function (ev, query, dataset) {
			$('#company_loader').removeClass('spinner');
		});


		$("#" + entercheckjs.company_name_id).bind("typeahead:select", function (ev, suggestion) {
		  console.log(suggestion);
		  $('#company_loader').addClass('spinner');

		  // set suggestion to local storage
		  localStorage.setItem("company", JSON.stringify(suggestion));

		  $("#" + entercheckjs.business_id_id).val(suggestion.businessId);
		  let nonce = $("input[name='entercheck_nonce']").val();
		  jQuery
			.ajax({
			  type: "post",
			  dataType: "json",
			  url: entercheckjs.ajaxurl,
			  data: { action: "company_detail", bid: suggestion.businessId, country: entercheckCountry(), nonce: nonce },
			})
			.done(function (e) {
			  console.log(e);
			  var ids = e.ids;
			  ids.forEach((id) => {
				if (id.idType == "VAT" && $("#" + entercheckjs.vat_number_id).length) $("#" + entercheckjs.vat_number_id).val(id.idValue);
			  });

			if ($("#" + entercheckjs.business_line_id).length) $("#" + entercheckjs.business_line_id).val(e.companyBusinessLineValue);

			  var address = e.postalAddress[0];
			  if ($("#" + entercheckjs.country_id).length) $("#" + entercheckjs.country_id).val(address.country);
			  if ($("#" + entercheckjs.city_id).length) $("#" + entercheckjs.city_id).val(address.city);
			  if ($("#" + entercheckjs.street_id).length) $("#" + entercheckjs.street_id).val(address.street);
			  if ($("#" + entercheckjs.street_second_id).length) $("#" + entercheckjs.street_second_id).val(address.streetSecondRow);
			  if ($("#" + entercheckjs.postal_code_id).length) $("#" + entercheckjs.postal_code_id).val(address.postalCode);
			  
			  if (/*entercheckjs.display_invoice_address == 1 &&*/ $("#" + entercheckjs.invoice_selector_id).length){
				  
				var invoiceAddressData = [];
				var invoiceAddress = e.receivingFinvoiceAddress;  
				
				if (invoiceAddress.length){
					for (var i=0;i<invoiceAddress.length;++i){
						invoiceAddressData.push(invoiceAddress[i].address + ' / ' + invoiceAddress[i].operatorCode);
						
						if (i==0){
							if ($("#" + entercheckjs.invoice_address_id).length) $("#" + entercheckjs.invoice_address_id).val(invoiceAddress[i].address);
							if ($("#" + entercheckjs.invoice_operator_code_id).length) $("#" + entercheckjs.invoice_operator_code_id).val(invoiceAddress[i].operatorCode);
						}
					}
				}
				  
				if ($("#" + entercheckjs.invoice_selector_id).is("input") ){
					if (invoiceAddressData.length)
						$("#" + entercheckjs.invoice_selector_id).val(invoiceAddressData[0]);
					else
						$("#" + entercheckjs.invoice_selector_id).val('');
				}  else if ($("#" + entercheckjs.invoice_selector_id).is("select") ){
					$("#" + entercheckjs.invoice_selector_id).html('');
					$.each(invoiceAddressData, function(key, value) {
						 $("#" + entercheckjs.invoice_selector_id)
							 .append($("<option></option>")
										.attr("value", value)
										.text(value)); 
					});
				}
			  } else {
					if ($("#" + entercheckjs.invoice_address_id).length) {						
						$("#" + entercheckjs.invoice_address_id).val(e.receivingFinvoiceAddress.length ? e.receivingFinvoiceAddress[0].address : '');
					}
					if ($("#" + entercheckjs.invoice_operator_code_id).length) {
						$("#" + entercheckjs.invoice_operator_code_id).val(e.receivingFinvoiceAddress.length ? e.receivingFinvoiceAddress[0].operatorCode : '');
					}
			  }
			  
			  $("#company_info").val(JSON.stringify(e));
			  
			  $('#company_loader').removeClass('spinner');
			});
		});
		
		
	}
  });
})(jQuery);
