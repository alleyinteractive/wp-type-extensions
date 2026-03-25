<?php
/**
 * MergeFilterTest class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Tests\Unit;

use Alley\WP\Filter_Value\Merge_Filter;
use Mantle\Testkit\Test_Case;

/**
 * Tests for Merge_Filter.
 */
final class MergeFilterTest extends Test_Case {
	/**
	 * Test that an array value is merged.
	 */
	public function test_merges_array() {
		add_filter( 'alley_test_merge_filter', new Merge_Filter( [ 'b' => 2 ] ) );

		$actual = apply_filters( 'alley_test_merge_filter', [ 'a' => 1 ] );

		$this->assertSame(
			[
				'a' => 1,
				'b' => 2,
			],
			$actual
		);
	}

	/**
	 * Test that merge keys overwrite existing keys.
	 */
	public function test_merge_overwrites_existing_keys() {
		add_filter( 'alley_test_merge_filter_overwrite', new Merge_Filter( [ 'a' => 99 ] ) );

		$actual = apply_filters( 'alley_test_merge_filter_overwrite', [ 'a' => 1 ] );

		$this->assertSame( [ 'a' => 99 ], $actual );
	}

	/**
	 * Test that a non-array value is returned unchanged.
	 */
	public function test_non_array_value_unchanged() {
		add_filter( 'alley_test_merge_filter_non_array', new Merge_Filter( [ 'a' => 1 ] ) );

		$actual = apply_filters( 'alley_test_merge_filter_non_array', 'string' );
		$this->assertSame( 'string', $actual );

		$actual = apply_filters( 'alley_test_merge_filter_non_array', null );
		$this->assertNull( $actual );
	}
}
