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
    $("#billing_company").typeahead({
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

    $("#billing_company").typeahead(null, {
      name: "company-search",
      display: "name",
      source: dataset,
    });

    $("#billing_company").bind("typeahead:select", function (ev, suggestion) {
      console.log(suggestion);

      // set suggestion to local storage
      localStorage.setItem("company", JSON.stringify(suggestion));

      $("#inputBusinessId").val(suggestion.businessId);
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
            if (id.idType == "VAT") $("#inputVATNumber").val(id.idValue);
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
        $("#inputVATNumber_field").hide();
        // clear VAT number field
        $("#inputVATNumber").val("");
        // Hide business id field
        $("#inputBusinessId_field").hide();
        // clear business id field
        $("#inputBusinessId").val("");
      } else {
        $("#inputVATNumber_field").show();
        $("#inputBusinessId_field").show();
      }
    });
  });
})(jQuery);
