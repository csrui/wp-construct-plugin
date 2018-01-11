# Content Types

Registering content types with your WordPress plugin.

Let's look at the 3 types of content.

* [Creating Post Types](part4/README.md#creating-post-types)
* [Creating Taxonomies](part4/README.md#creating-taxonomies)
* [Creating Meta Fields](part4/README.md#creating-meta-fields)

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

    public function get_args() {

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

    protected function register_hooks() {}

}
```
