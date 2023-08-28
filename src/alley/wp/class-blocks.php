<?php
/**
 * Blocks class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Alley\WP\Types\Block_Sequence;
use Alley\WP\Types\Serialized_Blocks;

/**
 * Multiple blocks.
 */
final class Blocks implements Block_Sequence {
	/**
	 * Blocks in this sequence.
	 *
	 * @var Serialized_Blocks[]
	 */
	private readonly array $blocks;

	/**
	 * Set up.
	 *
	 * @param Serialized_Blocks ...$blocks Blocks.
	 */
	public function __construct( Serialized_Blocks ...$blocks ) {
		$this->blocks = $blocks;
	}

	/**
	 * Serialized block content.
	 *
	 * @return string
	 */
	public function serialized_blocks(): string {
		return array_reduce(
			$this->blocks,
			fn ( string $carry, Serialized_Blocks $block ) => $carry .= $block->serialized_blocks(),
			'',
		);
	}
}
