<?php

namespace csrui\WPConstruct\Plugin\API;

/**
 * Create an API route.
 *
 * @since      0.0.1
 * @package    Gulbenkian
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
class Route {

	/**
	 * Route configuration.
	 *
	 * @since 0.0.1
	 * @param string $endpoint Route endpoint.
	 * @param string $method   HTTP Method.
	 * @param array  $callback Callback that responsed to endpoint.
	 */
	public function __construct( string $endpoint, string $method, array $callback ) {

		$this->endpoint = $endpoint;
		$this->method   = $method;
		$this->callback = $callback;
	}
}
