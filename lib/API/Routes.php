<?php

namespace csrui\WPConstruct\Plugin\API;

use csrui\WPConstruct\Plugin;
use csrui\WPConstruct\Plugin\API\PermissionInterface;
use \WP_REST_Request;

/**
 * Register all api routes.
 *
 * @since      0.0.1
 * @package    Gulbenkian
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
class Routes {

	/**
	 * Holds the list of Routes.
	 *
	 * @since 0.0.1
	 * @var   array
	 */
	protected $routes = [];

	/**
	 * The route namespace.
	 * 
	 * @since 0.0.1
	 * @var string
	 */
	protected $namespace;

	/**
	 * Holds the permission object or list of objects.
	 *
	 * @since 0.0.1
	 * @var   object|array
	 */
	protected $permission;

	/**
	 * Defines the routes namespace and optional permissions.
	 *
	 * @since 0.0.1
	 * @param string $namespace
	 * @param object $permission
	 */
	public function __construct( string $namespace, $permission = null ) {

		$this->namespace = $namespace;

		if ( $permission instanceof PermissionInterface || is_array( $permission ) ) {
			$this->permission = $permission;
		}
	}

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

		if ( class_exists( $class ) !== true ) {
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

			register_rest_route( $this->namespace, $route->endpoint(), [
				'methods'             => $route->method(),
				'callback'            => $route->callback(),
				'permission_callback' => [ $this, 'permission_callback' ],
			] );
		}
	}

	/**
	 * Callback for the REST permissions.
	 * 
	 * Tests either a single or a stack of permissions.
	 * 
	 * @since 0.0.0
	 *
	 * @param WP_REST_Request $wp_request
	 * @return boolean
	 */
	public function permission_callback( WP_REST_Request $wp_request ) : bool {

		// For legacy support, with only one permission object.
		if ( $this->permission instanceof PermissionInterface ) {
			return $this->permission->register( $wp_request );
		}

		// Process a queue of permissions. As soon as one fails, block the request.
		if ( is_array( $this->permission ) ) {
			foreach ( $this->permission as $permission ) {

				if ( ! $permission instanceof PermissionInterface ) {
					continue;
				}

				if ( $permission->register( $wp_request ) === false ) {
					return false;
				}
			}
		}

		return true;
	}

}
