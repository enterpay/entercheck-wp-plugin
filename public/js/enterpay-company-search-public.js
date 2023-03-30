(function( $ ) {
	'use strict';

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

	 $(document).ready(function() {
		console.log("typeahead");
		var substringMatcher = function(strs) {
			return function findMatches(q, cb) {
			  var matches, substringRegex;
		  
			  // an array that will be populated with substring matches
			  matches = [];
		  
			  // regex used to determine if a string contains the substring `q`
			  var substrRegex = new RegExp(q, 'i');
		  
			  // iterate through the pool of strings and for any string that
			  // contains the substring `q`, add it to the `matches` array
			  $.each(strs, function(i, str) {
				if (substrRegex.test(str)) {
				  matches.push(str);
				}
			  });
		  
			  cb(matches);
			};
		  };
		  
		  var data = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
			'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
			'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
			'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
			'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
			'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
			'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
			'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
			'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
		  ];
		  
		  $('#autoCom .typeahead').typeahead({
			hint: true,
			highlight: true,
			minLength: 1
		  },
		  {
			name: 'states',
			source: substringMatcher(data)
		  });
	});

})( jQuery );

//autoCom	

