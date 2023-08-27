<?php
/**
 * DefaultClassnameWrapperBlockTest class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Mantle\Testkit\Test_Case;

/**
 * Tests for Default_Classname_Wrapper_Block.
 */
class DefaultClassnameWrapperBlockTest extends Test_Case {
	/**
	 * Test that wrapper is added.
	 */
	public function test_wrapper() {
		$actual = new Default_Classname_Wrapper_Block(
			'div',
			new Named_Block( block_name: 'foo/bar', inner_html: 'Hello, world!' ),
		);

		$this->assertSame(
			'<!-- wp:foo/bar --><div class="wp-block-foo-bar">Hello, world!</div><!-- /wp:foo/bar -->',
			$actual->serialized_blocks(),
		);
	}
}
