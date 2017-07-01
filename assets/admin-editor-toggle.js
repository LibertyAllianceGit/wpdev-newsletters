jQuery( document ).ready( function($) {

	/* Editor Toggle Function */
	function wpdevnews_Editor_Toggle(){
		if( 'templates/email-builder.php' == $( '#page_template' ).val() ){
			$( '#postdivrich' ).hide();
			$( '#wpdevnews-email-builder' ).show();
		}
		else{
			$( '#postdivrich' ).show();
			$( '#wpdevnews-email-builder' ).hide();
		}
	}

	/* Toggle On Page Load */
	wpdevnews_Editor_Toggle();

	/* If user change page template drop down */
	$( "#page_template" ).change( function(e) {
		wpdevnews_Editor_Toggle();
	});

});