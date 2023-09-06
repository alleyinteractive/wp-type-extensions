<?php
/**
 * Recorded_Queries class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Posts;

use Alley\WP\Types\Post_Queries;
use Alley\WP\Types\Post_Query;
use Alley\WP\Used_Post_IDs;

/**
 */
final class Recorded_Queries implements Post_Queries {
	/**
	 * Set up.
	 *
	 * @param Used_Post_IDs $used_post_ids Used post IDs.
	 * @param Post_Queries  $origin        Post_Queries object.
	 */
	public function __construct(
		private readonly Used_Post_IDs $used_post_ids,
		private readonly Post_Queries $origin,
	) {}

	/**
	 * Query for posts using literal arguments.
	 *
	 * @param array<string, mixed> $args The arguments to be used in the query.
	 * @return Post_Query
	 */
	public function post_query_for_args( array $args ): Post_Query {
		$out = $this->origin->post_query_for_args( $args );
		$this->used_post_ids->record( $out->post_ids() );
		return $out;
	}
}
