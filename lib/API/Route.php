<?php

namespace csrui\WPConstruct\Plugin\API;

/**
 * Create an API route.
 *
 * @since      0.0.1
 * @package    Gulbenkian
 * @author     Rui Sardinha <mail@ruisardinha.com>
 */
class Route {

	/**
	 * Route endpoint.
	 *
	 * @since 0.0.0
	 * @var   string
	 */
	private $endpoint;

	/**
	 * HTTP Method
	 *
	 * @since 0.0.0
	 * @var   string
	 */
	private $method;

	/**
	 * Callback to fire.
	 *
	 * @since 0.0.0
	 * @var   array
	 */
	private $callback;

	/**
	 * Callback to get arguments.
	 * 
	 * @since 0.0.0
	 * @var   array
	 */
	private $args = [];

	/**
	 * Route configuration.
	 *
	 * @since 0.0.1
	 * @param string $endpoint Route endpoint.
	 * @param string $method   HTTP Method.
	 * @param array  $callback Callback that responsed to endpoint.
	 */
	public function __construct( string $endpoint, string $method, array $callback, array $args = [] ) {

		$this->endpoint = $endpoint;
		$this->method   = $method;
		$this->callback = $callback;
		$this->args     = $args;
	}

	/**
	 * Returns API endpoint.
	 *
	 * @since  0.0.0
	 * @return string
	 */
	public function endpoint() : string {
		return $this->endpoint;
	}

	/**
	 * Returns HTTP Method.
	 *
	 * @since  0.0.0
	 * @return string
	 */
	public function method() : string {
		return $this->method;
	}

	/**
	 * Returns the callback.
	 *
	 * @since  0.0.0
	 * @return array
	 */
	public function callback() : array {
		return $this->callback;
	}

	/**
	 * Returns the arguments.
	 *
	 * @since  0.0.0
	 * @return array
	 */
	public function args() : array {
		return $this->args;
	}
}
