<?php

namespace csrui\WPConstruct\Plugin\ContentType;

use csrui\WPConstruct\Plugin\Registerable;

/**
 * Handles registering PostTypes and Taxonomies
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
class ContentTypeRegistry {

	/**
	 * Container for registered objects
	 *
	 * @since 0.0.1
	 * @var   array
	 */
	protected static $classes = [];

	/**
	 * Registers content object with WordPress
	 *
	 * @since  0.0.1
	 * @param  object $class Object that implements Registerable interface
	 * @return void
	 */
	public static function register( $class ) {

		if ( $class instanceof Registerable ) {

			static::$classes[] = $class;
			add_action( 'init', [ $class, 'register' ] );
		}
	}

	/**
	 * Return list of registered content objects
	 *
	 * @since  0.0.1
	 * @return array List of objects
	 */
	public static function get() : array {
		return static::$classes;
	}
}
