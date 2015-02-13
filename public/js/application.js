(function ($) {

	setupPager();
	selectSort();
	selectFilters();

	$('h1.logo').click(function() {
		var home = location.protocol + '//' + location.hostname;
		window.location.href = home;
  		event.preventDefault();
	});

	$('.results-search-form').submit(function(event) {
  		var search_text = $(this).find('input[name="search_text"]').val();

  		$.ajax({
			type: "GET",
			url: "/suggest/makemodel",
			data: {'query' : search_text},
			dataType: "json",
			success: function (data) {
				var edited = updateQueryStringParameter(document.URL, 'make', data.make);
				edited = updateQueryStringParameter(edited, 'model', data.model);
				edited = updateQueryStringParameter(edited, 'search_text', search_text);
  				edited = updateQueryStringParameter(edited, 'page', '1');
  				edited = updateQueryStringParameter(edited, 'price', '');
  				edited = updateQueryStringParameter(edited, 'mileage', '');
  				edited = updateQueryStringParameter(edited, 'year', '');
  				edited = updateQueryStringParameter(edited, 'transmission', '');
  				edited = updateQueryStringParameter(edited, 'photo', '');
  				edited = updateQueryStringParameter(edited, 'condition', '');
  				window.location.href = edited;
			}
		});

  		event.preventDefault();
	});

	$('#large-sort').change(function (event) {
	    var optionSelected = $("option:selected", this);
	    var valueSelected = this.value;
	    var edited = updateQueryStringParameter(document.URL, 'sort', valueSelected);
	    edited = updateQueryStringParameter(edited, 'page', '1');
  		window.location.href = edited;
  		event.preventDefault();
	});

	$('.mobile-sort-form').submit(function (event) {
	    var valueSelected = $("div#mobileSort input:radio:checked").val();
	    var edited = updateQueryStringParameter(document.URL, 'sort', valueSelected);
	    edited = updateQueryStringParameter(edited, 'page', '1');
  		window.location.href = edited;
  		event.preventDefault();
	});

	$('#change-search-location').submit(function (event) {
		var zip_code = $(this).find("input[name='zip_code']").val();
		var distance = $(this).find("select[name='distance']").val();
		var edited = updateQueryStringParameter(document.URL, 'zip_code', zip_code);
	    edited = updateQueryStringParameter(edited, 'distance', distance);
	    edited = updateQueryStringParameter(edited, 'page', '1');
	    window.location.href = edited;
  		event.preventDefault();
	});

	$('img')
		.error(function(){
        	$(this).attr('src', 'images/empty.png');
		})
		.each(function(){
  			$(this).attr("src", $(this).attr("src"))
  		});

	function updateQueryStringParameter(uri, key, value) {
	  	var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
		var separator = uri.indexOf('?') !== -1 ? "&" : "?";
		if (uri.match(re)) {
			return uri.replace(re, '$1' + key + "=" + value + '$2');
		}
		else {
		    return uri + separator + key + "=" + value;
		}
	}

	function getQueryStringParameter(name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
	    var results = regex.exec(location.search);

	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function removeItemFromList(list, value) {
	  	separator = "-";
	  	var values = list.split(separator);
	  	for(var i = 0 ; i < values.length ; i++) {
	    	if(values[i] == value) {
	      		values.splice(i, 1);
	      		return values.join(separator);
	    	}
	  	}

	  	return list;
	}

	function setupPager() {
		var total_results = $("#total_results").val();
		var page = getQueryStringParameter('page');

		$('#pagination').pagination({
	        items: total_results,
	        itemsOnPage: 10,
	        currentPage: page,
	        hrefTextPrefix: '#',
	        prevText: '&laquo;',
	        nextText:'&raquo;',
	        selectOnClick: false,
	        cssStyle: 'pagination',
	        onPageClick : function (pageNumber, event) {
		        var edited = updateQueryStringParameter(document.URL, 'page', pageNumber);
	  			window.location.href = edited;
	    	}
	    });
	}

	function selectSort() {
		var sort = getQueryStringParameter('sort');
		$('#large-sort').val(sort);
		
		var mobile_radios = $('input:radio[name=sort-options]');
	    if(mobile_radios !== undefined && mobile_radios.length > 0 && mobile_radios.is(':checked') === false) {
	        mobile_radios.filter('[value=' + sort + ']').prop('checked', true);
	    }
	}

	function selectFilters() {
		selectFilter($('div#makeModal'), 'make', '');
		selectFilter($('div#mobileMakeModal'), 'make', 'mobile-');
		selectFilter($('div#modelModal'), 'model', '');
		selectFilter($('div#mobileModelModal'), 'model', 'mobile-');
		selectFilter($('div#priceModal'), 'price', '');
		selectFilter($('div#mobilePriceModal'), 'price', 'mobile-');
		selectFilter($('div#mileageModal'), 'mileage', '');
		selectFilter($('div#mobileMileageModal'), 'mileage', 'mobile-');
		selectFilter($('div#yearModal'), 'year', '');
		selectFilter($('div#mobileYearModal'), 'year', 'mobile-');
		selectFilter($('div#transmissionModal'), 'transmission', '');
		selectFilter($('div#mobileTransmissionModal'), 'transmission', 'mobile-');
		selectFilter($('div#photoModal'), 'photo', '');
		selectFilter($('div#mobilePhotoModal'), 'photo', 'mobile-');
	}

	function selectFilter(div, property, prefix) {
		var value = getQueryStringParameter(property);
		if (value !== null && value !== undefined) {
			if (value.length > 0) {
				div.find('input:checkbox[id*="any"]').prop('checked', false);
				var values = value.split('-');
				$(values).each(function(index, value) {
					var id = '#' + prefix + property + '-' + value;
					var checkbox = div.find(id);
					if (checkbox !== null && checkbox !== undefined) {
				    	checkbox.prop('checked', true);
					}
				});
			} else {
				div.find('input:checkbox[id*="any"]').prop('checked', true);
			}
		} else {
			div.find('input:checkbox[id*="any"]').prop('checked', true);
		}
	}

	applyFilterFunctions('price', 'Price');
	applyFilterFunctions('mileage', 'Mileage');
	applyFilterFunctions('photo', 'Photo');
	applyFilterFunctions('transmission', 'Transmission');
	applyFilterFunctions('year', 'Year');
	applyFilterFunctions('make', 'Make');	
	applyFilterFunctions('model', 'Model');
	applyFilterFunctions('condition', 'Condition');

	function applyFilterFunctions(large, mobile) {
		$('div#' + large + 'Modal input:checkbox').change(function (event) {
			filterChanged($('div#' + large + 'Modal'), $(this));
		});

		$('#filter-by-' + large).submit(function (event) {
			filterSubmitted($('div#' + large + 'Modal'), large);
		});

		$('[id*="' + large + '-remove-"]').click(function (event) {
			filterRemoved(event.target.id.replace(large + '-remove-', ''), large);
		});

		$('div#mobile' + mobile + 'Modal input:checkbox').change(function (event) {
			filterChanged($('div#mobile' + mobile + 'Modal'), $(this));
		});

		$('#mobile-filter-by-' + large).submit(function (event) {
			filterSubmitted($('div#mobile' + mobile + 'Modal'), large);
		});

		$('[id*="mobile-' + large + '-remove-"]').click(function (event) {
			filterRemoved(event.target.id.replace('mobile-' + large + '-remove-', ''), large);
		});
	}

	function filterChanged(div, checkbox) {
		var selected = checkbox.val();
		if(checkbox.is(":checked")) {
			if (selected == 0) {
		    	div.find('input:checkbox').prop('checked', false);
		    	div.find('input:checkbox[id*="any"]').prop('checked', true);
		    } else {
		    	div.find('input:checkbox[id*="any"]').prop('checked', false);
		    }
		} else {
			if (selected == 0) {
		    	div.find('input:checkbox').prop('checked', false);
		    	div.find('input:checkbox[id*="any"]').prop('checked', true);
		    } else if (!div.find('input:checkbox').is(':checked')){
		    	$(div.find('input:checkbox[id*="any"]').prop('checked', true));
		    }
		}
	}

	function filterSubmitted(div, property) {
		var edited;
		if (div.find('input:checkbox[id*="any"]').is(':checked')) {
			var edited = updateQueryStringParameter(document.URL, property, '');
	    	edited = updateQueryStringParameter(edited, 'page', '1');
		} else {
			var checkedValues = div.find('input:checkbox:checked').map(function() {
			    return this.value;
			}).get();
			var edited = updateQueryStringParameter(document.URL, property, checkedValues.join('-'));
	    	edited = updateQueryStringParameter(edited, 'page', '1');
		}

  		window.location.href = edited;
  		event.preventDefault();
	}

	function filterRemoved(id, property) {
		var updated = removeItemFromList(getQueryStringParameter(property), id);
		var edited = updateQueryStringParameter(document.URL, property, updated);
	    edited = updateQueryStringParameter(edited, 'page', '1');
  		window.location.href = edited;
  		event.preventDefault();
	}

})(jQuery);