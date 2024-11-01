<?php
/**
 * BlockContentTest class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Tests\Unit;

use Alley\WP\Blocks\Block_Content;
use Mantle\Testkit\Test_Case;

/**
 * Tests for Block_Content.
 */
final class BlockContentTest extends Test_Case {
	/**
	 * Test blocks of block content.
	 */
	public function test_content() {
		$expected = '<!-- wp:foo/bar /--><!-- wp:foo/baz /--><!-- wp:foo/bat /-->';
		$actual   = new Block_Content( $expected );

		$this->assertSame( $expected, $actual->serialized_blocks() );
	}
}
