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

    var dataset = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
        url: enterpayjs.ajaxurl + "?action=search_company&name=%QUERY",
        wildcard: "%QUERY",
      },
    });

    $("#" + enterpayjs.company_name_id).typeahead(null, {
      name: "company-search",
      display: "name",
      source: dataset,
    });

    $("#" + enterpayjs.company_name_id).bind("typeahead:select", function (ev, suggestion) {
      console.log(suggestion);

      // set suggestion to local storage
      localStorage.setItem("company", JSON.stringify(suggestion));

      $("#" + enterpayjs.business_id_id).val(suggestion.businessId);
      jQuery
        .ajax({
          type: "post",
          dataType: "json",
          url: enterpayjs.ajaxurl,
          data: { action: "company_detail", bid: suggestion.businessId },
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
		  
          $("#company_info").val(JSON.stringify(e));
        });
    });
  });
})(jQuery);
