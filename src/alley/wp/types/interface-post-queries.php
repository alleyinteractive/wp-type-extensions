<?php
/**
 * Post_Queries interface file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Types;

/**
 * Describes objects that can perform common queries for posts.
 */
interface Post_Queries {
	/**
	 * Query for posts using literal arguments.
	 *
	 * @param array<string, mixed> $args Query arguments.
	 * @return Post_Query
	 */
	public function post_query_for_args( array $args ): Post_Query;

	/**
	 * Query for posts in a term.
	 *
	 * @param int                  $term_id The term ID to be queried.
	 * @param array<string, mixed> $args    Query arguments.
	 * @return Post_Query
	 */
	public function post_query_for_term( int $term_id, array $args ): Post_Query;
}
