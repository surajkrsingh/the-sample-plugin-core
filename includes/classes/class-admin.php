<?php
/**
 * Settings Class
 *
 * @package    TheSamplePluginCore
 * @subpackage Classes
 * @since      1.0.0
 */

namespace TheSamplePluginCore\Classes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use TheSamplePluginCore\Traits\Singleton;

/**
 * The Admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 * @package    TheSamplePluginCore
 * @subpackage TheSamplePluginCore/admin
 */
class Admin {

	use Singleton;

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Setup hooks.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function setup_hooks(): void {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @since 1.0.0
	 * @param string $hook_suffix The current admin page.
	 * @return void
	 */
	public function enqueue_admin_scripts( string $hook_suffix ): void {
		if ( 'toplevel_page_thesampleplugincore' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_media();
		wp_enqueue_style(
			'thesampleplugincore-admin',
			THE_SAMPLE_PLUGIN_CORE_PLUGIN_URL . 'build/css/thesampleplugincore-admin.css',
			array(),
			THE_SAMPLE_PLUGIN_CORE_VERSION
		);

		wp_enqueue_script(
			'thesampleplugincore-admin',
			THE_SAMPLE_PLUGIN_CORE_PLUGIN_URL . 'build/js/thesampleplugincore-admin.js',
			array( 'jquery', 'wp-color-picker' ),
			THE_SAMPLE_PLUGIN_CORE_VERSION,
			true
		);

		wp_localize_script(
			'thesampleplugincore-admin',
			'thesampleplugincoreAdmin',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'thesampleplugincore_admin_nonce' ),
			)
		);
	}
}
