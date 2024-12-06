<?php
/**
 * GroupTest class file.
 *
 * @package wp-type-extensions
 *
 * phpcs:disable Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.Security.ValidatedSanitizedInput
 */

namespace Alley\WP\Tests\Feature\Features;

use Mantle\Testkit\Test_Case;
use Alley\WP\Features\Group;
use Alley\WP\Features\Quick_Feature;
use Alley\WP\Types\Feature;

/**
 * Tests for Group class.
 */
class GroupTest extends Test_Case {
	/**
	 * Test that group can boot a set of features.
	 */
	public function test_it_can_boot_a_group_of_features(): void {
		$_SERVER['booted_quick_feature']   = false;
		$_SERVER['booted_feature']         = false;
		$_SERVER['booted_group_of_groups'] = false;
		$_SERVER['included_feature']       = false;

		$group = new Group(
			new Quick_Feature( fn () => $_SERVER['booted_quick_feature'] = true ),
			new class() implements Feature {
				/**
				 * Boot the feature.
				 */
				public function boot(): void {
					$_SERVER['booted_feature'] = true;
				}
			},
			new Group(
				new Quick_Feature( fn () => $_SERVER['booted_group_of_groups'] = true ),
			),
		);

		$group->include(
			new Quick_Feature( fn () => $_SERVER['included_feature'] = true ),
		);

		$group->boot();

		$this->assertTrue( $_SERVER['booted_feature'] );
		$this->assertTrue( $_SERVER['booted_quick_feature'] );
		$this->assertTrue( $_SERVER['booted_group_of_groups'] );
		$this->assertTrue( $_SERVER['included_feature'] );
	}
}
