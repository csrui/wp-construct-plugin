<?php

use PHPUnit\Framework\TestCase;
use csrui\WPConstruct\Plugin\ContentType\ACF\Group;

class SimpleLocationsContent extends Group {

	public function get_locations() : array {
		return [
			[ 'post_type' => 'event' ],
			[ 'post_type' => 'post' ],
		];
	}

	public function get_fields() : array {}
}

class ACFLocationsContent extends Group {

	public function get_locations() : array {
		return [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'event',
				],
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
				],
			],
		];
	}

	public function get_fields() : array {}
}

class GroupTest extends TestCase {

	public function testLocationSimpleFormat() {

		$method = new ReflectionMethod( SimpleLocationsContent::class, 'get_location' );
		$method->setAccessible( true );

		$expected_result = [
			[
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'event',
			],
			[
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'post',
			],
		];

		$this->assertEquals( $expected_result, $method->invoke( new SimpleLocationsContent ) );
	}

	public function testLocationAcfFormat() {

		$method = new ReflectionMethod( ACFLocationsContent::class, 'get_location' );
		$method->setAccessible( true );

		$expected_result = [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'event',
				],
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
				],
			],
		];

		$this->assertEquals( $expected_result, $method->invoke( new ACFLocationsContent ) );
	}

}
