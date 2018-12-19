<?php

namespace csrui\WPConstruct\Plugin;

use csrui\WPConstruct\Plugin\Registerable;
use csrui\WPConstruct\Plugin\ContentType\PostType;
use csrui\WPConstruct\Plugin\ContentType\Taxonomy;
use csrui\WPConstruct\Plugin\ContentType\ACF\FieldType;
use csrui\WPConstruct\Plugin\ContentType\ACF\Group;


/**
 * Class loader to help keep and access instanciated objects
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
trait ClassLoader {

	/**
	 * Container for loaded classes
	 *
	 * @since 0.0.1
	 * @var   array
	 */
	protected $loaded = [];

	/**
	 * Load a new class or get an existing one
	 *
	 * @since  0.0.1
	 * @param  string $class_name Name of the class
	 * @param  array  $params     Class constructor parameters
	 * @return object             Returns instanciated class object
	 */
	public final function load( string $class_name, ...$params ) {

		$obj_hash = md5( json_encode( func_get_args() ) );

		if ( ! isset( $this->loaded[ $obj_hash ] ) ) {
			$new_obj                   = new \ReflectionClass( $class_name );
			$this->loaded[ $obj_hash ] = $new_obj->newInstanceArgs( $params );
		}

		return $this->loaded[ $obj_hash ];
	}

	/**
	 * Get list of all loaded components
	 *
	 * @since  0.0.3
	 * @return array List of objects
	 */
	public function get_loaded() : array {
		return $this->loaded;
	}

	/**
	 * Automatically register PostTypes, Taxonomies and Field Groups
	 *
	 * @since  0.0.3
	 */
	public function autoregister() {

		$objects = $this->get_loaded();

		if ( empty( $objects ) ) {
			return;
		}

		foreach ( $objects as $obj ) {

			if ( ! $obj instanceof Registerable ) {
				continue;
			}

			if ( ! $obj instanceof PostType && ! $obj instanceof Taxonomy && ! $obj instanceof Group ) {
				continue;
			}

			add_action( 'init', [ $obj, 'register' ] );
		}
	}
}
