<?php

namespace csrui\WPConstruct\Plugin;

use csrui\WPConstruct\Plugin\Registerable;

/**
 * Abstract class to handle scripts enqueueing
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
abstract class Assets implements Registerable {

	/**
	 * Overloadable method to register frontend scripts
	 *
	 * @since 0.0.1
	 */
	abstract public function enqueue();

	/**
	 * Overloadable method to register admin scripts
	 *
	 * @since 0.0.1
	 */
	abstract public function admin_enqueue();

	/**
	 * Handles registering callbacks
	 *
	 * @since  0.0.1
	 * @return void
	 */
	final public function register() {
		add_action( 'wp_enqueue_scripts', function () {
			$this->enqueue();
		});

		add_action( 'admin_enqueue_scripts', function () {
			$this->admin_enqueue();
		});
	}
}
