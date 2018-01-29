<?php
/**
 * Custom Colors
 *
 * Adds color settings to Customizer and generates color CSS code
 *
 * @package Donovan Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Custom Colors Class
 */
class Donovan_Pro_Custom_Colors {

	/**
	 * Custom Colors Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Donovan Theme is not active.
		if ( ! current_theme_supports( 'donovan-pro' ) ) {
			return;
		}

		// Add Custom Color CSS code to custom stylesheet output.
		add_filter( 'donovan_pro_custom_css_stylesheet', array( __CLASS__, 'custom_colors_css' ) );

		// Add Custom Color Settings.
		add_action( 'customize_register', array( __CLASS__, 'color_settings' ) );
	}

	/**
	 * Adds Color CSS styles in the head area to override default colors
	 *
	 * @param String $custom_css Custom Styling CSS.
	 * @return string CSS code
	 */
	static function custom_colors_css( $custom_css ) {

		// Get Theme Options from Database.
		$theme_options = Donovan_Pro_Customizer::get_theme_options();

		// Get Default Fonts from settings.
		$default_options = Donovan_Pro_Customizer::get_default_options();

		// Color Variables.
		$color_variables = '';

		// Set Link Color.
		if ( $theme_options['link_color'] !== $default_options['link_color'] ) {
			$color_variables .= '--link-color: ' . $theme_options['link_color'] . ';';
		}

		// Set Button Color.
		if ( $theme_options['button_color'] !== $default_options['button_color'] ) {
			$color_variables .= '--button-color: ' . $theme_options['button_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['button_color'] ) ) {
				$color_variables .= '--button-text-color: #202020;';
			}
		}

		// Set Button Hover Color.
		if ( $theme_options['button_hover_color'] !== $default_options['button_hover_color'] ) {
			$color_variables .= '--button-hover-color: ' . $theme_options['button_hover_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['button_hover_color'] ) ) {
				$color_variables .= '--button-hover-text-color: #202020;';
			}
		}

		// Set Navi Color.
		if ( $theme_options['navi_color'] !== $default_options['navi_color'] ) {
			$color_variables .= '--navi-color: ' . $theme_options['navi_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['navi_color'] ) ) {
				$color_variables .= '--navi-text-color: #202020;';
				$color_variables .= '--navi-hover-text-color: rgba(0, 0, 0, 0.5);';
				$color_variables .= '--navi-border-color: rgba(0, 0, 0, 0.075);';
			}
		}

		// Set Submenu Color.
		if ( $theme_options['navi_submenu_color'] !== $default_options['navi_submenu_color'] ) {
			$color_variables .= '--submenu-color: ' . $theme_options['navi_submenu_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['navi_submenu_color'] ) ) {
				$color_variables .= '--submenu-text-color: #202020;';
				$color_variables .= '--submenu-hover-text-color: rgba(0, 0, 0, 0.5);';
				$color_variables .= '--submenu-border-color: rgba(0, 0, 0, 0.1);';
			}
		}

		// Set Title Color.
		if ( $theme_options['title_color'] !== $default_options['title_color'] ) {
			$color_variables .= '--title-color: ' . $theme_options['title_color'] . ';';
		}

		// Set Footer Color.
		if ( $theme_options['footer_color'] !== $default_options['footer_color'] ) {
			$color_variables .= '--footer-color: ' . $theme_options['footer_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['footer_color'] ) ) {
				$color_variables .= '--footer-text-color: #202020;';
				$color_variables .= '--footer-hover-text-color: rgba(0, 0, 0, 0.5);';
				$color_variables .= '--footer-border-color: rgba(0, 0, 0, 0.05);';
			}
		}

		// Set Color Variables.
		if( '' !== $color_variables ) {
			$custom_css .= ':root {' . $color_variables . '}';
		}

		return $custom_css;
	}

