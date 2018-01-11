<?php

use csrui\WPConstruct\Plugin\App;

class PluginTest extends PHPUnit_Framework_TestCase {

	public function testIdentification() {

		$stub = $this->getMockForAbstractClass( App::class, [ 'WPPlugin', '0.0.1' ] );
		$this->assertTrue( $stub->get_version() === '0.0.1' );
		$this->assertTrue( $stub->get_plugin_name() === 'WPPlugin' );
	}
}
