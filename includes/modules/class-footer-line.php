<?php
/**
 * Footer Line
 *
 * Displays credit link and footer text based on theme options
 * Registers and displays footer navigation
 *
 * @package Donnager Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Footer Line Class
 */
class Donnager_Pro_Footer_Line {

	/**
	 * Class Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Donnager Theme is not active.
		if ( ! current_theme_supports( 'donnager-pro' ) ) {
			return;
		}

		// Display footer navigation.
		add_action( 'donnager_footer_menu', array( __CLASS__, 'display_footer_menu' ) );

		// Display Footer Text in theme.
		add_action( 'donnager_footer_text', array( __CLASS__, 'footer_text' ) );

		// Hide Credit Link.
		add_filter( 'donnager_hide_elements', array( __CLASS__, 'hide_credit_link' ), 20 );

		// Add Footer Line Settings in Customizer.
		add_action( 'customize_register', array( __CLASS__, 'footer_settings' ) );
	}

	/**
	 * Display footer navigation menu
	 *
	 * @return void
	 */
	static function display_footer_menu() {

		// Check if there is a footer menu.
		if ( has_nav_menu( 'footer' ) ) {

			echo '<nav id="footer-links" class="footer-navigation navigation clearfix" role="navigation">';

			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'footer-navigation-menu',
				'echo'           => true,
				'fallback_cb'    => '',
				'depth'          => 1,
			) );

			echo '</nav><!-- #footer-links -->';

		}
	}

	/**
	 * Displays Footer Text.
	 *
	 * @return void
	 */
	static function footer_text() {

		// Get Theme Options from Database.
		$theme_options = Donnager_Pro_Customizer::get_theme_options();

		// Display Footer Text.
		if ( '' !== $theme_options['footer_text'] || is_customize_preview() ) :

			echo '<span class="footer-text">' . do_shortcode( wp_kses_post( $theme_options['footer_text'] ) ) . '</span>';

		endif;
	}

	/**
	 * Hide Credit Link if deactivated.
	 *
	 * @return void
	 */
	static function hide_credit_link( $elements ) {

		// Get Theme Options from Database.
		$theme_options = Donnager_Pro_Customizer::get_theme_options();

		// Hide Credit Link?
		if ( false === $theme_options['credit_link'] ) {
			$elements[] = '.site-info .credit-link';
		}

		return $elements;
	}

	/**
	 * Adds footer text and credit link setting
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function footer_settings( $wp_customize ) {

		// Add Section for Footer Settings.
		$wp_customize->add_section( 'donnager_pro_section_footer', array(
			'title'    => esc_html__( 'Footer Settings', 'donnager-pro' ),
			'priority' => 90,
			'panel'    => 'donnager_options_panel',
		) );

		// Add Footer Text setting.
		$wp_customize->add_setting( 'donnager_theme_options[footer_text]', array(
			'default'           => '',
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_footer_text' ),
		) );

		$wp_customize->add_control( 'donnager_theme_options[footer_text]', array(
			'label'    => esc_html__( 'Footer Text', 'donnager-pro' ),
			'section'  => 'donnager_pro_section_footer',
			'settings' => 'donnager_theme_options[footer_text]',
			'type'     => 'textarea',
			'priority' => 10,
		) );

		// Add selective refresh for footer text.
		$wp_customize->selective_refresh->add_partial( 'donnager_theme_options[footer_text]', array(
			'selector'         => '.site-info .footer-text',
			'render_callback'  => array( __CLASS__, 'customize_partial_footer_text' ),
			'fallback_refresh' => false,
		) );

		// Add Credit Link setting.
		$wp_customize->add_setting( 'donnager_theme_options[credit_link]', array(
			'default'           => true,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'donnager_sanitize_checkbox',
		) );

		$wp_customize->add_control( 'donnager_theme_options[credit_link]', array(
			'label'    => esc_html__( 'Display Credit Link to ThemeZee on footer line', 'donnager-pro' ),
			'section'  => 'donnager_pro_section_footer',
			'settings' => 'donnager_theme_options[credit_link]',
			'type'     => 'checkbox',
			'priority' => 20,
		) );
	}

	/**
	 *  Sanitize footer content textarea
	 *
	 * @param String $value / Value of the setting.
	 * @return string
	 */
	static function sanitize_footer_text( $value ) {

		if ( current_user_can( 'unfiltered_html' ) ) :
			return $value;
		else :
			return stripslashes( wp_filter_post_kses( addslashes( $value ) ) );
		endif;
	}

	/**
	 * Render the footer text for the selective refresh partial.
	 */
	static function customize_partial_footer_text() {
		$theme_options = Donnager_Pro_Customizer::get_theme_options();
		echo do_shortcode( wp_kses_post( $theme_options['footer_text'] ) );
	}

	/**
	 * Register footer navigation menu
	 *
	 * @return void
	 */
	static function register_footer_menu() {

		// Return early if Donnager Theme is not active.
		if ( ! current_theme_supports( 'donnager-pro' ) ) {
			return;
		}

		register_nav_menu( 'footer', esc_html__( 'Footer Navigation', 'donnager-pro' ) );
	}
}

// Run Class.
add_action( 'init', array( 'Donnager_Pro_Footer_Line', 'setup' ) );

// Register footer navigation in backend.
add_action( 'after_setup_theme', array( 'Donnager_Pro_Footer_Line', 'register_footer_menu' ), 30 );
