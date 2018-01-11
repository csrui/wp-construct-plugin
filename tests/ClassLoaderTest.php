<?php

use csrui\WPConstruct\Plugin\App;
use csrui\WPConstruct\Plugin\I18n;

class ClassLoaderTest extends PHPUnit_Framework_TestCase {

	public function testClassLoader() {

		$stub  = $this->getMockForAbstractClass( App::class, ['teste', 'banana'] );
		$class = $stub->load_class( I18n::class, [ 'domain' ] );

		$this->assertInstanceOf( I18n::class, $class );
	}

	public function testClassLoaderSame() {

		$stub   = $this->getMockForAbstractClass( App::class, ['teste', 'banana'] );
		$class1 = $stub->load_class( I18n::class, [ 'domain' ] );
		$class2 = $stub->load_class( I18n::class, [ 'another domain' ] );

		$this->assertNotEquals( $class1, $class2 );
	}

	public function testNonExistentClass() {

		$stub = $this->getMockForAbstractClass( App::class, ['teste', 'banana'] );

		$this->setExpectedException( \ReflectionException::class );
		$class = $stub->load_class( 'bananas' );
	}
}
