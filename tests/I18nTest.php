<?php

use PHPUnit\Framework\TestCase;
use csrui\WPConstruct\Plugin\App;
use csrui\WPConstruct\Plugin\I18n;

class I18nTest extends TestCase {

	public function testSimpleDomain() {

		$class = new I18n( 'banana-domain' );
		$this->assertEquals( $class->get_domain(), 'banana-domain' );
	}

	public function testDomain() {

		$stub  = $this->getMockForAbstractClass( App::class, ['teste', 'banana'] );
		$class = $stub->load( I18n::class, 'banana-domain' );

		$this->assertEquals( $class->get_domain(), 'banana-domain' );
	}
}
