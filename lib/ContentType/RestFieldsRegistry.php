<?php

namespace csrui\WPConstruct\Plugin\ContentType;

use csrui\WPConstruct\Plugin\ContentType\ContentTypeRegistry;
use csrui\WPConstruct\Plugin\ContentType\RestFields;

/**
 * Handles registering Rest custom fields. Still in BETA.
 *
 *
 * @since      0.0.1
 * @package    csrui\WPConstruct\Plugin\ContentType
 * @author     Rui Sardinha <mail@ruisardinha.com>
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

			if ( is_callable( [ $obj, 'get_rest_group' ] ) ) {

				$data[ $obj->group_rest_title ] = call_user_func( [ $obj, 'get_rest_group' ], $fields );
				continue;
			}

			foreach ( $fields as $field ) {

				// Check first if a custom getter was defined for a given field.
				if ( is_callable( [ $obj, "get_rest_{$field}" ] ) ) {
					$data[ $field ] = call_user_func( [ $obj, "get_rest_{$field}" ] );
					continue;
				}

				// If ACF detected, use it to retrieve metadata.
				// It would be nice if this was chosen and not auto-detected
				if ( function_exists( 'get_field' ) ) {
					$data[ $field ] = get_field( $field, $post['id'] );
					continue;
				}

				// Fallback to WordPress default function.
				$data[ $field ] = get_post_meta( $post['id'], $field );
			}
		} // End foreach().

		return $data;
	}

	/**
	 * Sort objects into specified groups.
	 *
	 * @since  0.0.0
	 * @param  array $objects
	 * @return array
	 */
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

	/**
	 * Get a list of RestFields to register.
	 *
	 * @since  0.0.0
	 * @param  array $plugin_components
	 * @return array
	 */
	static protected function get_objects_to_register( array $plugin_components = [] ) : array {

		$data    = [];
		$objects = [];

		foreach ( $plugin_components as $component ) {

			if ( $component instanceof RestFields ) {
				$objects[] = $component;
			}
		}

		$data = static::sorter( $objects );

		return $data;
	}

	/**
	 * Register each RestFields component.
	 *
	 * Example: RestFieldsRegistry::register( [
	 *   Fields\Event::class,
	 * ] );
	 *
	 * @since  0.0.0
	 * @param  array $plugin_components
	 * @return array
	 */
	static public function register( array $plugin_components = [] ) {

		$objects_to_register = static::get_objects_to_register( $plugin_components );

		add_action( 'rest_api_init', function() use ( $objects_to_register ) {

			foreach ( $objects_to_register as $post_type => $objects ) {

				register_rest_field( $post_type, 'custom_fields', 
					[
						'get_callback' => function( $post ) use ( $objects ) {
							return static::get_rest_from_post( $post, $objects );
						}
					] 
				);
			}
		} );
	}
}
