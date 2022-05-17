<?php
/**
 * Class Class_Hooks.
 *
 * @package XWP\IO\Doc_Hooks
 */

namespace XWP\IO\Doc_Hooks;

/**
 * Adds and removes hooks found in method docblocks.
 */
class Class_Hooks {

	/**
	 * Class instance to add the hooks for.
	 *
	 * @var object
	 */
	protected $object;

	/**
	 * Add actions/filters from the methods of a class based on DocBlocks.
	 *
	 * @param object $object The class object.
	 */
	public function __construct( $object ) {
		$this->object = $object;
	}

	/**
	 * Return a list of methods found in the object.
	 *
	 * @return \ReflectionMethod[]
	 */
	protected function methods() {
		static $methods;

		if ( ! isset( $methods ) ) {
			$reflector = new \ReflectionObject( $this->object );
			$methods   = $reflector->getMethods();
		}

		return $methods;
	}

	/**
	 * Add actions and filters to WordPress.
	 */
	public function add() {
		foreach ( $this->methods() as $method ) {
			$parser    = new Doc_Parser( $method->getDocComment() );
			$arg_count = $method->getNumberOfParameters();
			$callback  = array( $this->object, $method->getName() );

			foreach ( $parser->hooks() as $hook ) {
				if ( 'action' === $hook->type() ) {
					add_action( $hook->name, $callback, $hook->priority(), $arg_count );
				} elseif ( 'filter' === $hook->type() ) {
					add_filter( $hook->name, $callback, $hook->priority(), $arg_count );
				}
			}
		}
	}

	/**
	 * Remove actions and filters to WordPress.
	 */
	public function remove() {
		foreach ( $this->methods() as $method ) {
			$parser   = new Doc_Parser( $method->getDocComment() );
			$callback = array( $this->object, $method->getName() );

			foreach ( $parser->hooks() as $hook ) {
				if ( 'action' === $hook->type() ) {
					remove_action( $hook->name, $callback, $hook->priority() );
				} elseif ( 'filter' === $hook->type() ) {
					remove_filter( $hook->name, $callback, $hook->priority() );
				}
			}
		}
	}
}
