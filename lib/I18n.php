<?php

namespace csrui\WPConstruct\Plugin;

use csrui\WPConstruct\Plugin\Registerable;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
class I18n implements Registerable {

	/**
	 * The domain specified for this plugin.
	 *
	 * @since  0.0.1
	 * @access private
	 * @var    string $domain The domain identifier for this plugin.
	 */
	private $domain;

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @since 0.0.1
	 * @param string $domain The domain that represents the locale of this plugin.
	 */
	public function __construct( string $domain ) {
		$this->domain = $domain;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 0.0.1
	 */
	public function register() {

		load_plugin_textdomain(
			$this->domain,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

	/**
	 * Return the domain name
	 *
	 * @since  0.0.1
	 * @return string Domain name
	 */
	public function get_domain() : string {
		return $this->domain;
	}
}
