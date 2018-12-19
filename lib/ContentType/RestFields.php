<?php

namespace csrui\WPConstruct\Plugin\ContentType;

/**
 * Interface for Fields implementing Rest
 *
 * @since      0.0.1
 * @package    WPPlugin
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
interface RestFields {

	/**
	 * Return a list of fields
	 *
	 * @since  0.0.1
	 * @return array Array of strings
	 */
	public function get_rest_fields() : array;
}
