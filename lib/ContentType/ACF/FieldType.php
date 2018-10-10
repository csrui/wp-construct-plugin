<?php

namespace csrui\WPConstruct\Plugin\ContentType\ACF;

use csrui\WPConstruct\Plugin\Registerable;

/**
 * ACF Custom Field Type.
 *
 * @since      0.0.2
 * @package    WPPlugin
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
abstract class FieldType extends \acf_field {

	/**
	 * Define the configuration options.
	 *
	 * Should return an array with the folowing
	 *
	 * return [
	 *  'name'     => 'FIELD_NAME',
	 *  'label'    => __( 'FIELD_LABEL', 'TEXTDOMAIN' ),
	 *  'category' => 'basic',
	 *  'defaults' => [],
	 *  'l10n'     => [],
	 *  'settings' => [],
	 * ];
	 *
	 * @since  0.0.2
	 * @return array List of properties
	 */
	abstract protected function get_config() : array;

	/**
	 * Constructor
	 *
	 * Sets the configuration properties for parent object constructor.
	 *
	 * @since 0.0.2
	 */
	public function __construct() {

		$config = $this->get_config();

		$this->name     = $config['name'] ?? 'FIELD_NAME';
		$this->label    = $config['label'] ?? __( 'FIELD_LABEL', 'TEXTDOMAIN' );
		$this->category = $config['category'] ?? 'basic';
		$this->defaults = $config['defaults'] ?? [];
		$this->l10n     = $config['l18n'] ?? [];
		$this->settings = $config['settings'] ?? [];

		parent::__construct();
	}
}
