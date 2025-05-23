<?php
/**
 * Features interface file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Types;

/**
 * Describes multiple features.
 */
interface Features extends Feature {
	/**
	 * Include a feature.
	 *
	 * @param Feature $feature Feature to include.
	 */
	public function include( Feature $feature ): void;
}
