<?php

namespace csrui\WPConstruct\Plugin\Command;

use WP_CLI_Command;
use WP_CLI;

/**
 * Generator
 *
 * @since      0.0.0
 * @package    WPPlugin
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
class Generator extends WP_CLI_Command {

	public function gen_acf_id() {

		echo substr( md5(), 0, 14 );
	}
}
