<?php

namespace csrui\WPConstruct\Plugin\ContentType\ACF;

use csrui\WPConstruct\Plugin\Registerable;

abstract class FieldType extends \acf_field {

	/**
	 * Define the configuration options
	 *
	 * Should return an array with the folowing
	 *
	 * return [
	 *  'name'     => 'FIELD_NAME',
	 *  'label'    => __('FIELD_LABEL', 'TEXTDOMAIN'),
	 *  'category' => 'basic',
	 *  'defaults' => [],
	 *  'l10n'     => [],
	 *  'settings' => [],
	 * ];
	 *
	 */
	abstract protected function get_config() : array;

	public function __construct() {

		$config = $this->get_config();

		$this->name = $config['name'] ?? 'FIELD_NAME';
		$this->label = $config['label'] ?? __('FIELD_LABEL', 'TEXTDOMAIN');
		$this->category = $config['category'] ?? 'basic';
		$this->defaults = $config['defaults'] ?? [];
		$this->l10n = $config['l18n'] ?? [];
		$this->settings = $config['settings'] ?? [];

		parent::__construct();
	}
}
