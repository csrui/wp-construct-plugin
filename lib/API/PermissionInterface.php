<?php

namespace csrui\WPConstruct\Plugin\API;

/**
 * Interface for Route Permissions.
 *
 * @since      0.0.0
 * @package    Gulbenkian
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
interface PermissionInterface {

	/**
	 * Callback function for the register_rest_route's permission_callback.
	 *
	 * @since 0.0.0
	 * @see   https://developer.wordpress.org/reference/classes/wp_rest_posts_controller/register_routes/
	 * @see   https://developer.wordpress.org/rest-api/extending-the-rest-api/routes-and-endpoints/#permissions-callback
	 * @param \WP_REST_Request $wp_request
	 * @return boolean
	 */
	public function register( \WP_REST_Request $wp_request ) : bool;

}
