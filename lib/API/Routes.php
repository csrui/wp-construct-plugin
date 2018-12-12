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

	/**
	 * Defines a new route.
	 *
	 * @since 0.0.1
	 * @param string $endpoint Endpoint to respond.
	 * @param string $method   HTTP method.
	 * @param object $class    Object that will handle the callback.
	 * @param string $callback Custom method to answer to the endpoint.
	 */
	public function add( string $endpoint, string $method, $class, $callback = null ) {

		$method = strtolower( $method );

		if ( class_exist( $class ) !== true ) {
			return;
		}

		// If no callback is defined, set a default one.
		if ( is_null( $callback ) ) {
			$class_namespaces = explode( '\\', $class );
			$class_name       = strtolower( end( $class_namespaces ) );
			$action           = strtolower( str_replace( '/', '_', $endpoint ) );
			unset( $class_namespaces );

			// For sake of speed let's default to "list".
			if ( $class_name === substr( $action, 1 ) ) {
				$action = ( $method === 'post' ) ? '_create' : '_list';
			}

			$callback = $method . $action;
		}

		// Check if either given or automagic callback are available.
		if ( is_callable( [ $class, $callback ] ) !== true ) {
			return;
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

			register_rest_route( Plugin::NAMESPACE_API, $route->endpoint(), [
				'methods'  => $route->method(),
				'callback' => $route->callback(),
			] );
		}
	}

}
