<?php
/**
 * Group class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Features;

use Alley\WP\Types\Feature;
use Alley\WP\Types\Features;

/**
 * Group many features.
 */
final class Group implements Features {
	/**
	 * Collected features.
	 *
	 * @var Feature[]
	 */
	private array $features;

	/**
	 * Set up.
	 *
	 * @param Feature ...$features Features.
	 */
	public function __construct( Feature ...$features ) {
		$this->features = $features;
	}

	/**
	 * Boot the feature.
	 */
	public function boot(): void {
		foreach ( $this->features as $feature ) {
			$feature->boot();
		}
	}

	/**
	 * Include features.
	 *
	 * @param Feature ...$features Features to include.
	 */
	public function include( Feature ...$features ): void {
		array_push( $this->features, ...$features );
	}

	/**
	 * Include a conditional feature.
	 *
	 * @param bool|callable $when The condition to check.
	 * @param Feature       $then The feature to boot if the condition is met.
	 * @return void
	 */
	public function when( bool|callable $when, Feature $then ): void {
		$this->include( new Effect( $when, $then ) );
	}
}
