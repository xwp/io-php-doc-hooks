<?php
/**
 * Class Hook.
 *
 * @package XWP\IO\Doc_Hooks
 */

namespace XWP\IO\Doc_Hooks;

/**
 * Represent a WordPress action or filter.
 */
class Hook {

	/**
	 * Hook name.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Hook priority.
	 *
	 * @var integer
	 */
	protected $priority;

	/**
	 * Setup a hook object.
	 *
	 * @param string  $type Hook type: action or filter.
	 * @param string  $name Hook name.
	 * @param integer $priority Hook priority.
	 */
	public function __construct( $type, $name, $priority = 10 ) {
		$this->type     = trim( $type );
		$this->name     = trim( $name );
		$this->priority = intval( $priority );
	}

	/**
	 * Get the hook type - action or filter.
	 *
	 * @return string
	 */
	public function type() {
		if ( 'action' === $this->type ) {
			return 'action';
		}

		return 'filter';
	}

	/**
	 * Hook name.
	 *
	 * @return string
	 */
	public function name() {
		return $this->name;
	}

	/**
	 * Hook priority.
	 *
	 * @return integer
	 */
	public function priority() {
		return $this->priority;
	}

}
