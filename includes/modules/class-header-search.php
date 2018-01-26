<?php
/**
 * Header Search
 *
 * Displays header search in main navigation menu
 *
 * @package Donnager Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Header Search Class
 */
class Donnager_Pro_Header_Search {

	/**
	 * Header Search Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Donnager Theme is not active.
		if ( ! current_theme_supports( 'donnager-pro' ) ) {
			return;
		}

		// Enqueue Header Search JavaScript.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_script' ) );

		// Add search icon on main navigation menu.
		add_action( 'donnager_header_search', array( __CLASS__, 'add_header_search' ) );

		// Add Header Search checkbox in Customizer.
		add_action( 'customize_register', array( __CLASS__, 'header_search_settings' ) );

		// Hide Header Search if disabled.
		add_filter( 'donnager_hide_elements', array( __CLASS__, 'hide_header_search' ) );
	}

	/**
	 * Enqueue Scroll-To-Top JavaScript
	 *
	 * @return void
	 */
	static function enqueue_script() {

		// Get Theme Options from Database.
		$theme_options = Donnager_Pro_Customizer::get_theme_options();

		// Embed header search JS if enabled.
		if ( true === $theme_options['header_search'] || is_customize_preview() ) :

			wp_enqueue_script( 'donnager-pro-header-search', DONNAGER_PRO_PLUGIN_URL . 'assets/js/header-search.js', array( 'jquery' ), DONNAGER_PRO_VERSION, true );

		endif;
	}

	/**
	 * Add search form to navigation menu
	 *
	 * @return void
	 */
	static function add_header_search() {

		// Get Theme Options from Database.
		$theme_options = Donnager_Pro_Customizer::get_theme_options();

		// Show header search if activated.
		if ( true === $theme_options['header_search'] || is_customize_preview() ) : ?>

			<div class="header-search">

				<a class="header-search-icon">
					<?php echo donnager_get_svg( 'search' ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Search', 'donnager-pro' ); ?></span>
				</a>

				<div class="header-search-form">
					<?php get_search_form(); ?>
				</div>

			</div>

		<?php
		endif;
	}

	/**
	 * Adds header search checkbox setting
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function header_search_settings( $wp_customize ) {

		// Add Header Search Headline.
		$wp_customize->add_control( new Donnager_Customize_Header_Control(
			$wp_customize, 'donnager_theme_options[header_search_title]', array(
				'label'    => esc_html__( 'Header Search', 'donnager-pro' ),
				'section'  => 'donnager_pro_section_header',
				'settings' => array(),
				'priority' => 40,
			)
		) );

		// Add Header Search setting and control.
		$wp_customize->add_setting( 'donnager_theme_options[header_search]', array(
			'default'           => false,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'donnager_sanitize_checkbox',
		) );

		$wp_customize->add_control( 'donnager_theme_options[header_search]', array(
			'label'    => esc_html__( 'Enable search field in header', 'donnager-pro' ),
			'section'  => 'donnager_pro_section_header',
			'settings' => 'donnager_theme_options[header_search]',
			'type'     => 'checkbox',
			'priority' => 50,
		) );
	}

	/**
	 * Hide Header Search if deactivated.
	 *
	 * @param array $elements / Elements to be hidden.
	 * @return array $elements
	 */
	static function hide_header_search( $elements ) {

		// Get Theme Options from Database.
		$theme_options = Donnager_Pro_Customizer::get_theme_options();

		// Hide Header Search?
		if ( false === $theme_options['header_search'] ) {
			$elements[] = '.primary-navigation-wrap .header-search';
		}

		return $elements;
	}
}

// Run Class.
add_action( 'init', array( 'Donnager_Pro_Header_Search', 'setup' ) );
