# Content Types

Registering content types with your WordPress plugin.

Let's look at the 3 types of content.

* [Creating Post Types](/content_types/README.md#creating-post-types)
* [Creating Taxonomies](/content_types/README.md#creating-taxonomies)
* [Creating Meta Fields](/content_types/README.md#creating-meta-fields)

## Creating Post Types

```php
namespace FCG\Agenda\PostType;

use \csrui\WPConstruct\Plugin\ContentType\PostType;

/**
 * Defines the `event` content type.
 *
 * @since      0.0.1
 * @package    FCG
 * @subpackage Agenda/lib/PostType
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
class Event extends PostType {

    protected function get_args() : array {

        $labels = [
            'name'                => _x( 'Events', 'Post Type General Name', 'fcg-agenda' ),
            'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'fcg-agenda' ),
            'menu_name'           => __( 'Events', 'fcg-agenda' ),
            'name_admin_bar'      => __( 'Events', 'fcg-agenda' ),
...
```

The file is big, let's just cut through the cookie dough.

```php
...

        $args = [
            'label'               => __( 'Event', 'fcg-agenda' ),
            'description'         => __( 'Events', 'fcg-agenda' ),
            'labels'              => $labels,
            'supports'            => $supports,
            'taxonomies'          => $this->get_taxonomies(),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 20,
            'menu_icon'           => 'dashicons-businessman',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capabilities'        => $capabilities,
            'show_in_rest'        => true,
            'has_archive'         => 'events',
            'rewrite'             => [ 'slug' => $this->get_slug() ],
        ];

        return $args;
    }
}
```

In case I want to register some filters, the method register_hooks() is
magically here to help. If you declare it on your class, it will be
called after registering the custom post type.

```php
protected function register_hooks() {

    do_action( 'activate_unikorn' );
}
```

The post type slug is inferred from the class name but let say we need
to customise it to avoid a collision with another plugin.

```php
public function get_slug() : string {

    return 'custom_slug';
}
```

## Creating Taxonomies

TODO: Add examples

## Creating Meta Fields

```php
namespace FCG\WP\Plugin\Agenda\Fields;

use \csrui\WPConstruct\Plugin\ContentType\ACF\Group;

/**
 * Defines the `Closing Days` fields.
 *
 * @since      0.0.1
 * @package    FCG
 * @subpackage Agenda/lib/Fields
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
class ClosingDays extends Group {

	/**
	 * ACF group key.
	 *
	 * @since    0.0.1
	 * @var      string
	 */
	protected $key = 'group_5a6b02443454d';

	/**
	 * ACF group location
	 *
	 * @since  0.0.1
	 * @return array
	 */
	public function get_locations() : array {

		return [
			'options_page' => 'acf-options-closing-days',
		];
	}

	/**
	 * Return list of fields to register.
	 *
	 * @since  0.0.1
	 * @return array List of fields
	 */
	public function get_fields() : array {

		$fields = array(
			array(
				'key'               => 'field_5a6b02e943e1b',
				'label'             => _x( 'Dates', 'Admin Fields', 'fcg-agenda' ),
				'name'              => 'dates-repeater',
				'type'              => 'repeater',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'min'          => 1,
				'max'          => 0,
				'layout'       => 'row',
				'button_label' => _x( 'Add more dates', 'Admin Fields', 'fcg-agenda' ),
				'sub_fields'   => array(
...
```

Many fields configuration, copied from ACF export.

```php
...					
				),
				'collapsed' => '',
			),
		);

		return $fields;
	}

	/**
	 * Prevent simple meeting points from showing on the location autocomplete field.
	 *
	 * @since  0.0.1
	 *
	 * @param  array $args WP_Query arguments
	 * @return array       WP_Query arguments
	 */
	public function filter_out_meeting_points( array $args ) : array {

		$args['meta_query'] = array(
			array(
				'key'     => 'meeting_point',
				'value'   => '1',
				'compare' => '!='
			),
		);

		$args['post_status'] = 'publish';

		return $args;
	}

	/**
	 * Register filters
	 *
	 * @since  0.0.1
	 * @return void
	 */
	protected function register_hooks() {

		add_filter( 'acf/fields/post_object/query/key=field_5a6b07425441c', [ $this, 'filter_out_meeting_points' ] );
	}
}

```
