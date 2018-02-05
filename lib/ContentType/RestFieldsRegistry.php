<?php

namespace csrui\WPConstruct\Plugin\ContentType;

use csrui\WPConstruct\Plugin\ContentType\ContentTypeRegistry;
use csrui\WPConstruct\Plugin\ContentType\RestFields;

/**
 * Handles registering Rest custom fields. Still in BETA.
 *
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
class RestFieldsRegistry {

	/**
	 * Get data from a WP post
	 *
	 * @since  0.0.1
	 * @access protected
	 * @param  array $post    A WP Post in array format
	 * @param  array $objects List ACF Group fields
	 * @return array
	 */
	static protected function get_rest_from_post( array $post, array $objects ) : array {

		$data = [];

		if ( isset( $post['id'] ) !== true || is_numeric( $post['id'] ) !== true ) {
			return $data;
		}

		if ( empty( $objects ) ) {
			return $data;
		}

		foreach ( $objects as $obj ) {

			// If object doesnt implement RestFields just ignore it
			if ( ( $obj instanceof RestFields ) === false ) {
				continue;
			}

			// Get list of rest fields
			$fields = $obj->get_rest_fields();

			foreach ( $fields as $field ) {

				// Check first if a custom getter was defined for a given field
				if ( is_callable( [ $obj, "get_rest_{$field}" ] ) ) {
					$data[ $field ] = call_user_func( [ $obj, "get_rest_{$field}" ] );
				} else {
					$data[ $field ] = get_field( $field, $post['id'] );
				}
			}
		}

		return $data;
	}

	static protected function sorter( array $objects = [] ) : array {

		$data = [];

		if ( empty( $objects ) ) {
			return $data;
		}

		foreach ( $objects as $obj ) {

			$locations = $obj->get_locations();

			foreach ( $locations as $type => $value ) {
				if ( $type !== 'post_type' ) {
					continue;
				}

				$data[ $value ][] = $obj;
			}
		}

		return $data;
	}

	static protected function get_objects_to_register() : array {

		$data    = [];
		$objects = [];

		foreach ( ContentTypeRegistry::get() as $class ) {

			if ( $class instanceof RestFields ) {
				$objects[] = $class;
			}
		}

		$data = static::sorter( $objects );

		return $data;
	}

	static public function register() {

		$objects_to_register = static::get_objects_to_register();

		add_action( 'rest_api_init', function() use ( $objects_to_register ) {

			foreach ( $objects_to_register as $post_type => $objects ) {

				register_rest_field( $post_type, 'acf', [

					'get_callback' => function( $post ) use ( $objects ) {
						return static::get_rest_from_post( $post, $objects );
					}
				] );
			}
		} );
	}
}
