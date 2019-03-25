<?php

use PHPUnit\Framework\TestCase;
use csrui\WPConstruct\Plugin\App;

class PluginTest extends TestCase {

	public function testIdentification() {

		$stub = $this->getMockForAbstractClass( App::class, [ 'WPPlugin', '0.0.1' ] );
		$this->assertTrue( $stub->get_version() === '0.0.1' );
		$this->assertTrue( $stub->get_plugin_name() === 'WPPlugin' );
	}
}
