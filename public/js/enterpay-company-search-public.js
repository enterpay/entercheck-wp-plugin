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
            if (id.idType == "VAT") $("#" + enterpayjs.vat_number_id).val(id.idValue);
          });

          var address = e.addresses[0];
          $("#billing_address_1").val(address.street);
          $("#billing_city").val(address.city);
          $("#billing_postcode").val(address.postalCode);
          $("#company_info").val(JSON.stringify(e));
        });
    });

    // if select consumer_or_business get value consumers then hide inputVATNumber_field and inputBusinessId_field
    $("#consumer_or_business").change(function () {
      var consumer_or_business = $(this).val();
      if (consumer_or_business == "consumers") {
        // Hide VAT number field
        $("#billing_company_field").hide();
        $("#" + enterpayjs.vat_number_id + "_field").hide();
        // clear VAT number field
        $("#" + enterpayjs.vat_number_id).val("");
        // Hide business id field
        $("#" + enterpayjs.business_id_id + "_field").hide();
        // clear business id field
        $("#" + enterpayjs.business_id_id).val("");
      } else {
        $("#" + enterpayjs.vat_number_id + "_field").show();
        $("#" + enterpayjs.business_id_id + "_field").show();
      }
    });
   let consumer_or_business = $("#consumer_or_business").val();
    console.log(consumer_or_business);
    if (consumer_or_business == "consumers") {
      // Hide VAT number field
      $("#billing_company_field").hide();
      $("#" + enterpayjs.vat_number_id + "_field").hide();
      // clear VAT number field
      $("#" + enterpayjs.vat_number_id).val("");
      // Hide business id field
      $("#" + enterpayjs.business_id_id + "_field").hide();
      // clear business id field
      $("#" + enterpayjs.business_id_id).val("");
    }
  });
})(jQuery);
