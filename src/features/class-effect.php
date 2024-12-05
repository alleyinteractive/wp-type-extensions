<?php
/**
 * Effect class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Features;

use Alley\WP\Types\Feature;

/**
 * Boot a feature as an effect of a condition being true.
 */
final class Effect implements Feature {
	/**
	 * The condition to check.
	 *
	 * @var callable
	 */
	private $when;

	/**
	 * Constructor.
	 *
	 * @param bool|callable $when The condition to check.
	 * @param Feature       $then The feature to boot if the condition is met.
	 */
	public function __construct(
		bool|callable $when,
		private readonly Feature $then,
	) {
		$this->when = $when;
	}

	/**
	 * Boot the feature.
	 */
	public function boot(): void {
		if ( is_bool( $this->when ) && $this->when === true ) {
			$this->then->boot();
		} elseif ( ( $this->when )() === true ) {
			$this->then->boot();
		}
	}
}
