<?php
/**
 * The Sample Plugin Core
 *
 * @wordpress-plugin
 * Plugin Name:       The Sample Plugin Core
 * Plugin URI:        https://surajwp.com
 * Description:       The Sample Plugin Core
 * Version:           1.0.0
 * Requires at least: 5.4
 * Requires PHP:      7.4
 * Author:            Suraj Singh
 * Author URI:        https://surajwp.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       the-sample-plugin-core
 * Domain Path:       /languages
 *
 * @package           TheSamplePluginCore
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants.
define( 'THE_SAMPLE_PLUGIN_CORE_VERSION', '1.0.0' );
define( 'THE_SAMPLE_PLUGIN_CORE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'THE_SAMPLE_PLUGIN_CORE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'THE_SAMPLE_PLUGIN_CORE_PLUGIN_FILE', __FILE__ );
define( 'THE_SAMPLE_PLUGIN_CORE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Include the main The Sample Plugin Core class.
 *
 * @since 1.0.0
 */
if ( file_exists( THE_SAMPLE_PLUGIN_CORE_PLUGIN_PATH . 'vendor/autoload.php' ) ) {
	require_once THE_SAMPLE_PLUGIN_CORE_PLUGIN_PATH . 'vendor/autoload.php';
	require_once THE_SAMPLE_PLUGIN_CORE_PLUGIN_PATH . '/includes/helpers/custom-functions.php';
}

/**
 * Activate the plugin.
 *
 * @since    1.0.0
 * @access   public
 * @return   void
 */
function thesampleplugincore_activate(): void {
	flush_rewrite_rules();
	do_action( 'thesampleplugincore_activate' );
}

register_activation_hook( __FILE__, 'thesampleplugincore_activate' );

/**
 * Deactivate the plugin.
 *
 * @since    1.0.0
 * @access   public
 * @return   void
 */
function thesampleplugincore_deactivate() {
	flush_rewrite_rules();
	do_action( 'thesampleplugincore_deactivate' );
}

register_deactivation_hook( __FILE__, 'thesampleplugincore_deactivate' );

/**
 * Loads The Sample Plugin Core files only if The Sample Plugin Core is present.
 */
function thesampleplugincore_init() {

	do_action( 'thesampleplugincore_init' );
}

add_action( 'plugins_loaded', 'thesampleplugincore_init' );
