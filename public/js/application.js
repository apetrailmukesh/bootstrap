(function ($) {

	setupPager();
	selectSort();
	selectFilters();

	$('.results-search-form').submit(function(event) {
  		var search_text = $(this).find('input[name="search_text"]').val();
  		var edited = updateQueryStringParameter(document.URL, 'search_text', search_text);
  		edited = updateQueryStringParameter(edited, 'page', '1');
  		window.location.href = edited;
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

	$('img').error(function(){
        $(this).attr('src', 'images/empty.png');
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
	    if(mobile_radios.is(':checked') === false) {
	        mobile_radios.filter('[value=' + sort + ']').prop('checked', true);
	    }
	}

	function selectFilters() {
		selectFilter($('div#priceModal'), 'price', '');
		selectFilter($('div#mobilePriceModal'), 'price', 'mobile-');
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