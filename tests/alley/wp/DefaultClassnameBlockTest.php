<?php
/**
 * DefaultClassnameBlockTest class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Alley\WP\Blocks\Default_Classname_Block;
use Alley\WP\Blocks\Named_Block;
use Mantle\Testkit\Test_Case;

/**
 * Tests for Default_Classname_Block.
 */
final class DefaultClassnameBlockTest extends Test_Case {
	/**
	 * Test that wrapper is added.
	 */
	public function test_wrapper() {
		$actual = new Default_Classname_Block(
			'div',
			new Named_Block( block_name: 'foo/bar', inner_html: 'Hello, world!' ),
		);

		$this->assertSame(
			'<!-- wp:foo/bar --><div class="wp-block-foo-bar">Hello, world!</div><!-- /wp:foo/bar -->',
			$actual->serialized_blocks(),
		);
	}
}
