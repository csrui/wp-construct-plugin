# External Usage

There might be times when we need to access data from the plugin.

Here's how we can call the already instantiated plugin using the
PluginFactory class;

```php
use FCG\Agenda\PluginFactory;

$agenda_plugin = PluginFactory::create();

printf( 'my name is %s', $agenda_plugin->get_plugin_name() );

$agenda_plugin->is_awesome();
```

Of course there's no *is_awesome()* method but this gives you the general idea.

## Using a specific class

Let's call a specific class used by the plugin.

```php
$event_post_type = $agenda_plugin->load_class( 'Gulbenkian\WP\Plugin\FcgEventsCalendar\PostType\Event' );

$event_post_type->go_do_ma_thang();
```

Let's say that I need to known the custom slug of the Event post type.

```php
$event_post_type = $agenda_plugin->load_class( 'Gulbenkian\WP\Plugin\FcgEventsCalendar\PostType\Event' );

$event_post_type->get_slug();
```
