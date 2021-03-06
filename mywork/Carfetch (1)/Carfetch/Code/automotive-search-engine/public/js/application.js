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
  				edited = updateAdsParameter(edited);
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

	$('ul.status-tabs li.tab-title').click(function (event) {
		var status = $(this).attr('id');
	    var edited = updateQueryStringParameter(document.URL, 'status', status);
	    edited = updateQueryStringParameter(edited, 'page', '1');
	    edited = updateAdsParameter(edited);
	    window.location.href = edited;
  		event.preventDefault();
	});

	$('[id*="save-vehicle-"]').click(function (event) {
		var vin = event.target.id.replace("save-vehicle-", "");
		
		$.ajax({
			type: "POST",
			url: "/user/save/car",
			data: {'vin' : vin}
		});
	});

	$('[id*="saved-vehicle-remove-"]').click(function (event) {
		var vin = event.target.id.replace("saved-vehicle-remove-", "");;
		
		$.ajax({
			type: "GET",
			url: "/user/remove/car",
			data: {'vin' : vin},
			dataType: "json",
			success: function (data) {
  				window.location.href = document.URL;
			}
		});
	});

	$('.save-search').click(function (event) {
		var title = $('#search_title').val();
		var filter = $('#search_filter').val();
		var location = $('#search_location').val();
		var query = window.location.search;
		
		$.ajax({
			type: "POST",
			url: "/user/save/search",
			data: {'title' : title, 'filter' : filter, 'location' : location, 'query' : query}
		});
	});

	$('[id*="saved-search-remove-"]').click(function (event) {
		var id = event.target.id.replace("saved-search-remove-", "");;
		
		$.ajax({
			type: "GET",
			url: "/user/remove/search",
			data: {'id' : id},
			dataType: "json",
			success: function (data) {
  				window.location.href = document.URL;
			}
		});
	});

	$('#advanced-search-submit').click(function (event) {
		var edited = location.protocol + '//' + location.hostname + '/search';
		edited = updateQueryStringParameter(edited, 'page', '1');
  		edited = updateQueryStringParameter(edited, 'sort', 'price-1');

  		var zip_code = $('#advanced-location').find("input[name='zip_code']").val();
		edited = updateQueryStringParameter(edited, 'zip_code', zip_code);

		var distance = $('#advanced-location').find("select[name='distance']").val();
		edited = updateQueryStringParameter(edited, 'distance', distance);

		var make = $('#advanced-make').val();
		if (make !== undefined) {
			edited = updateQueryStringParameter(edited, 'make', make);
		}

		var model = $('#advanced-model').val();
		if (model !== undefined) {
			edited = updateQueryStringParameter(edited, 'model', model);
		}

		var price_min = $('#advanced-price-min').val();
		var price_max = $('#advanced-price-max').val();
		if ((price_min == '' || $.isNumeric(price_min)) && (price_max == '' || $.isNumeric(price_max))) {
			edited = updateQueryStringParameter(edited, 'price-custom', price_min + '-' + price_max);
		}

		var mileage_min = $('#advanced-mileage-min').val();
		var mileage_max = $('#advanced-mileage-max').val();
		if ((mileage_min == '' || $.isNumeric(mileage_min)) && (mileage_max == '' || $.isNumeric(mileage_max))) {
			edited = updateQueryStringParameter(edited, 'mileage-custom', mileage_min + '-' + mileage_max);
		}

		var year_min = $('#advanced-year-min').val();
		var year_max = $('#advanced-year-max').val();
		if ((year_min == '' || $.isNumeric(year_min)) && (year_max == '' || $.isNumeric(year_max))) {
			edited = updateQueryStringParameter(edited, 'year-custom', year_min + '-' + year_max);
		}
  		
  		var statusValues = $('#advanced-status').find('input:checked').map(function() {
			return $(this).attr('class');
		}).get();
		edited = updateQueryStringParameter(edited, 'status', statusValues.join('-'));

		var bodyValues = $('#advanced-body').find('input:checked').map(function() {
			return $(this).attr('class');
		}).get();
		edited = updateQueryStringParameter(edited, 'body', bodyValues.join('-'));

		var interiorValues = $('#advanced-interior').find('input:checked').map(function() {
			return $(this).attr('class');
		}).get();
		edited = updateQueryStringParameter(edited, 'interior', interiorValues.join('-'));

		var exteriorValues = $('#advanced-exterior').find('input:checked').map(function() {
			return $(this).attr('class');
		}).get();
		edited = updateQueryStringParameter(edited, 'exterior', exteriorValues.join('-'));

		var fuelValues = $('#advanced-fuel').find('input:checked').map(function() {
			return $(this).attr('class');
		}).get();
		edited = updateQueryStringParameter(edited, 'fuel', fuelValues.join('-'));

		var transmissionValues = $('#advanced-transmission').find('input:checked').map(function() {
			return $(this).attr('class');
		}).get();
		edited = updateQueryStringParameter(edited, 'transmission', transmissionValues.join('-'));

		var driveValues = $('#advanced-drive').find('input:checked').map(function() {
			return $(this).attr('class');
		}).get();
		edited = updateQueryStringParameter(edited, 'drive', driveValues.join('-'));

		var doorsValues = $('#advanced-doors').find('input:checked').map(function() {
			return $(this).attr('class');
		}).get();
		edited = updateQueryStringParameter(edited, 'doors', doorsValues.join('-'));

		var cylindersValues = $('#advanced-cylinders').find('input:checked').map(function() {
			return $(this).attr('class');
		}).get();
		edited = updateQueryStringParameter(edited, 'cylinders', cylindersValues.join('-'));

		edited = updateAdsParameter(edited);

  		window.location.href = edited;
  		event.preventDefault();
	});

	$('#advanced-make').change(function (event) {
	    var make = this.value;
	    
	    $.ajax({
			type: "GET",
			url: "/suggest/model",
			data: {'make' : make},
			dataType: "json",
			success: function (data) {
				$('#advanced-model').find('option').remove().end().append($("<option></option>").attr("value", '').text('Any Model'));
				$.each(data, function(key, value) {   
				    $('#advanced-model').append($("<option></option>").attr("value", value.id).text(value.model)); 
				});
			}
		});
	});

	$('img')
		.error(function(){
        	$(this).attr('src', '/images/empty.png');
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
		if (sort == undefined || sort == '') {
			sort = 'date-1';
		}
		
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

		selectCustomFilter($('div#priceModal'), 'price');
		selectCustomFilter($('div#mobilePriceModal'), 'price');
		selectCustomFilter($('div#mileageModal'), 'mileage');
		selectCustomFilter($('div#mobileMileageModal'), 'mileage');
		selectCustomFilter($('div#yearModal'), 'year');
		selectCustomFilter($('div#mobileYearModal'), 'year');
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

	function selectCustomFilter(div, property) {
		var value = getQueryStringParameter(property + '-custom');
		if (value !== null && value !== undefined && value.length > 0) {
			var min = '';
			var max = '';

			var values = value.split('-');
			if (values.length > 0) {
				min = values[0];
			}

			if (values.length > 1) {
				max = values[1];
			}

			div.find('.' + property + 'Min').val(min);
			div.find('.' + property + 'Max').val(max);

			if (min != '' && max != '') {
				div.find('input:checkbox').prop('checked', false);
				div.find('input:checkbox[id*="any"]').prop('checked', true);
				div.find('li.tab-title').toggleClass('active');
				div.find('div.content').toggleClass('active');
			}
		}
	}

	applyCustomFilterFunctions('price', 'Price', 'checkbox');
	applyCustomFilterFunctions('mileage', 'Mileage', 'radio');
	applyCustomFilterFunctions('year', 'Year', 'checkbox');

	applyFilterFunctions('photo', 'Photo', 'checkbox');
	applyFilterFunctions('transmission', 'Transmission', 'checkbox');
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

	function applyCustomFilterFunctions(large, mobile, type) {
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
			var selectedTab = $('div#' + large + 'Modal div.active').attr('id');
			if (selectedTab.indexOf("basic") >= 0) {
				filterCustomSubmitted($('div#' + large + 'Modal'), large, false);
			} else if (selectedTab.indexOf("custom") >= 0) {
				filterCustomSubmitted($('div#' + large + 'Modal'), large, true);
			}	
		});

		$('#mobile-filter-by-' + large).submit(function (event) {
			var selectedTab = $('div#mobile' + mobile + 'Modal div.active').attr('id');
			if (selectedTab.indexOf("basic") >= 0) {
				filterCustomSubmitted($('div#mobile' + mobile + 'Modal'), large, false);
			} else if (selectedTab.indexOf("custom") >= 0) {
				filterCustomSubmitted($('div#mobile' + mobile + 'Modal'), large, true);
			}
		});

		$('[id*="' + large + '-remove-"]').click(function (event) {
			filterRemoved(event.target.id.replace(large + '-remove-', ''), large);
		});

		$('[id*="mobile-' + large + '-remove-"]').click(function (event) {
			filterRemoved(event.target.id.replace('mobile-' + large + '-remove-', ''), large);
		});

		$('[id*="' + large + '-custom-remove"]').click(function (event) {
			filterCustomRemoved(large + '-custom');
		});

		$('[id*="mobile-' + large + '-custom-remove"]').click(function (event) {
			filterCustomRemoved(large + '-custom');
		});
	}

	applyAdvancedFilterFunctions('status', 'radio');
	applyAdvancedFilterFunctions('body', 'checkbox');
	applyAdvancedFilterFunctions('interior', 'checkbox');
	applyAdvancedFilterFunctions('exterior', 'checkbox');
	applyAdvancedFilterFunctions('transmission', 'checkbox');
	applyAdvancedFilterFunctions('drive', 'checkbox');
	applyAdvancedFilterFunctions('doors', 'checkbox');
	applyAdvancedFilterFunctions('cylinders', 'checkbox');
	applyAdvancedFilterFunctions('fuel', 'checkbox');

	function applyAdvancedFilterFunctions(div, type) {
		if (type == 'checkbox') {
			$('div#advanced-' + div + ' input:checkbox').change(function (event) {
				filterCheckboxChanged($('div#advanced-' + div), $(this));
			});
		} else if (type == 'radio') {
			$('div#advanced-' + div + ' input:radio').change(function (event) {
				filterRadioChanged($('div#advanced-' + div), $(this));
			});
		}
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

		edited = updateAdsParameter(edited);

  		window.location.href = edited;
  		event.preventDefault();
	}

	function filterCustomSubmitted(div, property, custom) {
		var edited;

		if (custom == true) {
			var min = div.find('.' + property + 'Min').val();
			var max = div.find('.' + property + 'Max').val();

			edited = updateQueryStringParameter(document.URL, property, '');
			if ((min == '' || $.isNumeric(min)) && (max == '' || $.isNumeric(max))) {
				edited = updateQueryStringParameter(edited, property + '-custom', min + '-' + max);
			} else {
				edited = updateQueryStringParameter(edited, property + '-custom', '');
			}
  		} else {
  			edited = updateQueryStringParameter(document.URL, property + '-custom', '');
			if (div.find('input[id*="any"]').is(':checked')) {
				edited = updateQueryStringParameter(edited, property, '');
			} else {
				var checkedValues = div.find('input:checked').map(function() {
				    return this.value;
				}).get();
				edited = updateQueryStringParameter(edited, property, checkedValues.join('-'));
			}
  		}

  		edited = updateQueryStringParameter(edited, 'page', '1');
  		edited = updateAdsParameter(edited);

	  	window.location.href = edited;
	  	event.preventDefault();
	}

	function filterRemoved(id, property) {
		var updated = removeItemFromList(getQueryStringParameter(property), id);
		var edited = updateQueryStringParameter(document.URL, property, updated);
	    edited = updateQueryStringParameter(edited, 'page', '1');
	    edited = updateAdsParameter(edited);
  		window.location.href = edited;
  		event.preventDefault();
	}

	function filterCustomRemoved(property) {
		var edited = updateQueryStringParameter(document.URL, property, '');
	    edited = updateQueryStringParameter(edited, 'page', '1');
	    edited = updateAdsParameter(edited);
  		window.location.href = edited;
  		event.preventDefault();
	}

	function updateAdsParameter(query) {
		var edited = query;

		if (edited.split('?').length > 1) {
			var query_string = '?' + edited.split('?')[1];
			var make = getAdsParameter('make', query_string);
			var model = getAdsParameter('model', query_string);
			var body = getAdsParameter('body', query_string);
			var status = getAdsParameter('status', query_string);

			$.ajax({
				async: false,
				type: "GET",
				url: "/vehicle/ads",
				data: {'make':make, 'model':model, 'body':body, 'status':status},
				dataType: "json",
				success: function (data) {
					edited = updateQueryStringParameter(edited, 'ads', data.ads);
				}
			});		
		}

		return edited;
	}

	function getAdsParameter(name, query) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
	    var results = regex.exec(query);

	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

})(jQuery);