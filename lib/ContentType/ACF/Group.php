<?php

namespace csrui\WPConstruct\Plugin\ContentType\ACF;

use csrui\WPConstruct\Plugin\Registerable;

/**
 * ACF Field group handler.
 *
 * @since      0.0.2
 * @package    WPPlugin
 * @author     Gulbenkian <devdigital@csrui.pt>
 */
abstract class Group implements Registerable {

	/**
	 * The custom group key.
	 *
	 * @since  0.0.2
	 * @access protected
	 * @var string
	 */
	protected $key;

	/**
	 * Group default configuration container
	 *
	 * @since 0.0.2
	 * @var   array;
	 */
	protected $default_group_args = [
		'title'                 => 'Default title',
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'active'                => 1,
		'description'           => '',
		'hide_on_screen'        => '',
	];

	/**
	 * Group configuration container
	 *
	 * @since 0.0.2
	 * @var   array;
	 */
	protected $group_args;

	/**
	 * Returns the group key
	 *
	 * @since  0.0.2
	 * @return string The group key
	 */
	final public function get_key() : string {

		return $this->key;
	}

	/**
	 * Sets the group location
	 *
	 * @since  0.0.2
	 * @return array ACF compatible sintax for location
	 */
	private function get_location() : array {
		$location = [];
		$values   = $this->get_locations();

		foreach ( $values as $value ) {
			$location[] = array(
				array(
					'param'    => $param,
					'operator' => '==',
					'value'    => $value,
				)
			);
		}
		return $location;
	}

	public function __construct( array $group_args = [] ) {

		$this->group_args = array_merge( $this->default_group_args, $group_args );
	}

	/**
	 * Register custom post type.
	 *
	 * @since 0.0.2
	 */
	public function register() {

		if ( function_exists( '\acf_add_local_field_group' ) === false ) {
			return;
		}

		$group_args = array_merge( $this->group_args, [
			'key'      => $this->get_key(),
			'fields'   => $this->get_fields(),
			'location' => $this->get_location(),
		] );

		acf_add_local_field_group( $group_args );
	}

	/**
	 * acf_add_local_field_group fields arguments.
	 *
	 * @since  0.0.2
	 * @return array List of arguments supported by ACF.
	 */
	abstract protected function get_fields() : array;

	/**
	 * acf_add_local_field_group location fields arguments
	 *
	 * @since  0.0.2
	 * @return array List of arguments supported by ACF.
	 */
	abstract protected function get_locations() : array;

}
