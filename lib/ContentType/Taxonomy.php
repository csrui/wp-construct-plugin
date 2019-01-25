<?php

namespace csrui\WPConstruct\Plugin\ContentType;

use csrui\WPConstruct\Plugin\Registerable;
use csrui\WPConstruct\Plugin\Sluggable;

/**
 * Taxonomy handler.
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
abstract class Taxonomy implements Registerable {

	use Sluggable;

	/**
	 * A list of post_types associated with the custom taxonomy.
	 *
	 * @since  1.1.0
	 * @access protected
	 * @var    array
	 */
	protected $post_types = [];

	/**
	 * Taxonomy slug.
	 *
	 * @var string
	 */
	protected $slug = null;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 0.0.1
	 * @param string $slug       Taxonomy slug.
	 * @param array  $post_types A list of post types associated with the taxonomy.
	 */
	public function __construct( array $post_types = [], string $slug = '' ) {

		$this->post_types = $post_types;
		$this->slug       = $slug;
	}

	/**
	 * Returns the taxonomy slug
	 *
	 * Can be overriden on extending class for custom slug
	 *
	 * @since  0.0.1
	 * @return string string
	 */
	public function get_slug() : string {

		if ( ! empty( $this->slug ) ) {
			return $this->slug;
		}

		return $this->get_auto_slug();
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
