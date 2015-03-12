(function ($) {

	setupDatePicker();	
	setupPager();
	selectSort();
	selectFilters();

	$('h1.logo').click(function() {
		var home = location.protocol + '//' + location.hostname;
		window.location.href = home;
  		event.preventDefault();
	});

	$('.vehicle-search').bind('typeahead:selected', function(obj, data) {
        var search_text = data.value;
  		startSearch(search_text);
    });

	$('.results-search-form').submit(function(event) {
  		var search_text = $(this).find('input[name="search_text"]').val();
  		startSearch(search_text);
  		event.preventDefault();
	});

	function startSearch(search_text) {
  		$.ajax({
			type: "GET",
			url: "/suggest/makemodel",
			data: {'query' : search_text},
			dataType: "json",
			success: function (data) {
				var edited = location.protocol + '//' + location.hostname + '/search';
				edited = updateQueryStringParameter(edited, 'make', data.make);
				edited = updateQueryStringParameter(edited, 'model', data.model);
				edited = updateQueryStringParameter(edited, 'zip_code', data.zip_code);
				edited = updateQueryStringParameter(edited, 'distance', data.distance);
				edited = updateQueryStringParameter(edited, 'search_text', search_text);
  				edited = updateQueryStringParameter(edited, 'page', '1');
  				edited = updateQueryStringParameter(edited, 'sort', 'price-1');
  				window.location.href = edited;
			}
		});
	}

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

	$('.distance_no_results').change(function (event) {
		var distance = $(this).val();
	    var edited = updateQueryStringParameter(document.URL, 'distance', distance);
	    edited = updateQueryStringParameter(edited, 'page', '1');
	    window.location.href = edited;
  		event.preventDefault();
	});

	$('.tab-title').click(function (event) {
		var status = $(this).attr('id');
	    var edited = updateQueryStringParameter(document.URL, 'status', status);
	    edited = updateQueryStringParameter(edited, 'page', '1');
	    window.location.href = edited;
  		event.preventDefault();
	});

	$('#advanced-search-submit').click(function (event) {
		var edited = location.protocol + '//' + location.hostname + '/search';
		edited = updateQueryStringParameter(edited, 'page', '1');
  		edited = updateQueryStringParameter(edited, 'sort', 'price-1');

  		var zip_code = $('#advanced-location').find("input[name='zip_code']").val();
		edited = updateQueryStringParameter(edited, 'zip_code', zip_code);

		var distance = $('#advanced-location').find("select[name='distance']").val();
		edited = updateQueryStringParameter(edited, 'distance', distance);
  		
  		var statusValues = $('#advanced-status').find('input:checked').map(function() {
			return $(this).attr('class');
		}).get();
		edited = updateQueryStringParameter(edited, 'status', statusValues.join('-'));

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

	function setupDatePicker() {
		var from = $('#datepicker-clicks-from')[0];
		var to = $('#datepicker-clicks-to')[0];

		$(from).val(getQueryStringParameter('from'));
		$(to).val(getQueryStringParameter('to'));

		var picker = new Pikaday({
	        field: from,
	        format: 'YYYY-MM-DD',
	        onSelect: function() {
	        	var edited = updateQueryStringParameter(document.URL, 'from', this.getMoment().format('YYYY-MM-DD'));
	    		edited = updateQueryStringParameter(edited, 'page', '1');
  				window.location.href = edited;
	        }
    	});

    	var picker = new Pikaday({
	        field: to,
	        format: 'YYYY-MM-DD',
	        onSelect: function() {
	        	var edited = updateQueryStringParameter(document.URL, 'to', this.getMoment().format('YYYY-MM-DD'));
	    		edited = updateQueryStringParameter(edited, 'page', '1');
  				window.location.href = edited;
	        }
    	});
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

	    $('#click-pagination').pagination({
	        items: total_results,
	        itemsOnPage: 100,
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
		selectCheckboxFilter($('div#makeModal'), 'make', '');
		selectCheckboxFilter($('div#mobileMakeModal'), 'make', 'mobile-');
		selectCheckboxFilter($('div#modelModal'), 'model', '');
		selectCheckboxFilter($('div#mobileModelModal'), 'model', 'mobile-');
		selectCheckboxFilter($('div#priceModal'), 'price', '');
		selectCheckboxFilter($('div#mobilePriceModal'), 'price', 'mobile-');
		selectCheckboxFilter($('div#yearModal'), 'year', '');
		selectCheckboxFilter($('div#mobileYearModal'), 'year', 'mobile-');
		selectCheckboxFilter($('div#transmissionModal'), 'transmission', '');
		selectCheckboxFilter($('div#mobileTransmissionModal'), 'transmission', 'mobile-');
		selectCheckboxFilter($('div#photoModal'), 'photo', '');
		selectCheckboxFilter($('div#mobilePhotoModal'), 'photo', 'mobile-');
		selectCheckboxFilter($('div#statusModal'), 'condition', '');
		selectCheckboxFilter($('div#mobileStatusModal'), 'condition', 'mobile-');
		selectCheckboxFilter($('div#bodyModal'), 'body', '');
		selectCheckboxFilter($('div#mobileBodyModal'), 'body', 'mobile-');
		selectCheckboxFilter($('div#certifiedModal'), 'certified', '');
		selectCheckboxFilter($('div#mobileCertifiedModal'), 'certified', 'mobile-');
		selectCheckboxFilter($('div#doorsModal'), 'doors', '');
		selectCheckboxFilter($('div#mobileDoorsModal'), 'doors', 'mobile-');
		selectCheckboxFilter($('div#cylindersModal'), 'cylinders', '');
		selectCheckboxFilter($('div#mobileCylindersModal'), 'cylinders', 'mobile-');
		selectCheckboxFilter($('div#interiorModal'), 'interior', '');
		selectCheckboxFilter($('div#mobileInteriorModal'), 'interior', 'mobile-');
		selectCheckboxFilter($('div#exteriorModal'), 'exterior', '');
		selectCheckboxFilter($('div#mobileExteriorModal'), 'exterior', 'mobile-');
		selectCheckboxFilter($('div#fuelModal'), 'fuel', '');
		selectCheckboxFilter($('div#mobileFuelModal'), 'fuel', 'mobile-');
		selectCheckboxFilter($('div#driveModal'), 'drive', '');
		selectCheckboxFilter($('div#mobileDriveModal'), 'drive', 'mobile-');

		selectRadioFilter($('div#mileageModal'), 'mileage', '');
		selectRadioFilter($('div#mobileMileageModal'), 'mileage', 'mobile-');
	}

	function selectCheckboxFilter(div, property, prefix) {
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

	function selectRadioFilter(div, property, prefix) {
		var value = getQueryStringParameter(property);
		if (value !== null && value !== undefined) {
			if (value.length > 0) {
				div.find('input:radio[id*="any"]').prop('checked', false);
				var id = '#' + prefix + property + '-' + value;
				var radio = div.find(id);
				if (radio !== null && radio !== undefined) {
				   	radio.prop('checked', true);
				}
			} else {
				div.find('input:radio[id*="any"]').prop('checked', true);
			}
		} else {
			div.find('input:radio[id*="any"]').prop('checked', true);
		}
	}

	applyFilterFunctions('price', 'Price', 'checkbox');
	applyFilterFunctions('photo', 'Photo', 'checkbox');
	applyFilterFunctions('transmission', 'Transmission', 'checkbox');
	applyFilterFunctions('year', 'Year', 'checkbox');
	applyFilterFunctions('make', 'Make', 'checkbox');	
	applyFilterFunctions('model', 'Model', 'checkbox');
	applyFilterFunctions('status', 'Status', 'checkbox');
	applyFilterFunctions('body', 'Body', 'checkbox');
	applyFilterFunctions('certified', 'Certified', 'checkbox');
	applyFilterFunctions('interior', 'Interior', 'checkbox');
	applyFilterFunctions('exterior', 'Exterior', 'checkbox');
	applyFilterFunctions('doors', 'Doors', 'checkbox');
	applyFilterFunctions('cylinders', 'Cylinders', 'checkbox');
	applyFilterFunctions('fuel', 'Fuel', 'checkbox');
	applyFilterFunctions('drive', 'Drive', 'checkbox');

	applyFilterFunctions('mileage', 'Mileage', 'radio');

	function applyFilterFunctions(large, mobile, type) {
		if (type == 'checkbox') {
			$('div#mobile' + mobile + 'Modal input:checkbox').change(function (event) {
				filterCheckboxChanged($('div#mobile' + mobile + 'Modal'), $(this));
			});

			$('div#' + large + 'Modal input:checkbox').change(function (event) {
				filterCheckboxChanged($('div#' + large + 'Modal'), $(this));
			});
		} else if (type == 'radio') {
			$('div#mobile' + mobile + 'Modal input:radio').click(function (event) {
				filterRadioChanged($('div#mobile' + mobile + 'Modal'), $(this));
			});

			$('div#' + large + 'Modal input:radio').click(function (event) {
				filterRadioChanged($('div#' + large + 'Modal'), $(this));
			});
		}

		$('#filter-by-' + large).submit(function (event) {
			filterSubmitted($('div#' + large + 'Modal'), large);
		});

		$('[id*="' + large + '-remove-"]').click(function (event) {
			filterRemoved(event.target.id.replace(large + '-remove-', ''), large);
		});

		$('#mobile-filter-by-' + large).submit(function (event) {
			filterSubmitted($('div#mobile' + mobile + 'Modal'), large);
		});

		$('[id*="mobile-' + large + '-remove-"]').click(function (event) {
			filterRemoved(event.target.id.replace('mobile-' + large + '-remove-', ''), large);
		});
	}

	function filterCheckboxChanged(div, checkbox) {
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

	function filterRadioChanged(div, radio) {
		var selected = radio.val();
		div.find('input:radio').prop('checked', false);
		radio.prop('checked', true);
	}

	function filterSubmitted(div, property) {
		var edited;
		if (div.find('input[id*="any"]').is(':checked')) {
			var edited = updateQueryStringParameter(document.URL, property, '');
	    	edited = updateQueryStringParameter(edited, 'page', '1');
		} else {
			var checkedValues = div.find('input:checked').map(function() {
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