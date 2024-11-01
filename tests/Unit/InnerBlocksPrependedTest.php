<?php
/**
 * PrependedInnerBlocksTest class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Tests\Unit;

use Alley\WP\Blocks\Blocks;
use Alley\WP\Blocks\Inner_Blocks_Prepended;
use Alley\WP\Blocks\Named_Block;
use Mantle\Testkit\Test_Case;

/**
 * Tests for Inner_Blocks_Prepended.
 */
final class InnerBlocksPrependedTest extends Test_Case {
	/**
	 * Test adding one inner block.
	 */
	public function test_one() {
		$actual = new Inner_Blocks_Prepended(
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
		$actual = new Inner_Blocks_Prepended(
			new Named_Block( block_name: 'foo/bar', inner_html: 'Bar' ),
			new Inner_Blocks_Prepended(
				new Blocks(
					new Named_Block( block_name: 'foo/baz', inner_html: 'Baz' ),
					new Named_Block( block_name: 'foo/bat', inner_html: 'Bat' ),
				),
				new Named_Block( block_name: 'foo/qux', inner_html: 'Qux' ),
			),
		);

		$this->assertSame(
			<<<HTML
<!-- wp:foo/qux --><!-- wp:foo/bar -->Bar<!-- /wp:foo/bar --><!-- wp:foo/baz -->Baz<!-- /wp:foo/baz --><!-- wp:foo/bat -->Bat<!-- /wp:foo/bat -->Qux<!-- /wp:foo/qux -->
HTML,
			$actual->serialized_blocks(),
		);
	}
}
