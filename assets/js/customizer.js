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
				hideElement( '.type-post .entry-footer .entry-author' );
			} else {
				showElement( '.type-post .entry-footer .entry-author' );
			}
		} );
	} );

	/* Footer Content checkbox */
	wp.customize( 'donnager_theme_options[footer_content]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.site > .footer-content' );
			} else {
				showElement( '.site > .footer-content' );
			}
		} );
	} );

	/* Footer textfield. */
	wp.customize( 'donnager_theme_options[footer_text]', function( value ) {
		value.bind( function( to ) {
			$( '.site-info .footer-text' ).text( to );
		} );
	} );

	/* Link & Button Color Option */
	wp.customize( 'donnager_theme_options[link_color]', function( value ) {
		value.bind( function( newval ) {
			var custom_css, text_color;

			custom_css = 'a:link, a:visited, .infinite-scroll #infinite-handle span, .top-navigation-toggle:hover, .top-navigation-toggle:active, .top-navigation-menu a:hover, .top-navigation-menu a:active, .footer-navigation-menu a:hover, .footer-navigation-menu a:active { color: ' + newval + '; }';
			custom_css += 'a:hover, a:focus, a:active, .infinite-scroll #infinite-handle span:hover { color: #353535; }';
			custom_css += '.top-navigation-toggle:hover .icon, .top-navigation-toggle:active .icon, .top-navigation-menu > .menu-item-has-children a .sub-menu-icon:hover .icon, .top-navigation-menu > .menu-item-has-children a .sub-menu-icon:active .icon { fill: ' + newval + '; }';
			custom_css += 'button, input[type="button"], input[type="reset"], input[type="submit"], .search-form .search-submit, .tzwb-tabbed-content .tzwb-tabnavi li a:hover, .tzwb-tabbed-content .tzwb-tabnavi li a:active, .tzwb-tabbed-content .tzwb-tabnavi li a.current-tab, .tzwb-social-icons .social-icons-menu li a, .scroll-to-top-button, .scroll-to-top-button:focus, .scroll-to-top-button:active { background: ' + newval + '; }';
			custom_css += '@media only screen and (min-width: 55em) { .top-navigation-menu > .menu-item-has-children a:hover .sub-menu-icon .icon { fill: ' + newval + '; } }';

			if( isColorLight( newval ) ) {
				text_color = '#222222';
			} else {
				text_color = '#ffffff';
			}

			custom_css += 'button, input[type="button"], input[type="reset"], input[type="submit"], .tzwb-tabbed-content .tzwb-tabnavi li a:hover, .tzwb-tabbed-content .tzwb-tabnavi li a:active, .tzwb-tabbed-content .tzwb-tabnavi li a.current-tab { color: ' + text_color + '; }';
			custom_css += '.search-form .search-submit .icon-search, .scroll-to-top-button .icon, .tzwb-social-icons .social-icons-menu li a .icon { fill: ' + text_color + '; }';

			custom_css += 'button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, button:focus, input[type="button"]:focus, input[type="reset"]:focus, input[type="submit"]:focus, button:active, input[type="button"]:active, input[type="reset"]:active, input[type="submit"]:active { color: #ffffff; }';
			custom_css += '.search-form .search-submit:hover .icon-search, .scroll-to-top-button:hover .icon, .tzwb-social-icons .social-icons-menu li a:hover .icon { fill: #ffffff; }';

			addColorStyles( custom_css, 1 );

			custom_css = '.widget-title a:hover, .widget-title a:active { color: ' + newval + '; }';

			addColorStyles( custom_css, 7 );
		} );
	} );

	/* Navigation Primary Color Option */
	wp.customize( 'donnager_theme_options[navi_color]', function( value ) {
		value.bind( function( newval ) {
			var custom_css;

			custom_css = '.main-navigation-toggle, .main-navigation-toggle:focus, .main-navigation-menu, .main-navigation-menu a:link, .main-navigation-menu a:visited { color: ' + newval + '; }';
			custom_css += '.primary-navigation-wrap, .main-navigation-menu, .main-navigation-menu ul, .main-navigation-menu ul a, .footer-content { border-color: ' + newval + '; }';
			custom_css += '.main-navigation-toggle .icon, .main-navigation-menu > .menu-item-has-children a .sub-menu-icon .icon, .header-search .header-search-icon .icon-search, .header-search .header-search-form-wrap .header-search-form .header-search-close .icon-close { fill: ' + newval + '; }';

			custom_css += '.main-navigation-toggle:hover, .main-navigation-toggle:active, .main-navigation-menu a:hover, .main-navigation-menu a:active { color: #3377bb; }';
			custom_css += '.main-navigation-toggle:hover .icon, .main-navigation-toggle:active .icon, .main-navigation-menu > .menu-item-has-children a .sub-menu-icon:hover .icon, .main-navigation-menu > .menu-item-has-children a .sub-menu-icon:active .icon { fill: #3377bb; }';

			addColorStyles( custom_css, 2 );
		} );
	} );

	/* Navigation Secondary Color Option */
	wp.customize( 'donnager_theme_options[navi_hover_color]', function( value ) {
		value.bind( function( newval ) {
			var custom_css;

			custom_css = '.main-navigation-toggle:hover, .main-navigation-toggle:active, .main-navigation-menu a:hover, .main-navigation-menu a:active { color: ' + newval + '; }';
			custom_css += '.main-navigation-toggle:hover .icon, .main-navigation-toggle:active .icon, .main-navigation-menu > .menu-item-has-children a .sub-menu-icon:hover .icon, .main-navigation-menu > .menu-item-has-children a .sub-menu-icon:active .icon, .header-search .header-search-icon:hover .icon-search, .header-search .header-search-icon:active .icon-search, .header-search .header-search-form-wrap .header-search-form .header-search-close:hover .icon-close, .header-search .header-search-form-wrap .header-search-form .header-search-close:active .icon-close { fill: ' + newval + '; }';
			custom_css += '@media only screen and (min-width: 55em) { .main-navigation-menu > .menu-item-has-children a:hover .sub-menu-icon .icon { fill: ' + newval + '; } }';

			addColorStyles( custom_css, 3 );
		} );
	} );

	/* Title Color Option */
	wp.customize( 'donnager_theme_options[title_color]', function( value ) {
		value.bind( function( newval ) {
			var custom_css;

			custom_css = '.site-title, .site-title a:link, .site-title a:visited, .entry-title, .entry-title a:link, .entry-title a:visited { color: ' + newval + '; }';
			custom_css += '.site-title a:hover, .site-title a:active, .entry-title a:hover, .entry-title a:active { color: #3377bb; }';
			custom_css += '.donnager-social-menu .social-icons-menu li a .icon { fill: ' + newval + '; }';

			addColorStyles( custom_css, 4 );
		} );
	} );

	/* Title Hover Color Option */
	wp.customize( 'donnager_theme_options[title_hover_color]', function( value ) {
		value.bind( function( newval ) {
			var custom_css;

			custom_css = '.site-title a:hover, .site-title a:active, .entry-title a:hover, .entry-title a:active { color: ' + newval + '; }';
			custom_css += '.donnager-social-menu .social-icons-menu li a:hover .icon { fill: ' + newval + '; }';

			addColorStyles( custom_css, 5 );
		} );
	} );

	/* Widget Title Color Option */
	wp.customize( 'donnager_theme_options[widget_title_color]', function( value ) {
		value.bind( function( newval ) {
			var custom_css;

			custom_css = '.widget-title, .widget-title a:link, .widget-title a:visited, .archive-title, .comments-title, .comment-reply-title, .entry-author .author-heading .author-title { color: ' + newval + '; }';
			custom_css += '.widget-title a:hover, .widget-title a:active { color: #3377bb; }';

			addColorStyles( custom_css, 6 );
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
			$( 'body, button, input, select, textarea' )
				.css( 'font-family', newval );

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
			$( '.site-title, .entry-title' )
				.css( 'font-family', newval );

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
			$( '.main-navigation-menu, .main-navigation-toggle' )
				.css( 'font-family', newval );

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
			$( '.widget-title, .archive-title, .comments-title, .comment-reply-title, .entry-author .author-heading .author-title' )
				.css( 'font-family', newval );

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

	function writeColorStyles() {
		for( var i = 1; i < 8; i++) {
			$( 'head' ).append( '<style id="donnager-pro-colors-' + i + '"></style>' );
		}
	}

	function addColorStyles( colorRules, priority ) {

		// Write Color Styles if they do not exist.
		if ( ! $( '#donnager-pro-colors-1' ).length ) {
			writeColorStyles();
		}

		$( '#donnager-pro-colors-' + priority ).html( colorRules );
	}

} )( jQuery );
