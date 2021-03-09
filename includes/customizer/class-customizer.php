<?php
/**
 * Customizer
 *
 * Setup the Customizer and theme options for the Pro plugin
 *
 * @package Donovan Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customizer Class
 */
class Donovan_Pro_Customizer {

	/**
	 * Customizer Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Donovan Theme is not active.
		if ( ! current_theme_supports( 'donovan-pro' ) ) {
			return;
		}

		// Enqueue scripts and styles in the Customizer.
		add_action( 'customize_preview_init', array( __CLASS__, 'customize_preview_js' ) );
		add_action( 'customize_controls_print_styles', array( __CLASS__, 'customize_preview_css' ) );

		// Remove Upgrade section.
		remove_action( 'customize_register', 'donovan_customize_register_upgrade_settings' );
	}

	/**
	 * Get saved user settings from database or plugin defaults
	 *
	 * @return array
	 */
	static function get_theme_options() {

		// Merge Theme Options Array from Database with Default Options Array.
		return wp_parse_args( get_option( 'donovan_theme_options', array() ), self::get_default_options() );
	}


	/**
	 * Returns the default settings of the plugin
	 *
	 * @return array
	 */
	static function get_default_options() {

		$default_options = array(
			'header_text'               => '',
			'header_date'               => false,
			'header_search'             => false,
			'author_bio'                => false,
			'footer_content'            => false,
			'footer_text'               => '',
			'credit_link'               => true,
			'scroll_to_top'             => false,
			'primary_color'             => '#ee1133',
			'secondary_color'           => '#d5001a',
			'tertiary_color'            => '#bb0000',
			'accent_color'              => '#1153ee',
			'highlight_color'           => '#eedc11',
			'light_gray_color'          => '#f2f2f2',
			'gray_color'                => '#666666',
			'dark_gray_color'           => '#202020',
			'link_color'                => '#ee1133',
			'button_color'              => '#ee1133',
			'button_hover_color'        => '#D5001A',
			'navi_color'                => '#202020',
			'navi_submenu_color'        => '#ee1133',
			'title_color'               => '#202020',
			'widget_title_color'        => '#202020',
			'footer_color'              => '#202020',
			'text_font'                 => 'Raleway',
			'title_font'                => 'Quicksand',
			'title_is_bold'             => false,
			'title_is_uppercase'        => false,
			'navi_font'                 => 'Quicksand',
			'navi_is_bold'              => false,
			'navi_is_uppercase'         => false,
			'widget_title_font'         => 'Quicksand',
			'widget_title_is_bold'      => false,
			'widget_title_is_uppercase' => false,
		);

		return $default_options;
	}

	/**
	 * Embed JS file to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @return void
	 */
	static function customize_preview_js() {
		wp_enqueue_script( 'donovan-pro-customizer-js', DONOVAN_PRO_PLUGIN_URL . 'assets/js/customize-preview.min.js', array( 'customize-preview' ), '20210309', true );
	}

	/**
	 * Embed CSS styles for the theme options in the Customizer
	 *
	 * @return void
	 */
	static function customize_preview_css() {
		wp_enqueue_style( 'donovan-pro-customizer-css', DONOVAN_PRO_PLUGIN_URL . 'assets/css/customizer.css', array(), '20210212' );
	}
}

// Run Class.
add_action( 'init', array( 'Donovan_Pro_Customizer', 'setup' ) );
