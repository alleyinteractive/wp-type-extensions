<?php
/**
 * Each_Replaced_Blocks class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Alley\WP\Types\Block_Sequence;
use Alley\WP\Types\Serialized_Blocks;

/**
 * Replace each matched blocks with other block content.
 */
final class Each_Replaced_Blocks implements Block_Sequence {
	/**
	 * Set up.
	 *
	 * @param Serialized_Blocks $find    Blocks to find.
	 * @param Serialized_Blocks $replace Replacement for each found block.
	 * @param Serialized_Blocks $origin  Blocks to search.
	 */
	public function __construct(
		private readonly Serialized_Blocks $find,
		private readonly Serialized_Blocks $replace,
		private readonly Serialized_Blocks $origin,
	) {}

	/**
	 * Serialized block content.
	 *
	 * @return string
	 */
	public function serialized_blocks(): string {
		$out = $this->origin->serialized_blocks();

		$parsed_blocks = parse_blocks( $this->find->serialized_blocks() );

		if ( is_array( $parsed_blocks ) ) {
			foreach ( $parsed_blocks as $find ) {
				if ( is_array( $find ) && count( $find ) > 0 ) {
					$parsed = new Parsed_Block( $find );
					$out    = str_replace( $parsed->serialized_blocks(), $this->replace->serialized_blocks(), $out );
				}
			}
		}

		return $out;
	}
}
