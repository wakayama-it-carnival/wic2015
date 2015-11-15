( function( $ ){
	var custom_background_container = $( '<div>' );
	$( custom_background_container ).addClass( 'custom-background-container' );
	$( 'body' ).append( $( custom_background_container ) );
	$( custom_background_container ).css( 'background', $( 'body' ).css( 'background' ) );
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
