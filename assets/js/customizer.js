/**
 * Customizer JS
 *
 * Reloads changes on Theme Customizer Preview asynchronously for better usability
 *
 * @package Donnager Pro
 */

( function( $ ) {

	/* Header textfield. */
	wp.customize( 'donnager_theme_options[header_text]', function( value ) {
		value.bind( function( to ) {
			$( '.header-bar .header-content .header-text' ).text( to );
		} );
	} );

	/* Header Date checkbox */
	wp.customize( 'donnager_theme_options[header_date]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.header-bar .header-content .header-date' );
			} else {
				showElement( '.header-bar .header-content .header-date' );
			}
		} );
	} );

	/* Header Search checkbox */
	wp.customize( 'donnager_theme_options[header_search]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.primary-navigation-wrap .header-search' );
			} else {
				showElement( '.primary-navigation-wrap .header-search' );
			}
		} );
	} );

	/* Author Bio checkbox */
	wp.customize( 'donnager_theme_options[author_bio]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.type-post .post-content .entry-author' );
			} else {
				showElement( '.type-post .post-content .entry-author' );
			}
		} );
	} );

	/* Footer textfield. */
	wp.customize( 'donnager_theme_options[footer_text]', function( value ) {
		value.bind( function( to ) {
			$( '.site-info .footer-text' ).text( to );
		} );
	} );

	/* Link Color Option */
	wp.customize( 'donnager_theme_options[link_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--link-color', newval );
		} );
	} );

	/* Button Color Option */
	wp.customize( 'donnager_theme_options[button_color]', function( value ) {
		value.bind( function( newval ) {
			var text_color;

			if( isColorLight( newval ) ) {
				text_color = '#202020';
			} else {
				text_color = '#ffffff';
			}

			document.documentElement.style.setProperty( '--button-text-color', text_color );
			document.documentElement.style.setProperty( '--button-color', newval );
		} );
	} );

	/* Button Hover Color Option */
	wp.customize( 'donnager_theme_options[button_hover_color]', function( value ) {
		value.bind( function( newval ) {
			var text_color;

			if( isColorLight( newval ) ) {
				text_color = '#202020';
			} else {
				text_color = '#ffffff';
			}

			document.documentElement.style.setProperty( '--button-hover-color', newval );
			document.documentElement.style.setProperty( '--button-hover-text-color', text_color );
		} );
	} );

	/* Navi Color Option */
	wp.customize( 'donnager_theme_options[navi_color]', function( value ) {
		value.bind( function( newval ) {
			var text_color, text_hover_color, border_color;

			if( isColorLight( newval ) ) {
				text_color = '#202020';
				text_hover_color = 'rgba(0, 0, 0, 0.5)';
				border_color = 'rgba(0, 0, 0, 0.075)';
			} else {
				text_color = '#ffffff';
				text_hover_color = 'rgba(255, 255, 255, 0.5)';
				border_color = 'rgba(255, 255, 255, 0.05)';
			}

			document.documentElement.style.setProperty( '--navi-color', newval );
			document.documentElement.style.setProperty( '--navi-text-color', text_color );
			document.documentElement.style.setProperty( '--navi-hover-text-color', text_hover_color );
			document.documentElement.style.setProperty( '--navi-border-color', border_color );
		} );
	} );

	/* Submenu Color Option */
	wp.customize( 'donnager_theme_options[navi_submenu_color]', function( value ) {
		value.bind( function( newval ) {
			var text_color, text_hover_color, border_color;

			if( isColorLight( newval ) ) {
				text_color = '#202020';
				text_hover_color = 'rgba(0, 0, 0, 0.5)';
				border_color = 'rgba(0, 0, 0, 0.1)';
			} else {
				text_color = '#ffffff';
				text_hover_color = 'rgba(255, 255, 255, 0.5)';
				border_color = 'rgba(255, 255, 255, 0.075)';
			}

			document.documentElement.style.setProperty( '--submenu-color', newval );
			document.documentElement.style.setProperty( '--submenu-text-color', text_color );
			document.documentElement.style.setProperty( '--submenu-hover-text-color', text_hover_color );
			document.documentElement.style.setProperty( '--submenu-border-color', border_color );
		} );
	} );

	/* Title Color Option */
	wp.customize( 'donnager_theme_options[title_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--title-color', newval );
		} );
	} );

	/* Footer Color Option */
	wp.customize( 'donnager_theme_options[footer_color]', function( value ) {
		value.bind( function( newval ) {
			var text_color, text_hover_color, border_color;

			if( isColorLight( newval ) ) {
				text_color = '#202020';
				text_hover_color = 'rgba(0, 0, 0, 0.5)';
				border_color = 'rgba(0, 0, 0, 0.05)';
			} else {
				text_color = '#ffffff';
				text_hover_color = 'rgba(255, 255, 255, 0.5)';
				border_color = 'rgba(255, 255, 255, 0.035)';
			}

			document.documentElement.style.setProperty( '--footer-color', newval );
			document.documentElement.style.setProperty( '--footer-text-color', text_color );
			document.documentElement.style.setProperty( '--footer-hover-text-color', text_hover_color );
			document.documentElement.style.setProperty( '--footer-border-color', border_color );
		} );
	} );

	/* Theme Fonts */
	wp.customize( 'donnager_theme_options[text_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='donnager-pro-custom-text-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#donnager-pro-custom-text-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#donnager-pro-custom-text-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			document.documentElement.style.setProperty( '--text-font', newval );
		} );
	} );

	wp.customize( 'donnager_theme_options[title_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='donnager-pro-custom-title-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#donnager-pro-custom-title-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#donnager-pro-custom-title-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			document.documentElement.style.setProperty( '--title-font', newval );
		} );
	} );

	wp.customize( 'donnager_theme_options[navi_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='donnager-pro-custom-navi-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#donnager-pro-custom-navi-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#donnager-pro-custom-navi-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			document.documentElement.style.setProperty( '--navi-font', newval );
		} );
	} );

	wp.customize( 'donnager_theme_options[widget_title_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='donnager-pro-custom-widget-title-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#donnager-pro-custom-widget-title-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#donnager-pro-custom-widget-title-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			document.documentElement.style.setProperty( '--widget-title-font', newval );
		} );
	} );

	function hideElement( element ) {
		$( element ).css({
			clip: 'rect(1px, 1px, 1px, 1px)',
			position: 'absolute',
			width: '1px',
			height: '1px',
			overflow: 'hidden'
		});
	}

	function showElement( element ) {
		$( element ).css({
			clip: 'auto',
			position: 'relative',
			width: 'auto',
			height: 'auto',
			overflow: 'visible'
		});
	}

	function hexdec( hexString ) {
		hexString = ( hexString + '' ).replace( /[^a-f0-9]/gi, '' );
		return parseInt( hexString, 16 );
	}

	function getColorBrightness( hexColor ) {

		// Remove # string.
		hexColor = hexColor.replace( '#', '' );

		// Convert into RGB.
		var r = hexdec( hexColor.substring( 0, 2 ) );
		var g = hexdec( hexColor.substring( 2, 4 ) );
		var b = hexdec( hexColor.substring( 4, 6 ) );

		return ( ( ( r * 299 ) + ( g * 587 ) + ( b * 114 ) ) / 1000 );
	}

	function isColorLight( hexColor ) {
		return ( getColorBrightness( hexColor ) > 130 );
	}

	function isColorDark( hexColor ) {
		return ( getColorBrightness( hexColor ) <= 130 );
	}

} )( jQuery );
