# REST API

To create quick custom REST routes.

```php
use \csrui\WPConstruct\Plugin\API\Routes;

$routes = new RestRoutes();
$routes->add( '/list/test', 'GET', \FCG\WP\Plugin\Agenda\API\Messages::class );
$routes->add( '/create', 'POST', \FCG\WP\Plugin\Agenda\API\Messages::class );

add_action( 'rest_api_init', array( $routes, 'register' ) );
```

These routes will be magically translated into class static methods.
Let's see how to setup our Messages controller to anwer the REST calls.

```php
namespace FCG\WP\Plugin\Agenda\API;

/**
 * Register all endpoints for Messages.
 *
 * @since      0.0.0
 * @package    FCG
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
class Messages {

	/**
	 * Handles REST callback.
	 *
	 * @since  0.0.0
	 * @param  WP_REST_Request $request  Current request
	 * @return WP_REST_Response|WP_Error Either Rest response or WP error
	 */
	public static function get_list_test( \WP_REST_Request $request ) {

		$response = [];

		return new \WP_REST_Response( $response, 200 );
	}

	public static function post_create( \WP_REST_Request $request ) {
		return new \WP_REST_Response( ['created' => true ], 200 );
	}
}
```
