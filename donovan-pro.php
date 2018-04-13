<?php
/*
Plugin Name: Donovan Pro
Plugin URI: http://themezee.com/addons/donovan-pro/
Description: Adds additional features like footer widgets, custom colors, custom fonts, custom menus, and Magazine Post widgets to the Donovan theme.
Author: ThemeZee
Author URI: https://themezee.com/
Version: 1.1
Text Domain: donovan-pro
Domain Path: /languages/
License: GPL v3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Donovan Pro
Copyright(C) 2018, ThemeZee.com - support@themezee.com
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Main Donovan_Pro Class
 *
 * @package Donovan Pro
 */
class Donovan_Pro {

	/**
	 * Call all Functions to setup the Plugin
	 *
	 * @uses Donovan_Pro::constants() Setup the constants needed
	 * @uses Donovan_Pro::includes() Include the required files
	 * @uses Donovan_Pro::setup_actions() Setup the hooks and actions
	 * @return void
	 */
	static function setup() {

		// Setup Constants.
		self::constants();

		// Setup Translation.
		add_action( 'plugins_loaded', array( __CLASS__, 'translation' ) );

		// Include Files.
		self::includes();

		// Setup Action Hooks.
		self::setup_actions();

	}

	/**
	 * Setup plugin constants
	 *
	 * @return void
	 */
	static function constants() {

		// Define Plugin Name.
		define( 'DONOVAN_PRO_NAME', 'Donovan Pro' );

		// Define Version Number.
		define( 'DONOVAN_PRO_VERSION', '1.1' );

		// Define Plugin Name.
		define( 'DONOVAN_PRO_PRODUCT_ID', 171494 );

		// Define Update API URL.
		define( 'DONOVAN_PRO_STORE_API_URL', 'https://themezee.com' );

		// Plugin Folder Path.
		define( 'DONOVAN_PRO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin Folder URL.
		define( 'DONOVAN_PRO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		// Plugin Root File.
		define( 'DONOVAN_PRO_PLUGIN_FILE', __FILE__ );

	}

	/**
	 * Load Translation File
	 *
	 * @return void
	 */
	static function translation() {

		load_plugin_textdomain( 'donovan-pro', false, dirname( plugin_basename( DONOVAN_PRO_PLUGIN_FILE ) ) . '/languages/' );

	}

	/**
	 * Include required files
	 *
	 * @return void
	 */
	static function includes() {

		// Include Admin Classes.
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/admin/class-plugin-updater.php';
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/admin/class-settings.php';
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/admin/class-settings-page.php';
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/admin/class-admin-notices.php';

		// Include Customizer Classes.
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/customizer/class-customizer.php';

		// Include Pro Features.
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/modules/class-author-bio.php';
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/modules/class-custom-colors.php';
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/modules/class-custom-fonts.php';
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/modules/class-footer-line.php';
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/modules/class-footer-widgets.php';
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/modules/class-header-bar.php';
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/modules/class-header-search.php';
		require_once DONOVAN_PRO_PLUGIN_DIR . 'includes/modules/class-scroll-to-top.php';
	}

	/**
	 * Setup Action Hooks
	 *
	 * @see https://codex.wordpress.org/Function_Reference/add_action WordPress Codex
	 * @return void
	 */
	static function setup_actions() {

		// Enqueue Donovan Pro Stylesheet.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ), 11 );

		// Add Settings link to Plugin actions.
		add_filter( 'plugin_action_links_' . plugin_basename( DONOVAN_PRO_PLUGIN_FILE ), array( __CLASS__, 'plugin_action_links' ) );

		// Add automatic plugin updater from ThemeZee Store API.
		add_action( 'admin_init', array( __CLASS__, 'plugin_updater' ), 0 );
	}

	/**
	 * Enqueue Styles
	 *
	 * @return void
	 */
	static function enqueue_styles() {

		// Return early if Donovan Theme is not active.
		if ( ! current_theme_supports( 'donovan-pro' ) ) {
			return;
		}

		// Enqueue RTL or default Plugin Stylesheet.
		if ( is_rtl() ) {
			wp_enqueue_style( 'donovan-pro', DONOVAN_PRO_PLUGIN_URL . 'assets/css/donovan-pro-rtl.css', array(), DONOVAN_PRO_VERSION );
		} else {
			wp_enqueue_style( 'donovan-pro', DONOVAN_PRO_PLUGIN_URL . 'assets/css/donovan-pro.css', array(), DONOVAN_PRO_VERSION );
		}

		// Get Custom CSS.
		$custom_css = apply_filters( 'donovan_pro_custom_css_stylesheet', '' );

		// Sanitize CSS Code.
		$custom_css = wp_kses( $custom_css, array( '\'', '\"' ) );
		$custom_css = str_replace( '&gt;', '>', $custom_css );
		$custom_css = preg_replace( '/\n/', '', $custom_css );
		$custom_css = preg_replace( '/\t/', '', $custom_css );

		// Enqueue Custom CSS.
		wp_add_inline_style( 'donovan-pro', $custom_css );
	}

	/**
	 * Add Settings link to the plugin actions
	 *
	 * @param array $actions Plugin action links.
	 * @return array $actions Plugin action links
	 */
	static function plugin_action_links( $actions ) {

		$settings_link = array(
			'settings' => sprintf( '<a href="%s">%s</a>', admin_url( 'themes.php?page=donovan-pro' ), __( 'Settings', 'donovan-pro' ) ),
		);

		return array_merge( $settings_link, $actions );
	}

	/**
	 * Plugin Updater
	 *
	 * @return void
	 */
	static function plugin_updater() {

		$options = Donovan_Pro_Settings::instance();

		if ( $options->get( 'license_key' ) <> '' ) :

			$license_key = trim( $options->get( 'license_key' ) );

			// Setup the updater.
			$donovan_pro_updater = new Donovan_Pro_Plugin_Updater( DONOVAN_PRO_STORE_API_URL, __FILE__, array(
					'version' 	=> DONOVAN_PRO_VERSION,
					'license' 	=> $license_key,
					'item_name' => DONOVAN_PRO_NAME,
					'item_id'   => DONOVAN_PRO_PRODUCT_ID,
					'author' 	=> 'ThemeZee',
				)
			);

		endif;
	}
}

// Run Plugin.
Donovan_Pro::setup();
