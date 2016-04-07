( function( $ ){
	var custom_background_container = $( '.custom-background-container' );
	$( custom_background_container ).css( 'height', $( window ).height() );
	//$( 'body' ).css( 'background', 'none' );

	if ( 750 >= $( window ).width() ) {
		$( custom_background_container ).css( 'height', $( window ).height() + 200 );
	}

	$( window ).resize( function(){
		if ( 750 < $( window ).width() ) {
			$( custom_background_container ).css( 'height', $( window ).height() );
		}
	} );

	$( document ).ready( function(){
		if ( $( '#wpadminbar' ).length ) {
			$( '#navbar' ).css( 'top', $( '#wpadminbar' ).height() );
		}
	} );
} )( jQuery );
