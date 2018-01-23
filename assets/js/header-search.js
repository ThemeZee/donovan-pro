/**
 * Header Search JS
 *
 * @package Donnager Pro
 */

( function( $ ) {

	$( document ).ready( function() {

		/* Display Search Form when search icon is clicked */
		$( '#main-navigation-wrap .header-search a.header-search-icon' ).on( 'click', function() {
			$( '#main-navigation-wrap .header-search .header-search-form-wrap' ).toggle().find( '.search-form .search-field' ).focus();
			$( this ).toggleClass( 'active' );
		});

		/* Do not close search form if click is inside header search element */
		$( '#main-navigation-wrap .header-search' ).click( function(e) {
			e.stopPropagation();
		});

		/* Close search form if click is outside header search element */
		$( document ).click( function() {
			$( '#main-navigation-wrap .header-search .header-search-form-wrap' ).hide();
			$( '#main-navigation-wrap .header-search a.header-search-icon' ).removeClass( 'active' );
		});

		/* Close search form if click on close icon */
		$( '#main-navigation-wrap .header-search .header-search-form .header-search-close' ).on( 'click', function() {
			$( '#main-navigation-wrap .header-search .header-search-form-wrap' ).hide();
			$( '#main-navigation-wrap .header-search a.header-search-icon' ).removeClass( 'active' );
		});
	} );

} )( jQuery );
