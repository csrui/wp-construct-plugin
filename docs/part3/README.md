# Migrations

Say you need some custom tables created on your WordPress database.
Using the previous chapter [Activation actions](/part2/README.md) we can
create tables when activating our plugin using pure SQL.

Using the following method will give you out of the box:

* Versioning magic - Only run queries if plugin was updated.
* Automatic prefixing based on plugin name.
* No need to write the word global.

Here's how.

```php
namespace FCG\Agenda\Migrations;

use \csrui\WPConstruct\Plugin\Migrations\Migration;

class EventsTable extends Migration {

    protected function queries() : array {

        $table_name      = $this->get_table_name( 'events' );
        $charset_collate = $this->get_charset();

        return [
            "CREATE TABLE {$table_name} (
                big_field_1 bigint(20) unsigned NOT NULL,
                big_field_2 bigint(20) unsigned NOT NULL,
                UNIQUE KEY (agenda_event_id, agenda_term_id)
            ) {$charset_collate};",
        ];
    }
}
```

Now we can use the an activator to create the necessary database tables
for the plugin.

```php
namespace FCG\Agenda;

use csrui\WPConstruct\Plugin\Activator as WPCActivator;

use FCG\Agenda\Plugin;
use FCG\Agenda\Migrations\AwesomeTable;

class Activator implements WPCActivator {

    public static function activate() {

        $migration = new AwesomeTable( Plugin::NAME, Plugin::VERSION );
        $migration->run();

    }

    public static function deactivate() {}
}
```