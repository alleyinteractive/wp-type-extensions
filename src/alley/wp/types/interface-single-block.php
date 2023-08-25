<?php
/**
 * Single_Block interface file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Types;

/**
 * Describes a single block.
 */
interface Single_Block extends Serialized_Blocks {
	/**
	 * Block name.
	 *
	 * @return string
	 */
	public function block_name(): string;

	/**
	 * Parsed block.
	 *
	 * @return non-empty-array<string, string|array>
	 */
	public function parsed_block(): array;
}
