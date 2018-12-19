<?php

namespace csrui\WPConstruct\Plugin;

/**
 * Registerable interface
 *
 * Classes called using factory pattern or proxy should implement the
 * interface Registerable
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
trait Sluggable {

	/**
	 * The slug.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    string
	 */
	protected $slug;

	/**
	 * Overloadable method to define class slug
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	abstract public function get_slug() : string;

	/**
	 * Detect slug name from class name
	 *
	 * @since  0.0.1
	 * @access protected
	 * @return string The name of the class
	 */
	protected function get_auto_slug() : string {

		if ( empty( $this->slug ) ) {
			$this->slug = strtolower( ( new \ReflectionClass( $this ) )->getShortName() );
		}

		return $this->slug;
	}
}