	/**
	 * Adds all color settings in the Customizer
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function color_settings( $wp_customize ) {

		// Add Section for Theme Colors.
		$wp_customize->add_section( 'donovan_pro_section_colors', array(
			'title'    => esc_html__( 'Color Settings', 'donovan-pro' ),
			'priority' => 60,
			'panel'    => 'donovan_options_panel',
		) );

		// Get Default Colors from settings.
		$default_options = Donovan_Pro_Customizer::get_default_options();

		// Add Link Color setting.
		$wp_customize->add_setting( 'donovan_theme_options[link_color]', array(
			'default'           => $default_options['link_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'donovan_theme_options[link_color]', array(
				'label'    => esc_html_x( 'Links', 'color setting', 'donovan-pro' ),
				'section'  => 'donovan_pro_section_colors',
				'settings' => 'donovan_theme_options[link_color]',
				'priority' => 10,
			)
		) );

		// Add Button Color setting.
		$wp_customize->add_setting( 'donovan_theme_options[button_color]', array(
			'default'           => $default_options['button_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'donovan_theme_options[button_color]', array(
				'label'    => esc_html_x( 'Buttons', 'color setting', 'donovan-pro' ),
				'section'  => 'donovan_pro_section_colors',
				'settings' => 'donovan_theme_options[button_color]',
				'priority' => 20,
			)
		) );

		// Add Button Hover Color setting.
		$wp_customize->add_setting( 'donovan_theme_options[button_hover_color]', array(
			'default'           => $default_options['button_hover_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'donovan_theme_options[button_hover_color]', array(
				'label'    => esc_html_x( 'Buttons Hover', 'color setting', 'donovan-pro' ),
				'section'  => 'donovan_pro_section_colors',
				'settings' => 'donovan_theme_options[button_hover_color]',
				'priority' => 30,
			)
		) );

		// Add Navigation Primary Color setting.
		$wp_customize->add_setting( 'donovan_theme_options[navi_color]', array(
			'default'           => $default_options['navi_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'donovan_theme_options[navi_color]', array(
				'label'    => esc_html_x( 'Main Navigation', 'color setting', 'donovan-pro' ),
				'section'  => 'donovan_pro_section_colors',
				'settings' => 'donovan_theme_options[navi_color]',
				'priority' => 40,
			)
		) );

		// Add Navigation Secondary Color setting.
		$wp_customize->add_setting( 'donovan_theme_options[navi_submenu_color]', array(
			'default'           => $default_options['navi_submenu_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'donovan_theme_options[navi_submenu_color]', array(
				'label'    => esc_html_x( 'Sub Menus', 'color setting', 'donovan-pro' ),
				'section'  => 'donovan_pro_section_colors',
				'settings' => 'donovan_theme_options[navi_submenu_color]',
				'priority' => 50,
			)
		) );

		// Add Title Color setting.
		$wp_customize->add_setting( 'donovan_theme_options[title_color]', array(
			'default'           => $default_options['title_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'donovan_theme_options[title_color]', array(
				'label'    => esc_html_x( 'Titles', 'color setting', 'donovan-pro' ),
				'section'  => 'donovan_pro_section_colors',
				'settings' => 'donovan_theme_options[title_color]',
				'priority' => 60,
			)
		) );

		// Add Widget Title Color setting.
		$wp_customize->add_setting( 'donovan_theme_options[footer_color]', array(
			'default'           => $default_options['footer_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'donovan_theme_options[footer_color]', array(
				'label'    => esc_html_x( 'Footer', 'color setting', 'donovan-pro' ),
				'section'  => 'donovan_pro_section_colors',
				'settings' => 'donovan_theme_options[footer_color]',
				'priority' => 70,
			)
		) );
	}

	/**
	 * Returns color brightness.
	 *
	 * @param int Number of brightness.
	 */
	static function get_color_brightness( $hex_color ) {

		// Remove # string.
		$hex_color = str_replace( '#', '', $hex_color );

		// Convert into RGB.
		$r = hexdec( substr( $hex_color, 0, 2 ) );
		$g = hexdec( substr( $hex_color, 2, 2 ) );
		$b = hexdec( substr( $hex_color, 4, 2 ) );

		return ( ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000 );
	}

	/**
	 * Check if the color is light.
	 *
	 * @param bool True if color is light.
	 */
	static function is_color_light( $hex_color ) {
		return ( self::get_color_brightness( $hex_color ) > 130 );
	}

	/**
	 * Check if the color is dark.
	 *
	 * @param bool True if color is dark.
	 */
	static function is_color_dark( $hex_color ) {
		return ( self::get_color_brightness( $hex_color ) <= 130 );
	}
}

// Run Class.
add_action( 'init', array( 'Donovan_Pro_Custom_Colors', 'setup' ) );
