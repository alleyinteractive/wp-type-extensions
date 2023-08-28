<?php
/**
 * Memoized_Post_Queries class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Alley\WP\Types\Post_Queries;
use Alley\WP\Types\Post_Query;

/**
 * Reuse post queries given the same arguments.
 */
final class Memoized_Post_Queries implements Post_Queries {
	/**
	 * Set up.
	 *
	 * @param Post_Queries $origin Post_Queries object.
	 */
	public function __construct(
		private readonly Post_Queries $origin,
	) {}

	/**
	 * Query for posts using literal arguments.
	 *
	 * @param array $args The arguments to be used in the query.
	 * @return Post_Query
	 */
	public function post_query_for_args( array $args ): Post_Query {
		return once( fn () => $this->origin->post_query_for_args( $args ) );
	}

	/**
	 * Query for posts in a term.
	 *
	 * @param int   $term_id The term ID to be queried.
	 * @param array $args    The arguments to be used in the query.
	 * @return Post_Query
	 */
	public function post_query_for_term( int $term_id, array $args ): Post_Query {
		return once( fn () => $this->origin->post_query_for_term( $term_id, $args ) );
	}
}
