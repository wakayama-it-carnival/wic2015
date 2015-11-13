( function( $ ){
	var custom_background_container = $( '<div>' );
	$( custom_background_container ).addClass( 'custom-background-container' );
	$( 'body' ).append( $( custom_background_container ) );
	$( custom_background_container ).css( 'background', $( 'body' ).css( 'background' ) );
	$( custom_background_container ).css( 'height', $( window ).height() + 100 );
	$( 'body' ).css( 'background', 'none' );

	$( document ).ready( function(){
		if ( $( '#wpadminbar' ).length ) {
			console.log( $( '#wpadminbar' ).height() );
			$( '#navbar' ).css( 'top', $( '#wpadminbar' ).height() );
		}
	} );
} )( jQuery );
