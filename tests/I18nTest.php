<?php

use csrui\WPConstruct\Plugin\App;
use csrui\WPConstruct\Plugin\I18n;

class I18nTest extends PHPUnit_Framework_TestCase {

	public function testSimpleDomain() {

		$class = new I18n( 'banana-domain' );
		$this->assertEquals( $class->get_domain(), 'banana-domain' );
	}

	public function testDomain() {

		$stub  = $this->getMockForAbstractClass( App::class, ['teste', 'banana'] );
		$class = $stub->load_class( I18n::class, [ 'banana-domain' ] );

		$this->assertEquals( $class->get_domain(), 'banana-domain' );
	}
}
