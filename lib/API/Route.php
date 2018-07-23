<?php

namespace csrui\WPConstruct\Plugin\API;

/**
 * Create an api routes.
 *
 * @since      0.0.1
 * @package    Gulbenkian
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
class Route {

	public function __construct( string $endpoint, string $method, $callback ) {

		$this->endpoint = $endpoint;
		$this->method   = $method;
		$this->callback = $callback;
	}
}
