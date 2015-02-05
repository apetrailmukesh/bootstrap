var jqNC = jQuery.noConflict();

jqNC("#open-mobile-search").on("click", function() {
	jqNC("#mobile-search-box").toggle();
})

jqNC(document).foundation();

var vehicleMatcher = function() {
	return function findMatches(q, cb) {
		jqNC.ajax({
			type: "GET",
			url: "/suggest/vehicle",
			data: {'query' : q},
			dataType: "json",
			success: function (data) {
				cb(data);
			}
		});
	};
};

var zipMatcher = function() {
	return function findMatches(q, cb) {
		jqNC.ajax({
			type: "GET",
			url: "/suggest/zip",
			data: {'query' : q},
			dataType: "json",
			success: function (data) {
				cb(data);
			}
		});
	};
};

jqNC(document).ready(function() {
	jqNC('.vehicle-search').typeahead({
		hint: true,
		highlight: true,
		minLength: 1
	},
	{
		name: 'vehicle_search',
		displayKey: 'value',
		source: vehicleMatcher()
	});

	jqNC('.zip-search').typeahead({
		hint: true,
		highlight: true,
		minLength: 1
	},
	{
		name: 'zip_search',
		displayKey: 'value',
		source: zipMatcher()
	});
});