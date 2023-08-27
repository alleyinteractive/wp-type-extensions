<?php
/**
 * PrependedInnerBlocksTest class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Mantle\Testkit\Test_Case;

/**
 * Tests for Prepended_Inner_Blocks.
 */
class PrependedInnerBlocksTest extends Test_Case {
	/**
	 * Test adding one inner block.
	 */
	public function test_one() {
		$actual = new Prepended_Inner_Blocks(
			new Named_Block( block_name: 'foo/bar', inner_html: 'Bar' ),
			new Named_Block( block_name: 'foo/baz', inner_html: 'Baz' ),
		);

		$this->assertSame(
			'<!-- wp:foo/baz --><!-- wp:foo/bar -->Bar<!-- /wp:foo/bar -->Baz<!-- /wp:foo/baz -->',
			$actual->serialized_blocks(),
		);
	}

	/**
	 * Test adding inner blocks with nested calls.
	 */
	public function test_nested() {
		$actual = new Prepended_Inner_Blocks(
			new Named_Block( block_name: 'foo/bar', inner_html: 'Bar' ),
			new Prepended_Inner_Blocks(
				new Named_Block( block_name: 'foo/baz', inner_html: 'Baz' ),
				new Named_Block( block_name: 'foo/qux', inner_html: 'Qux' ),
			),
		);

		$this->assertSame(
			'<!-- wp:foo/qux --><!-- wp:foo/bar -->Bar<!-- /wp:foo/bar --><!-- wp:foo/baz -->Baz<!-- /wp:foo/baz -->Qux<!-- /wp:foo/qux -->',
			$actual->serialized_blocks(),
		);
	}
}
