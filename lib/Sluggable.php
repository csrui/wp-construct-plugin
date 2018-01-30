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
 * @author     Gulbenkian <devdigital@csrui.pt>
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

	abstract public function get_slug();

	protected function get_auto_slug() : string {

		if ( empty( $this->slug ) ) {
			$this->slug = strtolower( ( new \ReflectionClass( $this ) )->getShortName() );
		}

		return $this->slug;
	}
}
