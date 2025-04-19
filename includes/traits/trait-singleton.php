<?php
/**
 * Singleton trait which implements Singleton pattern in any class in which this trait is used.
 *
 * Using the singleton pattern in WordPress is an easy way to protect against
 * mistakes caused by creating multiple objects or multiple initialization
 * of classes which need to be initialized only once.
 *
 * With complex plugins, there are many cases where multiple copies of
 * the plugin would load, and action hooks would load (and trigger) multiple
 * times.
 *
 * If you're planning on using a global variable, then you should implement
 * this trait. Singletons are a way to safely use globals; they let you
 * access and set the global from anywhere, without risk of collision.
 *
 * If any method in a class needs to be aware of "state", then you should
 * implement this trait in that class.
 *
 * If any method in the class need to "talk" to another or be aware of what
 * another method has done, then you should implement this trait in that class.
 *
 * If you specifically need multiple objects, then use a normal class.
 *
 * @package TheSamplePluginCore
 * @since   1.0.0
 */

namespace TheSamplePluginCore\Traits;

/**
 * Trait Singleton
 *
 * @package TheSamplePluginCore
 */
trait Singleton {

	/**
	 * Collection of instances.
	 *
	 * @var array<string, object>
	 */
	private static $instances = array();

	/**
	 * Protected class constructor to prevent direct object creation
	 *
	 * This is meant to be overridden in the classes which implement
	 * this trait. This is ideal for doing stuff that you only want to
	 * do once, such as hooking into actions and filters, etc.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	protected function __construct() {
	}

	/**
	 * Prevent object cloning
	 *
	 * @since 1.0.0
	 * @return void
	 */
	final protected function __clone() {
	}

	/**
	 * Prevent unserializing.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	final public function __wakeup() {
	}

	/**
	 * This method returns new or existing Singleton instance
	 * of the class for which it is called. This method is set
	 * as final intentionally, it is not meant to be overridden.
	 *
	 * @since 1.0.0
	 * @return object Singleton instance of the class.
	 */
	final public static function get_instance(): object {
		$called_class = static::class;

		if ( ! isset( self::$instances[ $called_class ] ) ) {
			self::$instances[ $called_class ] = new $called_class();

			/**
			 * Fires after singleton initialization.
			 *
			 * @since 1.0.0
			 * @param object $instance The singleton instance.
			 */
			do_action( "thesampleplugincore_singleton_init_{$called_class}", self::$instances[ $called_class ] );
		}

		return self::$instances[ $called_class ];
	}
}
