<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       https://bitbucket.org/WPPlugin/WPPlugin-site
 * @since      0.0.1
 *
 * @package    WPPlugin
 */

namespace csrui\WPConstruct\Plugin;

use csrui\WPConstruct\Plugin\Registerable;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
abstract class App implements Registerable {

	use ClassLoader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      string    $name    The string used to uniquely identify this plugin.
	 */
	protected $name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since 0.0.1
	 * @param string $name
	 * @param string $version
	 */
	public function __construct( string $name, string $version ) {
		$this->name    = $name;
		$this->version = $version;
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.0.1
	 * @return    string    The name of the plugin.
	 */
	final public function get_plugin_name() {
		return $this->name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.0.1
	 * @return    string    The version number of the plugin.
	 */
	final public function get_version() {
		return $this->version;
	}

	/**
	 *
	 * @return [type] [description]
	 */
	final public function register() {
		\add_action( 'plugins_loaded', function () {
			$this->run();
		});
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	protected function run() {
		$this->set_locale();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = $this->load( I18n::class, $this->get_plugin_name() );
		$plugin_i18n->register();
	}

}
