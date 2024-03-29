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
	if ($("#" + enterpayjs.company_name_id).length){  
		if (enterpayjs.business_id_auto == 1){
			$('form').each(function(){
				var form = $( this );
				var form_comp_fields = form.find("#" + enterpayjs.company_name_id);
				if (form_comp_fields.length > 0){
					var form_buisness_fields = form.find("#" + enterpayjs.business_id_id);
					if (!form_buisness_fields.length){
						$('<input type="hidden" id="' + enterpayjs.business_id_id_first + '" name="' + enterpayjs.business_id_name_first + '">').insertAfter($("#" + enterpayjs.company_name_id));
					}
				}
			});
		} 
		 
		if ($("#" + enterpayjs.invoice_selector_id).length && $("#" + enterpayjs.invoice_selector_id).is('select')){ 
			//$("#" + enterpayjs.invoice_selector_id).attr('readonly','readonly');
			
			$("#" + enterpayjs.invoice_selector_id).on('change', function(){
				var select = $("#" + enterpayjs.invoice_selector_id + " option:selected").val().split(' / ');
				if (select.length > 0) $("#" + enterpayjs.invoice_address_id).val(select[0]);
				if (select.length > 1) $("#" + enterpayjs.invoice_operator_code_id).val(select[1]);					
			});
		}
		
		$("#" + enterpayjs.company_name_id).attr('title', enterpayjs.company_name_tootltip);
		$('<div id="company_loader"></div>').insertAfter($("#" + enterpayjs.company_name_id));	
		$("#" + enterpayjs.company_name_id).typeahead({
		  source: function (query, result) {
			$.ajax({
			  url: enterpayjs.ajaxurl,
			  data: { action: "call_api", nonce: nonce },
			  dataType: "json",
			  type: "POST",
			}).done(function (data) {
			  result(
				$.map(data, function (item) {
				  return item;
				})
			  );
			});
		  },
		});
		
		if (enterpayjs.allow_search_country == 1){
			$("#" + enterpayjs.search_country_id).html('');
			if ($("#" + enterpayjs.search_country_id).length && $("#" + enterpayjs.search_country_id).is('select')){ 
				$.each(enterpayjs.search_country_list, function(key, value) {
					 $("#" + enterpayjs.search_country_id)
						.append($("<option></option>")
						.attr("value", key)
						.text(value)); 
				});	
				$("#" + enterpayjs.search_country_id).val(enterpayjs.default_country);	
			}
		}

		function enterpayCountry(){
			if (enterpayjs.allow_search_country == 1 && $("#" + enterpayjs.search_country_id).length) return $("#" + enterpayjs.search_country_id).val();
			else if (enterpayjs.default_country.length) return enterpayjs.default_country;
			
			return 'FI';
		}

		var dataset = new Bloodhound({
		  datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
		  queryTokenizer: Bloodhound.tokenizers.whitespace,
		  remote: {
			url: enterpayjs.ajaxurl + "?action=search_company", //&name=%QUERY&country=FI",
			wildcard: "%QUERY",			
			replace: function (url, query) {
				return url + "&name=" + encodeURI($("#" + enterpayjs.company_name_id).val()) + "&country=" + enterpayCountry(); //%QUERY
			},			
		  },
		});

		$("#" + enterpayjs.company_name_id).typeahead(null, {
		  name: "company-search",
		  display: "name",
		  source: dataset,
		  templates: {
			empty: [
			  '<div class="empty-message">No results found</div>'
			]		
		  }	  
		});

		$("#" + enterpayjs.company_name_id).bind("typeahead:asyncrequest", function (ev, query, dataset) {
			$('#company_loader').addClass('spinner');
		});
		$("#" + enterpayjs.company_name_id).bind("typeahead:asynccancel", function (ev, query, dataset) {
			$('#company_loader').removeClass('spinner');
		});
		$("#" + enterpayjs.company_name_id).bind("typeahead:asyncreceive", function (ev, query, dataset) {
			$('#company_loader').removeClass('spinner');
		});


		$("#" + enterpayjs.company_name_id).bind("typeahead:select", function (ev, suggestion) {
		  console.log(suggestion);
		  $('#company_loader').addClass('spinner');

		  // set suggestion to local storage
		  localStorage.setItem("company", JSON.stringify(suggestion));

		  $("#" + enterpayjs.business_id_id).val(suggestion.businessId);
		  jQuery
			.ajax({
			  type: "post",
			  dataType: "json",
			  url: enterpayjs.ajaxurl,
			  data: { action: "company_detail", bid: suggestion.businessId, country: enterpayCountry },
			})
			.done(function (e) {
			  console.log(e);
			  var ids = e.ids;
			  ids.forEach((id) => {
				if (id.idType == "VAT" && $("#" + enterpayjs.vat_number_id).length) $("#" + enterpayjs.vat_number_id).val(id.idValue);
			  });

			if ($("#" + enterpayjs.business_line_id).length) $("#" + enterpayjs.business_line_id).val(e.companyBusinessLineValue);

			  var address = e.postalAddress[0];
			  if ($("#" + enterpayjs.country_id).length) $("#" + enterpayjs.country_id).val(address.country);
			  if ($("#" + enterpayjs.city_id).length) $("#" + enterpayjs.city_id).val(address.city);
			  if ($("#" + enterpayjs.street_id).length) $("#" + enterpayjs.street_id).val(address.street);
			  if ($("#" + enterpayjs.street_second_id).length) $("#" + enterpayjs.street_second_id).val(address.streetSecondRow);
			  if ($("#" + enterpayjs.postal_code_id).length) $("#" + enterpayjs.postal_code_id).val(address.postalCode);
			  
			  if (/*enterpayjs.display_invoice_address == 1 &&*/ $("#" + enterpayjs.invoice_selector_id).length){
				  
				var invoiceAddressData = [];
				var invoiceAddress = e.receivingFinvoiceAddress;  
				
				if (invoiceAddress.length){
					for (var i=0;i<invoiceAddress.length;++i){
						invoiceAddressData.push(invoiceAddress[i].address + ' / ' + invoiceAddress[i].operatorCode);
						
						if (i==0){
							if ($("#" + enterpayjs.invoice_address_id).length) $("#" + enterpayjs.invoice_address_id).val(invoiceAddress[i].address);
							if ($("#" + enterpayjs.invoice_operator_code_id).length) $("#" + enterpayjs.invoice_operator_code_id).val(invoiceAddress[i].operatorCode);
						}
					}
				}
				  
				if ($("#" + enterpayjs.invoice_selector_id).is("input") ){
					if (invoiceAddressData.length)
						$("#" + enterpayjs.invoice_selector_id).val(invoiceAddressData[0]);
					else
						$("#" + enterpayjs.invoice_selector_id).val('');
				}  else if ($("#" + enterpayjs.invoice_selector_id).is("select") ){
					$("#" + enterpayjs.invoice_selector_id).html('');
					$.each(invoiceAddressData, function(key, value) {
						 $("#" + enterpayjs.invoice_selector_id)
							 .append($("<option></option>")
										.attr("value", value)
										.text(value)); 
					});
				}
				  /*
				$("#" + enterpayjs.invoice_selector_id).val('');
				var invoiceAddressData = $("#" + enterpayjs.invoice_selector_id).val();
				var invoiceAddress = e.receivingFinvoiceAddress;  
				
				for (var i=0;i<invoiceAddress.length;++i){
					if (i != 0)	invoiceAddressData += '\n';
					
					invoiceAddressData += 'Company name:  ' + invoiceAddress[i].name + '\n';
					invoiceAddressData += 'Address:  ' + invoiceAddress[i].address + '\n';
					invoiceAddressData += 'Operator code:  ' + invoiceAddress[i].operatorCode + '\n';
					invoiceAddressData += 'Operator:  ' + invoiceAddress[i].operator + '\n';
					invoiceAddressData += 'OVT:  ' + invoiceAddress[i].ovt + '\n';
				}
				$("#" + enterpayjs.invoice_selector_id).val(invoiceAddressData);
				*/
			  } else {
					if ($("#" + enterpayjs.invoice_address_id).length) {						
						$("#" + enterpayjs.invoice_address_id).val(e.receivingFinvoiceAddress.length ? e.receivingFinvoiceAddress[0].address : '');
					}
					if ($("#" + enterpayjs.invoice_operator_code_id).length) {
						$("#" + enterpayjs.invoice_operator_code_id).val(e.receivingFinvoiceAddress.length ? e.receivingFinvoiceAddress[0].operatorCode : '');
					}
			  }
			  
			  $("#company_info").val(JSON.stringify(e));
			  
			  $('#company_loader').removeClass('spinner');
			});
		});
		
		
	}
  });
})(jQuery);
