<?php
/**
 * Header Bar
 *
 * @package Donovan Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Header Bar Class
 */
class Donovan_Pro_Header_Bar {

	/**
	 * Class Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Donovan Theme is not active.
		if ( ! current_theme_supports( 'donovan-pro' ) ) {
			return;
		}

		// Display Header Bar.
		add_action( 'donovan_header_bar', array( __CLASS__, 'display_header_bar' ) );

		// Add Header Settings.
		add_action( 'customize_register', array( __CLASS__, 'header_settings' ) );

		// Hide Header Date if disabled.
		add_filter( 'donovan_hide_elements', array( __CLASS__, 'hide_header_date' ) );
	}

	/**
	 * Displays top navigation and social menu on header bar
	 *
	 * @return void
	 */
	static function display_header_bar() {

		// Get theme options.
		$theme_options = Donovan_Pro_Customizer::get_theme_options();

		// Check if there is content for the header bar.
		if ( false !== $theme_options['header_date'] || '' !== $theme_options['header_text'] ||  has_nav_menu( 'secondary' ) || is_customize_preview() ) : ?>

			<div id="header-top" class="header-bar-wrap">

				<div id="header-bar" class="header-bar container clearfix">

					<?php
					if ( false !== $theme_options['header_date'] || '' !== $theme_options['header_text'] || is_customize_preview() ) : ?>

						<div class="header-content">

							<?php
							if ( false !== $theme_options['header_date'] || is_customize_preview() ) : ?>

								<span class="header-date"><?php echo current_time( get_option( 'date_format' ) ); ?></span>

							<?php endif;

							if ( '' !== $theme_options['header_text'] || is_customize_preview() ) : ?>

								<span class="header-text"><?php echo do_shortcode( wp_kses_post( $theme_options['header_text'] ) ); ?></span>

							<?php endif; ?>

						</div>

					<?php
					endif;

					// Check if there is a top navigation menu.
					if ( has_nav_menu( 'secondary' ) ) : ?>

						<nav id="top-navigation" class="secondary-navigation navigation clearfix" role="navigation">

							<?php
							// Display Top Navigation.
							wp_nav_menu( array(
								'theme_location' => 'secondary',
								'container'      => false,
								'menu_class'     => 'top-navigation-menu',
								'echo'           => true,
								'fallback_cb'    => '',
							) );
							?>

						</nav>

					<?php endif; ?>

				</div>

			</div>

		<?php
		endif;
	}

	/**
	 * Adds site logo settings
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function header_settings( $wp_customize ) {

		// Add Section for Header Settings.
		$wp_customize->add_section( 'donovan_pro_section_header', array(
			'title'    => __( 'Header Settings', 'donovan-pro' ),
			'priority' => 20,
			'panel'    => 'donovan_options_panel',
		) );

		// Add Header Date Headline.
		$wp_customize->add_control( new Donovan_Customize_Header_Control(
			$wp_customize, 'donovan_theme_options[header_date_title]', array(
				'label'    => esc_html__( 'Header Date', 'donovan-pro' ),
				'section'  => 'donovan_pro_section_header',
				'settings' => array(),
				'priority' => 10,
			)
		) );

		// Add Header Date setting.
		$wp_customize->add_setting( 'donovan_theme_options[header_date]', array(
			'default'           => false,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'donovan_sanitize_checkbox',
		) );

		$wp_customize->add_control( 'donovan_theme_options[header_date]', array(
			'label'    => esc_html__( 'Display current date in header bar', 'donovan-pro' ),
			'section'  => 'donovan_pro_section_header',
			'settings' => 'donovan_theme_options[header_date]',
			'type'     => 'checkbox',
			'priority' => 20,
		) );

		// Add Header Text setting.
		$wp_customize->add_setting( 'donovan_theme_options[header_text]', array(
			'default'           => '',
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_header_text' ),
		) );

		$wp_customize->add_control( 'donovan_theme_options[header_text]', array(
			'label'    => __( 'Header Text', 'donovan-pro' ),
			'section'  => 'donovan_pro_section_header',
			'settings' => 'donovan_theme_options[header_text]',
			'type'     => 'textarea',
			'priority' => 30,
		) );

		// Add selective refresh for header text.
		$wp_customize->selective_refresh->add_partial( 'donovan_theme_options[header_text]', array(
			'selector'         => '.header-bar .header-content .header-text',
			'render_callback'  => array( __CLASS__, 'customize_partial_header_text' ),
			'fallback_refresh' => false,
		) );
	}

	/**
	 *  Sanitize header text
	 *
	 * @param String $value / Value of the setting.
	 * @return string
	 */
	static function sanitize_header_text( $value ) {

		if ( current_user_can( 'unfiltered_html' ) ) :
			return $value;
		else :
			return stripslashes( wp_filter_post_kses( addslashes( $value ) ) );
		endif;
	}

	/**
	 * Render the header text for the selective refresh partial.
	 */
	static function customize_partial_header_text() {
		$theme_options = Donovan_Pro_Customizer::get_theme_options();
		echo do_shortcode( wp_kses_post( $theme_options['header_text'] ) );
	}

	/**
	 * Hide Header Date if deactivated.
	 *
	 * @param array $elements / Elements to be hidden.
	 * @return array $elements
	 */
	static function hide_header_date( $elements ) {

		// Get Theme Options from Database.
		$theme_options = Donovan_Pro_Customizer::get_theme_options();

		// Hide Header Search?
		if ( false === $theme_options['header_date'] ) {
			$elements[] = '.header-bar .header-content .header-date';
		}

		return $elements;
	}

	/**
	 * Register navigation menus
	 *
	 * @return void
	 */
	static function register_nav_menus() {

		// Return early if Donovan Theme is not active.
		if ( ! current_theme_supports( 'donovan-pro' ) ) {
			return;
		}

		register_nav_menus( array(
			'secondary' => esc_html__( 'Top Navigation', 'donovan-pro' ),
		) );

	}
}

// Run Class.
add_action( 'init', array( 'Donovan_Pro_Header_Bar', 'setup' ) );

// Register navigation menus in backend.
add_action( 'after_setup_theme', array( 'Donovan_Pro_Header_Bar', 'register_nav_menus' ), 20 );
