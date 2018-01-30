<?php

namespace csrui\WPConstruct\Plugin\ContentType;

use csrui\WPConstruct\Plugin\Registerable;
use csrui\WPConstruct\Plugin\Sluggable;

/**
 * Post type handler.
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
abstract class PostType implements Registerable {

	use Sluggable;

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
	 * @param array  $taxonomies A list of taxonomies associated with the post type.
	 */
	public function __construct( array $taxonomies = [] ) {
		$this->taxonomies = $taxonomies;
	}

	/**
	 * Returns the post type slug
	 *
	 * Can be overriden on extending class for custom slug
	 *
	 * @since  0.0.1
	 * @return string string
	 */
	public function get_slug() : string {

		return $this->get_auto_slug();
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

		if ( method_exists( $this, 'register_hooks' ) ) {

			$this->register_hooks();
		}
	}

	/**
	 * Default register_post_type arguments.
	 *
	 * @since 0.0.1
	 */
	abstract protected function get_args() : array;

}
