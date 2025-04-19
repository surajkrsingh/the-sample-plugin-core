<?php
/**
 * The core plugin class.
 *
 * @package    TheSamplePluginCore
 * @subpackage TheSamplePluginCore/classes
 * @author     The Sample Plugin
 * @since      1.0.0
 */

namespace TheSamplePluginCore\Classes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use TheSamplePluginCore\Traits\Singleton;
use TheSamplePluginCore\Classes\Admin;

/**
 * The core plugin class.
 *
 * @since      1.0.0
 * @package    TheSamplePluginCore
 * @subpackage TheSamplePluginCore/includes
 * @author     The Sample Plugin
 */
final class Plugin {

	use Singleton;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->plugin_name = 'the-sample-plugin-core';
		$this->load_dependencies();
		$this->setup_hooks();
	}

	/**
	 * Load dependencies.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function load_dependencies(): void {
		if ( ! class_exists( 'Admin' ) && is_admin() ) {
			Admin::get_instance();
		}
	}

	/**
	 * Register all of the hooks related to the plugin functionality.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @return   void
	 */
	private function setup_hooks(): void {
		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_scripts' ) );
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'the-sample-plugin-core',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @return    string    The name of the plugin.
	 */
	public static function get_plugin_name() {
		return self::$plugin_name;
	}

	/**
	 * Enqueue public scripts.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function enqueue_public_scripts(): void {

		wp_enqueue_style(
			'thesampleplugincore-public',
			THE_SAMPLE_PLUGIN_CORE_PLUGIN_URL . 'build/css/thesampleplugincore-public.css',
			array(),
			THE_SAMPLE_PLUGIN_CORE_VERSION
		);

		wp_enqueue_script(
			'thesampleplugincore-public',
			THE_SAMPLE_PLUGIN_CORE_PLUGIN_URL . 'build/js/thesampleplugincore-public.js',
			array( 'jquery' ),
			THE_SAMPLE_PLUGIN_CORE_VERSION,
			true
		);

		wp_localize_script(
			'thesampleplugincore-public',
			'theSamplePluginCorePublic',
			array(
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'nonce'      => wp_create_nonce( 'thesampleplugincore_public_nonce' ),
				'isLoggedIn' => is_user_logged_in(),
			)
		);
	}
}
