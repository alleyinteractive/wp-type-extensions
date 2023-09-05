<?php
/**
 * WP_Query_Envelope class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Alley\WP\Types\Post_Query;
use WP_Post;
use WP_Query;

/**
 * Post_Query from an existing query.
 */
final class WP_Query_Envelope implements Post_Query {
	/**
	 * Set up.
	 *
	 * @param WP_Query $query Query object.
	 */
	public function __construct(
		private readonly WP_Query $query,
	) {}

	/**
	 * Query object.
	 *
	 * @return WP_Query
	 */
	public function query_object(): WP_Query {
		return $this->query;
	}

	/**
	 * Found post objects.
	 *
	 * @return WP_Post[]
	 */
	public function post_objects(): array {
		$posts = array_map( 'get_post', $this->post_ids() );
		$posts = array_filter( $posts, fn ( $p ) => $p instanceof WP_Post );

		return $posts;
	}

	/**
	 * Found post IDs.
	 *
	 * @return int[]
	 */
	public function post_ids(): array {
		return $this->to_post_ids( $this->query_object() );
	}

	/**
	 * Get the post IDs from a set of post objects, IDs, ID-parent objects, or a \WP_Query.
	 *
	 * @param array<WP_Post|int|object>|WP_Query $values Post-like objects or IDs, or a query object.
	 * @return int[] Post IDs, if any.
	 */
	private static function to_post_ids( $values ) {
		$ids = [];

		if ( $values instanceof WP_Query ) {
			$ids = self::to_post_ids( (array) $values->posts );
		} elseif ( \is_array( $values ) ) {
			$ids = array_map( [ self::class, 'to_post_id' ], $values );
		}

		if ( $ids ) {
			$ids = array_map( 'intval', $ids );
			$ids = array_filter( $ids );
		}

		return $ids;
	}

	/**
	 * Get the ID from a post object, ID, or ID-parent object.
	 *
	 * @param WP_Post|int|object $value Post-like object or ID.
	 * @return int|null Post ID, or null on failure.
	 */
	private static function to_post_id( $value ): ?int {
		if ( $value instanceof WP_Post ) {
			return (int) $value->ID;
		}

		// fields => 'ids'.
		if ( is_numeric( $value ) ) {
			return (int) $value;
		}

		// fields => 'id=>parent'.
		if ( ( $value instanceof \stdClass ) && isset( $value->ID ) ) {
			return (int) $value->ID;
		}

		return null;
	}
}
