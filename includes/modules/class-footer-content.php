<?php
/**
 * Footer Content
 *
 * Displays site title and social icons in footer
 *
 * @package Donnager Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Footer Content Class
 */
class Donnager_Pro_Footer_Content {

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

		// Display footer content.
		add_action( 'donnager_before_footer', array( __CLASS__, 'display_footer_content' ) );

		// Hide Footer Content in Customizer.
		add_filter( 'donnager_hide_elements', array( __CLASS__, 'hide_footer_content' ), 20 );

		// Add Footer Settings in Customizer.
		add_action( 'customize_register', array( __CLASS__, 'footer_settings' ) );
	}

	/**
	 * Display footer content
	 *
	 * @return void
	 */
	static function display_footer_content() {

		// Get Theme Options from Database.
		$theme_options = Donnager_Pro_Customizer::get_theme_options();

		// Check if footer content is enabled.
		if ( true === $theme_options['footer_content'] || is_customize_preview() ) : ?>

			<div class="footer-content">

				<div id="footer-logo" class="site-branding clearfix">

					<?php donnager_site_logo(); ?>
					<?php donnager_site_title(); ?>

				</div><!-- .site-branding -->

				<?php
				// Check if there is a social menu.
				if ( has_nav_menu( 'social' ) ) : ?>

					<div id="footer-social-icons" class="footer-social-menu donnager-social-menu clearfix">

						<?php
						// Display Social Icons Menu.
						wp_nav_menu( array(
							'theme_location' => 'social',
							'container'      => false,
							'menu_class'     => 'social-icons-menu',
							'echo'           => true,
							'fallback_cb'    => '',
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>',
							'depth'          => 1,
						) );
						?>

					</div>

				<?php endif; ?>

			</div><!-- .footer-content -->

		<?php
		endif;
	}

	/**
	 * Hide Footer Content in Customizer.
	 *
	 * @return void
	 */
	static function hide_footer_content( $elements ) {

		// Get Theme Options from Database.
		$theme_options = Donnager_Pro_Customizer::get_theme_options();

		// Hide Footer Content?
		if ( false === $theme_options['footer_content'] && is_customize_preview() ) {
			$elements[] = '.site > .footer-content';
		}

		return $elements;
	}

	/**
	 * Add footer settings
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

		// Add Footer Content headline.
		$wp_customize->add_control( new Donnager_Customize_Header_Control(
			$wp_customize, 'donnager_theme_options[footer_content_title]', array(
				'label'    => esc_html__( 'Footer Content', 'donnager-pro' ),
				'section'  => 'donnager_pro_section_footer',
				'settings' => array(),
				'priority' => 10,
			)
		) );

		// Add Footer Content setting.
		$wp_customize->add_setting( 'donnager_theme_options[footer_content]', array(
			'default'           => false,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'donnager_sanitize_checkbox',
		) );

		$wp_customize->add_control( 'donnager_theme_options[footer_content]', array(
			'label'    => __( 'Display site title and social icons in footer', 'donnager-pro' ),
			'section'  => 'donnager_pro_section_footer',
			'settings' => 'donnager_theme_options[footer_content]',
			'type'     => 'checkbox',
			'priority' => 20,
		) );
	}
}

// Run Class.
add_action( 'init', array( 'Donnager_Pro_Footer_Content', 'setup' ) );
