jQuery( document ).ready( function( $ ){

	/* Function: Update Order */
	function wpdevnews_UpdateOrder(){

		/* In each of rows */
		$('.wpdevnews-rows > .wpdevnews-row').each( function(i){

			/* Increase num by 1 to avoid "0" as first index. */
			var num = i + 1;

			/* Update order number in row title */
			$( this ).find( '.wpdevnews-order' ).text( num );

			/* In each input in the row */
			$( this ).find( '.wpdevnews-row-input' ).each( function(i) {

				/* Get field id for this input */
				var field = $( this ).attr( 'data-field' );

				/* Update name attribute with order and field name.  */
				$( this ).attr( 'name', 'wpdevnews[' + num + '][' + field + ']');
			});
		});
	}

	/* Update Order on Page load */
	wpdevnews_UpdateOrder();

	/* Make Row Sortable */
	$( '.wpdevnews-rows' ).sortable({
		handle: '.wpdevnews-handle',
		cursor: 'grabbing',
		stop: function( e, ui ) {
			wpdevnews_UpdateOrder();
		},
	});

	/* Add Row */
	$( 'body' ).on( 'click', '.wpdevnews-add-row', function(e){
		e.preventDefault();
 
		 /* Target the template. */
		var template = '.wpdevnews-templates > .wpdevnews-' + $( this ).attr( 'data-template' );

		/* Clone the template and add it. */
		$( template ).clone().appendTo( '.wpdevnews-rows' );

		/* Hide Empty Row Message */
		$( '.wpdevnews-rows-message' ).hide();

		/* Update Order */
		wpdevnews_UpdateOrder();
	});

	/* Hide/Show Empty Row Message On Page Load */
	if( $( '.wpdevnews-rows > .wpdevnews-row' ).length ){
		$( '.wpdevnews-rows-message' ).hide();
	}
	else{
		$( '.wpdevnews-rows-message' ).show();
	}

	/* Delete Row */
	$( 'body' ).on( 'click', '.wpdevnews-remove', function(e){
		e.preventDefault();

		/* Delete Row */
		$( this ).parents( '.wpdevnews-row' ).remove();
		
		/* Show Empty Message When Applicable. */
		if( ! $( '.wpdevnews-rows > .wpdevnews-row' ).length ){
			$( '.wpdevnews-rows-message' ).show();
		}

		/* Update Order */
		wpdevnews_UpdateOrder();
	});
    
    /* Use Buttons */
    $('button.wpdevnews-button-post').on('click', function() {
       $(this).prev('textarea.wpdevnews-row-input').text('[cheese]');
    });

});
