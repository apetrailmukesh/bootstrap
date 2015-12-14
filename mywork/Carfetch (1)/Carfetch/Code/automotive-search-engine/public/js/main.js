var jqNC = jQuery.noConflict();

jqNC("#open-mobile-search").on("click", function() {
	jqNC("#mobile-search-box").toggle();
})

jqNC(document).foundation({
	equalizer: {
		equalize_on_stack: true
	}
});

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
});

if (Modernizr.mq('only screen and (max-width:40em)')) {
	jqNC(document).swipe({
		swipeLeft: function (event, direction, distance, duration, fingerCount, fingerData) {
			jqNC('.off-canvas-wrap').removeClass('move-right');
		},
		threshold: 0
	});
	jqNC(".exit-off-canvas").swipe({
		tap: function(event, direction, distance, duration, fingerCount, fingerData) {
			jqNC('.off-canvas-wrap').removeClass('move-right');
		}
	})
}

if (Modernizr.mq('only screen and (min-width: 40.063em)')) {
	var windowHeight = jqNC(window).height();
	var docHeight = jqNC(document).height();
	if (docHeight <= windowHeight) {
		jqNC("footer").addClass("sticky");
	}
}