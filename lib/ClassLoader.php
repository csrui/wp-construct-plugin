<?php

namespace csrui\WPConstruct\Plugin;

/**
 * Class loader to help keep and access instanciated objects
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Gulbenkian <devdigital@csrui.pt>
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
	public final function load_class( string $class_name, array $params = [] ) {

		$obj_hash = md5( json_encode( func_get_args() ) );

		if ( ! isset( $this->loaded[ $obj_hash ] ) ) {
			$new_obj                   = new \ReflectionClass( $class_name );
			$this->loaded[ $obj_hash ] = $new_obj->newInstanceArgs( $params );
		}

		return $this->loaded[ $obj_hash ];
	}
}
