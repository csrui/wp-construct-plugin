<?php

namespace csrui\WPConstruct\Plugin\ContentType;

use csrui\WPConstruct\Plugin\Registerable;

/**
 * Taxonomy handler.
 *
 * @since      0.0.1
 * @package    FCG
 * @subpackage Content/lib
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
abstract class Taxonomy implements Registerable {

	/**
	 * The taxonomy slug.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    string
	 */
	protected $slug;

	/**
	 * A list of post_types associated with the custom taxonomy.
	 *
	 * @since  1.1.0
	 * @access protected
	 * @var    array
	 */
	protected $post_types = [];

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 0.0.1
	 * @param string $slug   The taxonomy slug.
	 */
	public function __construct( $slug = null, array $post_types = [] ) {

		$this->slug       = $slug;
		$this->post_types = $post_types;
	}

	/**
	 * Returns the post type slug
	 *
	 * If none was provided at first, it is infered from class name
	 *
	 * @since  0.0.1
	 * @return string string
	 */
	final public function get_slug() : string {

		if ( empty( $this->slug ) ) {
			$this->slug = strtolower( ( new \ReflectionClass( $this ) )->getShortName() );
		}

		return $this->slug;
	}

	/**
	 * Register custom taxonomy.
	 *
	 * @since 0.0.1
	 */
	abstract public function register();

	/**
	 * Register hooks.
	 *
	 * @since 0.0.1
	 */
	abstract public function register_hooks();
}
