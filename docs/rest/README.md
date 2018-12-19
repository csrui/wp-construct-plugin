# REST API

To create quick custom REST routes.

```php
use \csrui\WPConstruct\Plugin\API\Routes;

$routes = new Routes( Plugin::NAMESPACE_API );
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

Now let's imagine we want our API controller to respond only if there's an active user session.

For this we need to register a `Permissions` object that implements our `PermissionsInterface` and then pass it to the `Routes` constructor.

```php
namespace FCG\WP\Plugin\Agenda\API\Auth;

use csrui\WPConstruct\Plugin\API\PermissionInterface as PermissionInterface;

/**
 * Handle autentication via cookies
 *
 * @since      0.0.0
 * @package    FCG
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
class CookiePermission implements PermissionInterface {

	/**
	 * Check if user is authed via cookies.
	 *
	 * @since 0.0.0
	 *
	 * @param \WP_REST_Request $wp_request
	 * @return bool
	 */
	public function register( \WP_REST_Request $wp_request ) : bool {

		$user_id = get_current_user_id();

		if ( 0 < (int) $user_id ) {
			return true;
		}

		return false;
	}
}
```

Now going back to our Routes declaration we now add the `Permission` object like so.

```php
$permission = new CookiePermission();

$routes = new RestRoutes( Plugin::NAMESPACE_API, $permission );
```

At this point if you call any of your registered routes you should get the following as expected.

```json
{
    "code": "rest_forbidden",
    "message": "Sorry, you are not allowed to do that.",
    "data": {
        "status": 401
    }
}
```
