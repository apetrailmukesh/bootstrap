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

	$('div#priceModal input:checkbox').change(function (event) {
		var selected = $(this).val();
		if($(this).is(":checked")) {
			if (selected == 0) {
		    	$('div#priceModal input:checkbox').prop('checked', false);
		    	$('div#priceModal input:checkbox#any').prop('checked', true);
		    } else {
		    	$('div#priceModal input:checkbox#any').prop('checked', false);
		    }
		} else {
			if (selected == 0) {
		    	$('div#priceModal input:checkbox').prop('checked', false);
		    	$('div#priceModal input:checkbox#any').prop('checked', true);
		    } else if (!$('div#priceModal input:checkbox').is(':checked')){
		    	$('div#priceModal input:checkbox#any').prop('checked', true);
		    }
		}
	});

	$('#filter-by-price').submit(function (event) {
		var edited;
		if ($('div#priceModal input:checkbox#any').is(':checked')) {
			var edited = updateQueryStringParameter(document.URL, 'price', '');
	    	edited = updateQueryStringParameter(edited, 'page', '1');
		} else {
			var checkedValues = $('div#priceModal input:checkbox:checked').map(function() {
			    return this.value;
			}).get();
			var edited = updateQueryStringParameter(document.URL, 'price', checkedValues.join('-'));
	    	edited = updateQueryStringParameter(edited, 'page', '1');
		}

  		window.location.href = edited;
  		event.preventDefault();
	});

	$('[id*="price-remove-"]').click(function (event) {
		var price_range = event.target.id.replace("price-remove-", ""); ;
		var updated = removeItemFromList(getQueryStringParameter('price'), price_range);
		var edited = updateQueryStringParameter(document.URL, 'price', updated);
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
	        selectOnClick: false,
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
		var price = getQueryStringParameter('price');
		if (price !== null && price !== undefined) {
			if (price.length > 0) {
				$('div#priceModal input:checkbox#any').prop('checked', false);
				var prices = price.split('-');
				$(prices).each(function(index, value) {
					var checkbox = $('div#priceModal #price-' + value);
					if (checkbox !== null && checkbox !== undefined) {
				    	checkbox.prop('checked', true);
					}
				});
			} else {
				$('div#priceModal input:checkbox#any').prop('checked', true);
			}
		} else {
			$('div#priceModal input:checkbox#any').prop('checked', true);
		}
	}

})(jQuery);