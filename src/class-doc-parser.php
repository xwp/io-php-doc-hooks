<?php
/**
 * Class Doc_Parser.
 *
 * @package XWP\IO\Doc_Hooks
 */

namespace XWP\IO\Doc_Hooks;

/**
 * Parse and collect actions and filters found in docblock comments.
 */
class Doc_Parser {

	/**
	 * Docblock string.
	 *
	 * @var string
	 */
	protected $doc;

	/**
	 * List of hooks discovered in the docblock.
	 *
	 * @var array|null
	 */
	protected $hooks;

	/**
	 * Setup the docblock parser.
	 *
	 * @param string $doc Docblock string to parse.
	 */
	public function __construct( $doc ) {
		$this->doc = $doc;
	}

	/**
	 * Return a list of all hooks found in the docblock.
	 *
	 * @return Hook[]
	 */
	public function hooks() {
		if ( ! isset( $this->hooks ) ) {
			preg_match_all(
				'#\* @(?P<type>filter|action)\s+(?P<name>[a-z0-9\-\._/=]+)(?:,\s+(?P<priority>\-?[0-9]+))?#',
				$this->doc,
				$matches,
				PREG_SET_ORDER
			);

			$this->hooks = array();

			foreach ( $matches as $match ) {
				$match = array_merge(
					array(
						'type'     => null,
						'name'     => null,
						'priority' => null,
					),
					$match
				);

				// Add only valid hooks.
				if ( ! empty( $match['type'] ) && ! empty( $match['name'] ) ) {
					$this->hooks[] = new Hook( $match['type'], $match['name'], $match['priority'] );
				}
			}
		}

		return $this->hooks;
	}

}
