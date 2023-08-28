<?php
/**
 * Optimistic_Date_Queries class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Alley\WP\Types\Post_Queries;
use Alley\WP\Types\Post_Query;
use DateTimeInterface;

/**
 * Speculate that queries can be limited to posts published after the given dates.
 */
final class Optimistic_Date_Queries implements Post_Queries {
	/**
	 * Set up.
	 *
	 * @param DateTimeInterface[] $after          Dates to try limiting queries to.
	 * @param int                 $posts_per_page Default posts_per_page.
	 * @param Post_Queries        $origin         Post_Queries object.
	 */
	public function __construct(
		private array $after,
		private readonly int $posts_per_page,
		private readonly Post_Queries $origin,
	) {
		// Ensure that dates are newest-to-oldest.
		usort( $this->after, fn ( $a, $b ) => $b <=> $a );
	}

	/**
	 * Query for posts using literal arguments.
	 *
	 * @param array $args The arguments to be used in the query.
	 * @return Post_Query
	 */
	public function post_query_for_args( array $args ): Post_Query {
		$expected_count = (int) ( $args['posts_per_page'] ?? $this->posts_per_page );

		foreach ( $this->after as $after ) {
			$with_date_query = new Enforced_Date_Queries( $after, $this->origin );
			$result          = $with_date_query->post_query_for_args( $args );

			if ( count( $result->post_ids() ) === $expected_count ) {
				return $result;
			}
		}

		return $this->origin->post_query_for_args( $args );
	}
}
