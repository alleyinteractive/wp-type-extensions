<?php
/**
 * PushFilterTest class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Tests\Unit;

use Alley\WP\Filter_Value\Push_Filter;
use Mantle\Testkit\Test_Case;

/**
 * Tests for Push_Filter.
 */
final class PushFilterTest extends Test_Case {
	/**
	 * Test that a value is pushed onto an array.
	 */
	public function test_pushes_onto_array() {
		add_filter( 'alley_test_push_filter', new Push_Filter( 'bar' ) );

		$actual = apply_filters( 'alley_test_push_filter', [ 'foo' ] );

		$this->assertSame( [ 'foo', 'bar' ], $actual );
	}

	/**
	 * Test that a non-array value is returned unchanged.
	 */
	public function test_non_array_value_unchanged() {
		add_filter( 'alley_test_push_filter_non_array', new Push_Filter( 'bar' ) );

		$actual = apply_filters( 'alley_test_push_filter_non_array', 'string' );
		$this->assertSame( 'string', $actual );

		$actual = apply_filters( 'alley_test_push_filter_non_array', null );
		$this->assertNull( $actual );
	}
}
