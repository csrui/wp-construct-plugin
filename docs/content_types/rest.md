# Content Types

## Exposing REST Fields

Getting some fields to show up on REST API is simple. Implement *RestFields*
on your Group like so.

```php
use \csrui\WPConstruct\Plugin\ContentType\RestFields;

class BasicEvent extends Group implements RestFields {
```

Now if you run you code you will get a missing method error.
Thats ok, it's supposed to.
Let's fix that but adding a method to or Group. The example below will add the
fields "lead" and "event_state" onto the API request.

```php
public function get_rest_fields() : array {
    return [
        'lead',
        'event_state',
    ];
}
```

To finish off let's tell our example plugin to register all these fields
on the API requests. We should do in *App.php* this after registering all Post Types,
Taxonomies and Fields.

```php
...

// Lets register REST fields
RestFieldsRegistry::register();
```

Here's a full example.

```php
namespace FCG\WP\Plugin\Agenda\Fields;

use \csrui\WPConstruct\Plugin\ContentType\ACF\Group;
use \csrui\WPConstruct\Plugin\ContentType\RestFields;

/**
 * Defines the `Lead` field.
 *
 * @since      0.0.1
 * @package    FCG
 * @subpackage Agenda/lib/Fields
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
class BasicEvent extends Group implements RestFields {

	/**
	 * ACF group key.
	 *
	 * @since 0.0.1
	 * @var   string
	 */
	protected $key = 'group_5a732e29337e8';

	/**
	 * List of fields available through REST API.
	 *
	 * @since  0.0.2
	 * @return array List of strings
	 */
	public function get_rest_fields() : array {
		return [
			'lead',
			'event_state',
		];
	}

...
```
