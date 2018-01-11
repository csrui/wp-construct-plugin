<?php

namespace csrui\WPConstruct\Plugin\ContentType;

use csrui\WPConstruct\Plugin\Registerable;

/**
 * Post type handler.
 *
 * @since      0.0.1
 * @package    FCG
 * @subpackage Content/lib
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
abstract class PostType implements Registerable {

	/**
	 * The custom post type slug.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var string
	 */
	protected $slug;

	/**
	 * A list of taxonomies associated with the custom post type.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var array
	 */
	protected $taxonomies = [];

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 0.0.1
	 * @param string $slug       The post type slug.
	 * @param array  $taxonomies A list of taxonomies associated with the post type.
	 */
	public function __construct( $slug = null, array $taxonomies = [] ) {
		$this->slug       = $slug;
		$this->taxonomies = $taxonomies;
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
	 * Return the list of taxonomies associated with post type.
	 *
	 * @since  0.0.1
	 * @return array List of taxonomies
	 */
	public function get_taxonomies() : array {
		return $this->taxonomies;
	}

	/**
	 * Register custom post type.
	 *
	 * @since 0.0.1
	 */
	public function register() {

		$slug = $this->get_slug();
		if ( post_type_exists( $slug ) ) {
			throw new \Exception( "Post Type `{$slug}` already exists." );
		}
		register_post_type( $slug, $this->get_args() );

		$this->register_hooks();
	}

	/**
	 * Default register_post_type arguments.
	 *
	 * @since 0.0.1
	 */
	abstract public function get_args();

	/**
	 * Register hooks.
	 *
	 * @since 0.0.1
	 */
	abstract protected function register_hooks();
}
