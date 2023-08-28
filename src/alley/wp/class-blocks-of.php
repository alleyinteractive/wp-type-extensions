<?php
/**
 * Blocks_Of class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Alley\WP\Types\Block_Sequence;

/**
 * Represents possible inputs as block sequences.
 */
final class Blocks_Of implements Block_Sequence {
	/**
	 * Set up.
	 *
	 * @param callable $final Callable that returns a list of serializable blocks.
	 */
	private function __construct(
		private $final,
	) {}

	/**
	 * Constructor for set of values.
	 *
	 * @param iterable<mixed> $values Values.
	 * @param callable        $reduce Reducer callback that produces block instances.
	 * @return Block_Sequence
	 */
	public static function iterable( // phpcs:ignore Squiz.Commenting.FunctionComment.IncorrectTypeHint
		iterable $values,
		callable $reduce,
	): Block_Sequence {
		return new self(
			function () use ( $values, $reduce ) {
				$carry = [];

				foreach ( $values as $index => $item ) {
					$carry = ( $reduce )( $carry, $item, $index, $values );
				}

				return new Blocks( ...$carry );
			}
		);
	}

	/**
	 * Constructor for block content.
	 *
	 * @param string $content Block content.
	 * @return Block_Sequence
	 */
	public static function block_content( string $content ): Block_Sequence {
		return new self(
			function () use ( $content ) {
				return self::iterable(
					parse_blocks( $content ),
					function ( array $carry, array $block ) {
						$carry[] = new Parsed_Block( $block );
						return $carry;
					}
				);
			},
		);
	}

	/**
	 * Serialized block content.
	 *
	 * @return string
	 */
	public function serialized_blocks(): string {
		return ( $this->final )()->serialized_blocks();
	}
}
