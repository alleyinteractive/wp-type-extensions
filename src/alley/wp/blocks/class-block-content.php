<?php
/**
 * Block_Content class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Blocks;

use Alley\WP\Types\Block_Sequence;

/**
 * A sequence of blocks in the given content.
 */
final class Block_Content implements Block_Sequence {
	/**
	 * Set up.
	 *
	 * @param string $content Content.
	 */
	public function __construct(
		private readonly string $content,
	) {}

	/**
	 * Serialized block content.
	 *
	 * @return string
	 */
	public function serialized_blocks(): string {
		return $this->content;
	}
}
