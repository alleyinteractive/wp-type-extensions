<?php
/**
 * Deduplicated_Post_Queries class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Alley\WP\Types\Post_Queries;
use Alley\WP\Types\Post_Query;

final class Deduplicated_Post_Queries implements Post_Queries {
	/**
	 * Set up.
	 *
	 * @param Used_Post_IDs $used_post_ids  Used post IDs.
	 * @param int           $posts_per_page Default posts per page.
	 * @param Post_Queries  $origin         Post_Queries object.
	 */
	public function __construct(
		private readonly Used_Post_IDs $used_post_ids,
		private readonly int $posts_per_page,
		private readonly Post_Queries $origin,
	) {}

	/**
	 * Query for posts using literal arguments.
	 *
	 * @param array $args The arguments to be used in the query.
	 * @return Post_Query
	 */
	public function post_query_for_args( array $args ): Post_Query {
		$used_post_ids     = $this->used_post_ids->post_ids();
		$expected_per_page = (int) ( $args['posts_per_page'] ?? $this->posts_per_page );

		// Ask for the number of posts we expect to return, plus the number of posts we've already used.
		$args['posts_per_page'] = $expected_per_page + count( $used_post_ids );
		$overfetched_query      = $this->origin->post_query_for_args( $args );

		// Remove the posts we've already used from the overfetched query.
		$unused_post_ids = array_diff( $overfetched_query->post_ids(), $used_post_ids );

		// Slice the number of posts we expect to return from the overfetched query.
		$per_page_post_ids = array_slice( $unused_post_ids, 0, $expected_per_page );

		// Record the new set of posts as used.
		$this->used_post_ids->record( $per_page_post_ids );

		return new Post_IDs_Query( $per_page_post_ids );
	}
}
