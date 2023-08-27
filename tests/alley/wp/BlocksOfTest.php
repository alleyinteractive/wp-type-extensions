<?php
/**
 * BlocksOfTest class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Mantle\Testkit\Test_Case;

/**
 * Tests for Blocks_Of.
 */
class BlocksOfTest extends Test_Case {
	/**
	 * Test blocks of iterable.
	 */
	public function test_iterable() {
		$actual = Blocks_Of::iterable(
			[ 'foo/bar', 'foo/baz', 'foo/bat' ],
			function ( array $carry, string $item ) {
				$carry[] = new Named_Block( block_name: $item );

				return $carry;
			}
		);

		$this->assertSame(
			'<!-- wp:foo/bar /--><!-- wp:foo/baz /--><!-- wp:foo/bat /-->',
			$actual->serialized_blocks(),
		);
	}

	/**
	 * Test blocks of block content.
	 */
	public function test_block_content() {
		$expected = '<!-- wp:foo/bar /--><!-- wp:foo/baz /--><!-- wp:foo/bat /-->';
		$actual   = Blocks_Of::block_content( $expected );

		$this->assertSame( $expected, $actual->serialized_blocks() );
	}
}
