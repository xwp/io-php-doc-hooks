<?php
/**
 * Class Doc_Parser_Test.
 *
 * @package XWP\IO\Doc_Hooks
 */

use PHPUnit\Framework\TestCase;
use XWP\IO\Doc_Hooks\Doc_Parser;

/**
 * Test the docblock parser.
 */
class Doc_Parser_Test extends TestCase {

	/**
	 * Can parse valid docblock.
	 *
	 * @return void
	 */
	public function test_can_parse_valid_docblock() {
		$docblock = '
			/**
			 * Method description.
			 *
			 * @filter body_class, 99, 1
			 *
			 * @return bool
			 */
		';

		$parser = new Doc_Parser( $docblock );
		$hooks  = $parser->hooks();

		$this->assertArrayHasKey( 0, $hooks );
		$this->assertEquals( 'filter', $hooks[0]->type() );
		$this->assertEquals( 'body_class', $hooks[0]->name() );
		$this->assertEquals( 99, $hooks[0]->priority() );
	}

	/**
	 * Can skip unrelated dockblock.
	 *
	 * @return void
	 */
	public function test_can_skip_unrelated_docblock() {
		$docblock = '
			/**
			 * Method description
			 *
			 * @see https://xwp.co
			 */
		';

		$parser = new Doc_Parser( $docblock );
		$hooks  = $parser->hooks();

		$this->assertEmpty( $hooks );
		$this->assertTrue( is_array( $hooks ) );
	}

}
