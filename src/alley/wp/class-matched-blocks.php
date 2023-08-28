<?php
/**
 * Matched_Blocks class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Alley\WP\Types\Block_Sequence;
use Alley\WP\Types\Serialized_Blocks;

/**
 * Matched blocks with {@see match_blocks()}.
 */
final class Matched_Blocks implements Block_Sequence {
	/**
	 * Set up.
	 *
	 * @param array<string, mixed> $args   Args for {@see match_blocks()}.
	 * @param Serialized_Blocks    $origin Blocks to search.
	 */
	public function __construct(
		private readonly array $args,
		private readonly Serialized_Blocks $origin,
	) {}

	/**
	 * Serialized block content.
	 *
	 * @return string
	 */
	public function serialized_blocks(): string {
		$matched = match_blocks( $this->origin->serialized_blocks(), $this->args );

		return \is_array( $matched ) ? serialize_blocks( $matched ) : '';
	}
}
