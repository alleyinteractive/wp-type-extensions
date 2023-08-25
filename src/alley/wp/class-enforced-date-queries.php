<?php
/**
 * Enforced_Date_Queries class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Alley\WP\Types\Post_Queries;
use Alley\WP\Types\Post_Query;
use DateTimeInterface;

/**
 * Enforce a date query.
 */
final class Enforced_Date_Queries implements Post_Queries {
	/**
	 * Set up.
	 *
	 * @param DateTimeInterface $after  Date to limit queries to.
	 * @param Post_Queries      $origin Post_Queries object.
	 */
	public function __construct(
		private DateTimeInterface $after,
		private readonly Post_Queries $origin,
	) {}

	/**
	 * Query for posts using literal arguments.
	 *
	 * @param array $args The arguments to be used in the query.
	 * @return Post_Query
	 */
	public function post_query_for_args( array $args ): Post_Query {
		$with_date_query = $this->with_date_query( $args, $this->after );

		return $this->origin->post_query_for_args( $with_date_query );
	}

	/**
	 * Query for posts in a term.
	 *
	 * @param int   $term_id The term ID to be queried.
	 * @param array $args    The arguments to be used in the query.
	 * @return Post_Query
	 */
	public function post_query_for_term( int $term_id, array $args ): Post_Query {
		$with_date_query = $this->with_date_query( $args, $this->after );

		return $this->origin->post_query_for_term( $term_id, $with_date_query );
	}

	/**
	 * Add 'after' date query with the given date.
	 *
	 * @param array             $args  Query arguments.
	 * @param DateTimeInterface $after Date instance.
	 * @return array
	 */
	private function with_date_query( array $args, DateTimeInterface $after ): array {
		if ( ! isset( $args['date_query'] ) || ! is_array( $args['date_query'] ) ) {
			$args['date_query'] = [];
		}

		$args['date_query']['relation'] = 'AND';
		$args['date_query'][]           = [
			'after' => [
				'year'  => $after->format( 'Y' ),
				'month' => $after->format( 'n' ),
				'day'   => $after->format( 'j' ),
			],
		];

		return $args;
	}
}
