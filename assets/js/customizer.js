/**
 * Customizer JS
 *
 * Reloads changes on Theme Customizer Preview asynchronously for better usability
 *
 * @package Donovan Pro
 */

( function( $ ) {

	/* Header textfield. */
	wp.customize( 'donovan_theme_options[header_text]', function( value ) {
		value.bind( function( to ) {
			$( '.header-bar .header-content .header-text' ).text( to );
		} );
	} );

	/* Header Date checkbox */
	wp.customize( 'donovan_theme_options[header_date]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.header-bar .header-content .header-date' );
			} else {
				showElement( '.header-bar .header-content .header-date' );
			}
		} );
	} );

	/* Header Search checkbox */
	wp.customize( 'donovan_theme_options[header_search]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.primary-navigation-wrap .header-search' );
			} else {
				showElement( '.primary-navigation-wrap .header-search' );
			}
		} );
	} );

	/* Author Bio checkbox */
	wp.customize( 'donovan_theme_options[author_bio]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.type-post .post-content .entry-author' );
			} else {
				showElement( '.type-post .post-content .entry-author' );
			}
		} );
	} );

	/* Footer textfield. */
	wp.customize( 'donovan_theme_options[footer_text]', function( value ) {
		value.bind( function( to ) {
			$( '.site-info .footer-text' ).text( to );
		} );
	} );

	/* Link Color Option */
	wp.customize( 'donovan_theme_options[link_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--link-color', newval );
		} );
	} );

	/* Button Color Option */
	wp.customize( 'donovan_theme_options[button_color]', function( value ) {
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
	wp.customize( 'donovan_theme_options[button_hover_color]', function( value ) {
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
	wp.customize( 'donovan_theme_options[navi_color]', function( value ) {
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
	wp.customize( 'donovan_theme_options[navi_submenu_color]', function( value ) {
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
	wp.customize( 'donovan_theme_options[title_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--title-color', newval );
		} );
	} );

	/* Widget Title Color Option */
	wp.customize( 'donovan_theme_options[widget_title_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--widget-title-color', newval );
		} );
	} );

	/* Footer Color Option */
	wp.customize( 'donovan_theme_options[footer_color]', function( value ) {
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

	/* Text Font */
	wp.customize( 'donovan_theme_options[text_font]', function( value ) {
		value.bind( function( newval ) {

			// Load Font in Customizer.
			loadCustomFont( newval, 'text-font' );

			// Set Font.
			var systemFont = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
			var newFont = newval === 'SystemFontStack' ? systemFont : newval;

			// Set CSS.
			document.documentElement.style.setProperty( '--text-font', newFont );
		} );
	} );

	/* Title Font */
	wp.customize( 'donovan_theme_options[title_font]', function( value ) {
		value.bind( function( newval ) {

			// Load Font in Customizer.
			loadCustomFont( newval, 'title-font' );

			// Set Font.
			var systemFont = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
			var newFont = newval === 'SystemFontStack' ? systemFont : newval;

			// Set CSS.
			document.documentElement.style.setProperty( '--title-font', newFont );
		} );
	} );

	/* Title Font Weight */
	wp.customize( 'donovan_theme_options[title_is_bold]', function( value ) {
		value.bind( function( newval ) {
			var fontWeight = newval ? 'bold' : 'normal';
			document.documentElement.style.setProperty( '--title-font-weight', fontWeight );
		} );
	} );

	/* Title Text Transform */
	wp.customize( 'donovan_theme_options[title_is_uppercase]', function( value ) {
		value.bind( function( newval ) {
			var textTransform = newval ? 'uppercase' : 'none';
			document.documentElement.style.setProperty( '--title-text-transform', textTransform );
		} );
	} );

	/* Navi Font */
	wp.customize( 'donovan_theme_options[navi_font]', function( value ) {
		value.bind( function( newval ) {

			// Load Font in Customizer.
			loadCustomFont( newval, 'navi-font' );

			// Set Font.
			var systemFont = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
			var newFont = newval === 'SystemFontStack' ? systemFont : newval;

			// Set CSS.
			document.documentElement.style.setProperty( '--navi-font', newFont );
		} );
	} );

	/* Navi Font Weight */
	wp.customize( 'donovan_theme_options[navi_is_bold]', function( value ) {
		value.bind( function( newval ) {
			var fontWeight = newval ? 'bold' : 'normal';
			document.documentElement.style.setProperty( '--navi-font-weight', fontWeight );
		} );
	} );

	/* Navi Text Transform */
	wp.customize( 'donovan_theme_options[navi_is_uppercase]', function( value ) {
		value.bind( function( newval ) {
			var textTransform = newval ? 'uppercase' : 'none';
			document.documentElement.style.setProperty( '--navi-text-transform', textTransform );
		} );
	} );

	/* Widget Title Font */
	wp.customize( 'donovan_theme_options[widget_title_font]', function( value ) {
		value.bind( function( newval ) {

			// Load Font in Customizer.
			loadCustomFont( newval, 'widget-title-font' );

			// Set Font.
			var systemFont = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
			var newFont = newval === 'SystemFontStack' ? systemFont : newval;

			// Set CSS.
			document.documentElement.style.setProperty( '--widget-title-font', newFont );
		} );
	} );

	/* Widget Title Font Weight */
	wp.customize( 'donovan_theme_options[widget_title_is_bold]', function( value ) {
		value.bind( function( newval ) {
			var fontWeight = newval ? 'bold' : 'normal';
			document.documentElement.style.setProperty( '--widget-title-font-weight', fontWeight );
		} );
	} );

	/* Widget Title Text Transform */
	wp.customize( 'donovan_theme_options[widget_title_is_uppercase]', function( value ) {
		value.bind( function( newval ) {
			var textTransform = newval ? 'uppercase' : 'none';
			document.documentElement.style.setProperty( '--widget-title-text-transform', textTransform );
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

	function loadCustomFont( font, type ) {
		var fontFile = font.split( " " ).join( "+" );
		var fontFileURL = "https://fonts.googleapis.com/css?family=" + fontFile + ":400,700";

		var fontStylesheet = "<link id='donovan-pro-custom-" + type + "' href='" + fontFileURL + "' rel='stylesheet' type='text/css'>";
		var checkLink = $( "head" ).find( "#donovan-pro-custom-" + type ).length;

		if (checkLink > 0) {
			$( "head" ).find( "#donovan-pro-custom-" + type ).remove();
		}
		$( "head" ).append( fontStylesheet );
	}

} )( jQuery );
