# Required Files

After setting up your plugins composer.json file, these are the files you need to create.
Hopefully these will be available using a generator such as yeoman.

## lib/Plugin.php

Reasoning: Contains immutable data.
The plugin version and name do not change throughout the request life cycle.

```php
namespace FCG\Agenda;

/**
 * Definition of the Plugin.
 *
 * Includes name and current version but can contain other
 * immutable information like an api endpoint, etc.
 *
 * @since      0.0.1
 * @package    Gulbenkian
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
final class Plugin {

    const NAME = 'fcg-agenda';

    const VERSION = '0.0.1';

}
```

## lib/PluginFactory.php

Design Pattern : Factory

Reasoning: Having this class allows outside usage by other plugins or themes.

```php
namespace FCG\Agenda;

use Plugin;

/**
 * Plugin Factory
 *
 * This is the main entry point into the plugins assets.
 *
 * @since      0.0.1
 * @package    Gulbenkian
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
final class PluginFactory {

    public static function create() {

        static $app = null;

        if ( null === $app ) {
            $app = new App( Plugin::NAME, Plugin::VERSION );
        }

        return $app;
    }
}
```

## plugin-name.php

Design Pattern : Frontend

Reasoning: Plugin entry point. Fires off the needed hooks

```php
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
```

```php
/**
 * The code that runs during plugin activation.
 * This action is documented in src/Activator.php
 */
if ( is_callable( [ FCG\Agenda\Activator::class, 'activate' ] ) ) {
    \register_activation_hook( __FILE__, [ FCG\Agenda\Activator::class, 'activate' ] );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in src/Activator.php
 */
if ( is_callable( [ FCG\Agenda\Activator::class, 'deactivate' ] ) ) {
    \register_deactivation_hook( __FILE__, [ FCG\Agenda\Activator::class, 'deactivate' ] );
}
```

```php
/**
 * Begins execution of the plugin.
 *
 * @since    0.0.1
 */
\add_action( 'plugins_loaded', function () {
    $plugin = FCG\Agenda\PluginFactory::create();
    $plugin->run();
} );
```

## lib/App.php

Design Pattern : Facade

Reasoning: Handles all internal plugin logic

```php
namespace FCG\Agenda;

use \csrui\WPConstruct\Plugin\App as WPCApp;

class App extends WPCApp {

    public function run() {
        parent::run();

        // Do great things!!!
    }
}
```