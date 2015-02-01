(function ($) {

	setupPager();
	selectSort();

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

})(jQuery);