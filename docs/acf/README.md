# ACF

Let's say we want to implement a new type of field on Advanced Custom Fields.

Below is an implementation of a custom hidden field.

```php
namespace FCG\WP\Plugin\Agenda\ACF\Fields;

use csrui\WPConstruct\Plugin\ContentType\ACF\FieldType;

/**
 * Defines an ACF type of field.
 *
 * @since      0.0.2
 * @package    FCG
 * @subpackage Agenda/lib/ACF/Fields
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
class WeeklySessions extends FieldType {

	/**
	 * ACF Configuration for the field type
	 *
	 * @since  0.0.2
	 * @return array List of parameters for ACF
	 */
	protected function get_config() : array {
		return [
			'name'     => 'weekly_sessions',
			'label'    => _x( 'Weekly Sessions', 'Agenda ACF Field Type', 'fcg-agenda' ),
			'category' => 'basic',
			'defaults' => [],
			'l10n'     => [],
			'settings' => [],
		];
	}

	/**
	 * Render the field's HTML
	 *
	 * @since  0.0.2
	 * @param  array $field $field data from ACF
	 */
	public function render_field( $field ) {

		printf(
			'<input type="hidden" name="%s" id="%s" value="%s" /><div id="js-weekly-sessions" data-field-id="%s">%s</div>',
			esc_attr( $field['name'] ),
			esc_attr( $field['id'] ),
			esc_attr( $field['value'] ),
			esc_attr( $field['id'] ),
			esc_html_x( 'Loading interface...', 'Agenda ACF Field Type', 'fcg-agenda' )
		);
	}
}
```
