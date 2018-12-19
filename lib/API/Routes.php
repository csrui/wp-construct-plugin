<?php

namespace csrui\WPConstruct\Plugin\API;

use csrui\WPConstruct\Plugin;
use csrui\WPConstruct\Plugin\API\PermissionInterface;

/**
 * Register all api routes.
 *
 * @since      0.0.1
 * @package    Gulbenkian
 * @author     Gulbenkian <devdigital@csrui.pt>
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
	 * Holds the permission object
	 *
	 * @since 0.0.1
	 * @var   object
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

		if ( $permission instanceof PermissionInterface ) {
			$this->permission = $permission;
		}
	}

	public function add( string $endpoint, string $method, $class, $callback = null ) {

		$method = strtolower( $method );

		if ( $callback !== null ) {

			$this->routes[] = new Route( $endpoint, $method, [ $class, $callback ] );
			return;
		}

		// If no callback is defined, set a default one.
		$class_namespaces = explode( '\\', $class );
		$class_name       = strtolower( end( $class_namespaces ) );
		$action           = strtolower( str_replace( '/', '_', $endpoint ) );
		unset( $class_namespaces );

		// For sake of speed let's default to "list".
		if ( $class_name === substr( $action, 1 ) ) {
			$action = ( $method === 'post' ) ? '_create' : '_list';
		}

		$callback = $method . $action;

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

		$permission = null;

		if ( $this->permission instanceof PermissionInterface ) {
			$permission = [ $this->permission, 'register' ];
		}

		foreach ( $this->routes as $route ) {

			register_rest_route( $this->namespace, $route->endpoint, [
				'methods'  => $route->method,
				'callback' => $route->callback,
				'permission_callback' => $permission,
			] );
		}
	}

}
