jQuery(document).ready(function(){

	// Ajax call function on form submit event
	jQuery( "#lbs_book_search_box" ).submit(function( e ) {
		jQuery(".book_loader").fadeIn();
		e.preventDefault();
		var lbs_find_book_name = jQuery("#lbs_find_book_name").val();
		var lbs_find_auther = jQuery("#lbs_find_auther").val();
		var lbs_find_publisher = jQuery("#lbs_find_publisher").val();
		var lbs_find_star_rating = jQuery("#lbs_find_star_rating").val();
		var price_min = jQuery("#price_min").val();
		var price_max = jQuery("#price_max").val();
		var lbs_offset = jQuery("#lbs_offset").val();
		jQuery.ajax({
		    type: "POST",
		    url: script_data.ajax_url,
		    data: ({
		        action: 'lbs_find_book_from_library',
		        lbs_find_book_name: lbs_find_book_name,
				lbs_find_auther: lbs_find_auther,
				lbs_find_publisher: lbs_find_publisher,
				lbs_find_star_rating: lbs_find_star_rating,
				price_min: price_min,
				price_max: price_max,
				lbs_offset: lbs_offset
		    }),
		    success: function (response) {
		    	jQuery("#lbs_book_listing").html(response);
		    	jQuery(".book_loader").fadeOut();
		    }
		});
	});

	// Range slider
	jQuery( function() {
		jQuery( "#slider-range" ).slider({
		  range: true,
		  min: 0,
		  max: 3000,
		  values: [ 0, 3000 ],
		  slide: function( event, ui ) {
		    jQuery( "#price_min" ).val( ui.values[ 0 ] );
		    jQuery( "#price_max" ).val( ui.values[ 1 ] );
		    reset_page_offset();
		  }
		});
		jQuery( "#price_min" ).val( jQuery( "#slider-range" ).slider( "values", 0 ) );
		jQuery( "#price_max" ).val( jQuery( "#slider-range" ).slider( "values", 1 ) );
	} );

});

// Pagination trigger event function
function lbs_pagination(offset_page){
	var offset_val = ((offset_page-1)*(script_data.perpagebook));
	jQuery("#lbs_offset").val(offset_val);
	jQuery( "#lbs_book_search_box" ).submit();
}

// Reset pagination on search form values are changed
function reset_page_offset(){
	jQuery("#lbs_offset").val("");
}