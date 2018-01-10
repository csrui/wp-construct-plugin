# Activation Actions

Sometimes you may need to perform actions when the plugin is activated or even deactivated,
like cleaning some cache or ensuring some files exist.

Here is an example on how to verify if a file exists

```php
namespace FCG\Agenda;

use csrui\WPConstruct\Plugin\Activator as WPCActivator;

class Activator implements WPCActivator {

    public static function activate() {

        if ( file_exists( 'README.md' ) !== true ) {
            throw new \Exception( 'Oops' );
        }

        // Do something awesome
    }

    public static function deactivate() {}
}
```