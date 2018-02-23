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
	public final function load( string $class_name, ...$param ) {

		$obj_hash = md5( json_encode( func_get_args() ) );

		if ( ! isset( $this->loaded[ $obj_hash ] ) ) {
			$new_obj                   = new \ReflectionClass( $class_name );
			$this->loaded[ $obj_hash ] = $new_obj->newInstanceArgs( $param );
		}

		return $this->loaded[ $obj_hash ];
	}

	public function loaded() : array {
		return $this->loaded;
	}

	public function autoregister() {

		$objects = $this->loaded();

		if ( empty( $objects ) ) {
			return;
		}

		foreach ( $objects as $obj ) {

			if ( ! $obj instanceof Registerable ) {
				continue;
			}

			if ( $obj instanceof PostType || $obj instanceof Taxonomy || $obj instanceof Group ) {
				add_action( 'init', [ $obj, 'register' ] );
				continue;
			}

			if ( $obj instanceof FieldType ) {

				// add_action( 'acf/include_field_types', function() use ( $obj ) {
				// 	$weekly_sessions = new ACF\Fields\WeeklySessions( [] );
				// });
			}
		}
	}
}
