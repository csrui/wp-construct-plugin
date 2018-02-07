<?php

namespace csrui\WPConstruct\Plugin\Command;

use WP_CLI_Command;
use WP_CLI;

class Banana extends WP_CLI_Command {

	public function go_nuts() {

		echo 'go nuts dude!';
	}
}
