<?php

namespace csrui\WPConstruct\Plugin\Migrations;

/**
 * The core migration class
 *
 * Meant to be extendable by other classes to perform
 * database structure operations using db_delta()
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
abstract class Migration {

	/**
	 * Extendable method to contain the list of queries
	 *
	 * @since  0.0.1
	 * @return void
	 */
	abstract protected function queries() : array;

	/**
	 * Define plugin information
	 *
	 * @since  0.0.1
	 * @param  string $plugin_name    The name of the plugin
	 * @param  string $plugin_version Current version of the plugin
	 * @return void
	 */
	public function __construct( string $plugin_name, string $plugin_version ) {

		$this->plugin_name    = $plugin_name;
		$this->plugin_version = $plugin_version;
	}

	/**
	 * Makes the necessary changes to the Tables
	 *
	 * @since  0.0.1
	 * @return void
	 */
	public function run() {

		if ( ! $this->should_update() ) {
			return;
		}

		require_once trailingslashit( ABSPATH ) . 'wp-admin/includes/upgrade.php';

		$queries = $this->queries();

		if ( empty( $queries ) || ! is_array( $queries ) ) {
			return;
		}

		foreach ( $queries as $query ) {
			dbDelta( $query );
		}

		add_site_option( $this->get_key_name(), $this->plugin_version );
	}

	/**
	 * Returns the current database charset
	 *
	 * @since  0.0.1
	 * @return string
	 */
	protected function get_charset() : string {

		global $wpdb;

		return $wpdb->get_charset_collate();
	}

	/**
	 * Return the table name with prefix
	 *
	 * @since  0.0.1
	 * @param  string $table Name of the table without prefix
	 * @return string
	 */
	protected function get_table_name( string $table = null ) : string {

		global $wpdb;

		$base = $wpdb->base_prefix . $this->plugin_name;

		return empty( $table ) ? $base : $base . '_' . $table;
	}

	/**
	 * Returns the plugin cache key name
	 *
	 * @since  0.0.1
	 * @return string
	 */
	protected function get_key_name() : string {

		return $this->plugin_name . '_db_version';
	}

	/**
	 * Check the current version against the installed version for necessary upgrade
	 *
	 * @since  0.0.1
	 * @return bool
	 */
	protected function should_update() : bool {

		return \get_site_option( $this->get_key_name() ) !== $this->plugin_version;
	}
}
