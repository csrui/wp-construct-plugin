<?php

namespace csrui\WPConstruct\Plugin\ContentType;

/**
 *
 *
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
trait RestableFields {

	/**
	 *
	 *
	 * @since  0.0.1
	 * @access protected
	 * @return array
	 */
	protected function get_rest_data( array $post ) : array {

		$data = [];

		if ( isset( $post['id'] ) !== true || is_numeric( $post['id'] ) !== true ) {
			return $data;
		}

		$fields = $this->get_rest_fields();

		foreach ( $fields as $field ) {
			$data[ $field ] = \get_field( $field, $post['id'] );
		}

		return $data;
	}

	abstract protected function get_rest_fields() : array;

	/**
	 *
	 *
	 * @since  0.0.1
	 * @access protected
	 * @param  array $locations List of ACF locations
	 * @return void
	 */
	protected function register_rest_fields( array $locations = [] ) {

		$post_types = [];

		foreach ( $locations as $type => $value ) {
			if ( $type !== 'post_type' ) {
				continue;
			}

			$post_types[] = $value;
		}

		if ( empty( $post_types ) ) {
			return;
		}

		add_action( 'rest_api_init', function() use ( $post_types ) {
			foreach ( $post_types as $post_type ) {
				register_rest_field( $post_type, 'acf_' . $this->get_key(), [
					'get_callback' => function( $post ) {
						return $this->get_rest_data( $post );
					}
				] );
			}
		} );
	}
}
