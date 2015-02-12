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

	$('div#priceModal input:checkbox').change(function (event) {
		filterChanged($('div#priceModal'), $(this));
	});

	$('#filter-by-price').submit(function (event) {
		filterSubmitted($('div#priceModal'), 'price');
	});

	$('[id*="price-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('price-remove-', ''), 'price');
	});

	$('div#mobilePriceModal input:checkbox').change(function (event) {
		filterChanged($('div#mobilePriceModal'), $(this));
	});

	$('#mobile-filter-by-price').submit(function (event) {
		filterSubmitted($('div#mobilePriceModal'), 'price');
	});

	$('[id*="mobile-price-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('mobile-price-remove-', ''), 'price');
	});

	$('div#mileageModal input:checkbox').change(function (event) {
		filterChanged($('div#mileageModal'), $(this));
	});

	$('#filter-by-mileage').submit(function (event) {
		filterSubmitted($('div#mileageModal'), 'mileage');
	});

	$('[id*="mileage-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('mileage-remove-', ''), 'mileage');
	});

	$('div#mobileMileageModal input:checkbox').change(function (event) {
		filterChanged($('div#mobileMileageModal'), $(this));
	});

	$('#mobile-filter-by-mileage').submit(function (event) {
		filterSubmitted($('div#mobileMileageModal'), 'mileage');
	});

	$('[id*="mobile-mileage-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('mobile-mileage-remove-', ''), 'mileage');
	});

	$('div#photoModal input:checkbox').change(function (event) {
		filterChanged($('div#photoModal'), $(this));
	});

	$('#filter-by-photo').submit(function (event) {
		filterSubmitted($('div#photoModal'), 'photo');
	});

	$('[id*="photo-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('photo-remove-', ''), 'photo');
	});

	$('div#mobilePhotoModal input:checkbox').change(function (event) {
		filterChanged($('div#mobilePhotoModal'), $(this));
	});

	$('#mobile-filter-by-photo').submit(function (event) {
		filterSubmitted($('div#mobilePhotoModal'), 'photo');
	});

	$('[id*="mobile-photo-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('mobile-photo-remove-', ''), 'photo');
	});

	$('div#transmissionModal input:checkbox').change(function (event) {
		filterChanged($('div#transmissionModal'), $(this));
	});

	$('#filter-by-transmission').submit(function (event) {
		filterSubmitted($('div#transmissionModal'), 'transmission');
	});

	$('[id*="transmission-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('transmission-remove-', ''), 'transmission');
	});

	$('div#mobileTransmissionModal input:checkbox').change(function (event) {
		filterChanged($('div#mobileTransmissionModal'), $(this));
	});

	$('#mobile-filter-by-transmission').submit(function (event) {
		filterSubmitted($('div#mobileTransmissionModal'), 'transmission');
	});

	$('[id*="mobile-transmission-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('mobile-transmission-remove-', ''), 'transmission');
	});

	$('div#yearModal input:checkbox').change(function (event) {
		filterChanged($('div#yearModal'), $(this));
	});

	$('#filter-by-year').submit(function (event) {
		filterSubmitted($('div#yearModal'), 'year');
	});

	$('[id*="year-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('year-remove-', ''), 'year');
	});

	$('div#mobileYearModal input:checkbox').change(function (event) {
		filterChanged($('div#mobileYearModal'), $(this));
	});

	$('#mobile-filter-by-year').submit(function (event) {
		filterSubmitted($('div#mobileYearModal'), 'year');
	});

	$('[id*="mobile-year-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('mobile-year-remove-', ''), 'year');
	});

	$('div#makeModal input:checkbox').change(function (event) {
		filterChanged($('div#makeModal'), $(this));
	});

	$('#filter-by-make').submit(function (event) {
		filterSubmitted($('div#makeModal'), 'make');
	});

	$('[id*="make-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('make-remove-', ''), 'make');
	});

	$('div#mobileMakeModal input:checkbox').change(function (event) {
		filterChanged($('div#mobileMakeModal'), $(this));
	});

	$('#mobile-filter-by-make').submit(function (event) {
		filterSubmitted($('div#mobileMakeModal'), 'make');
	});

	$('[id*="mobile-make-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('mobile-make-remove-', ''), 'make');
	});

	$('div#modelModal input:checkbox').change(function (event) {
		filterChanged($('div#modelModal'), $(this));
	});

	$('#filter-by-model').submit(function (event) {
		filterSubmitted($('div#modelModal'), 'model');
	});

	$('[id*="model-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('model-remove-', ''), 'model');
	});

	$('div#mobileModelModal input:checkbox').change(function (event) {
		filterChanged($('div#mobileModelModal'), $(this));
	});

	$('#mobile-filter-by-model').submit(function (event) {
		filterSubmitted($('div#mobileModelModal'), 'model');
	});

	$('[id*="mobile-model-remove-"]').click(function (event) {
		filterRemoved(event.target.id.replace('mobile-model-remove-', ''), 'model');
	});

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