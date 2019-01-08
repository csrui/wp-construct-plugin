<?php

namespace csrui\WPConstruct\Plugin\Command;

use WP_CLI_Command;

/**
 * Generator
 *
 * @since      0.0.0
 * @package    csrui\WPConstruct\Plugin\Command
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
class Generator extends WP_CLI_Command {

	/**
	 * Generate ACF Idenfitier
	 *
	 * @return void
	 */
	public function acf_identifier() {

		WP_CLI::log( 'Your key: ' . uniqid() );
	}
}
