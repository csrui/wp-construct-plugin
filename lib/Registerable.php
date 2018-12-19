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
interface Registerable {

	public function register();
}
