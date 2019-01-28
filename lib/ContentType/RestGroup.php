<?php

namespace csrui\WPConstruct\Plugin\ContentType;

/**
 * Interface for Group implementing Rest
 *
 * @since      0.0.2
 * @package    WPPlugin
 * @author     Luiz Calderaro <lzcalderaro@gmail.com>
 */
interface RestGroup extends RestFields {

	/**
	 * Return a group fields.
	 *
	 * @since  0.0.2
	 * @var    int with post ID.
	 * @return array Array of strings
	 */
	public function get_rest_group( int $post_id ) : array;

	/**
	 * Return a group fields title.
	 *
	 * @since  0.0.2
	 * @return string with group name
	 */
	public function get_rest_group_title() : string;
}
