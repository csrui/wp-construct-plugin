<?php

namespace csrui\WPConstruct\Plugin;

use csrui\WPConstruct\Plugin\Command\Fixture;
use csrui\WPConstruct\Plugin\Command\Example;

use WP_CLI;

if ( ! class_exists( '\WP_CLI' ) ) {
	return;
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

WP_CLI::add_command( 'fixtures', Fixture::class );
WP_CLI::add_command( 'example', Example::class );
