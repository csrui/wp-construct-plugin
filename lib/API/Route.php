<?php

namespace FCG\WP\Plugin\Egrants\API;

/**
 * Create all api routes.
 *
 * @since      0.0.1
 * @package    Gulbenkian
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
class Route {

	public function __construct( $endpoint, $method, $callback ) {

		$this->endpoint = $endpoint;
		$this->method   = $method;
		$this->callback = $callback;
	}
}
