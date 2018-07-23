<?php

namespace csrui\WPConstruct\Plugin\API;

use FCG\WP\Plugin\Egrants\Plugin;

/**
 * Register all api routes.
 *
 * @since      0.0.1
 * @package    Gulbenkian
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
class Routes {

	protected $routes = [];

	public function add( string $endpoint, string $method, $class, $callback = null ) {

		if ( $callback === null ) {
			$callback = \strtolower( $method ) . strtolower( str_replace( '/', '_', $endpoint ) );
		}
		$this->routes[] = new Route( $endpoint, $method, [ $class, $callback ] );
	}

	/**
	 * Register all routes.
	 *
	 * @since 0.0.1
	 * @return void
	 */
	public function register() {

		if ( empty( $this->routes ) ) {
			return;
		}

		foreach ( $this->routes as $route ) {

			register_rest_route( Plugin::NAMESPACE_API, $route->endpoint, [
				'methods'  => $route->method,
				'callback' => $route->callback,
			] );
		}
	}

}
