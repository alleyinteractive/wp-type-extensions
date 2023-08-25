<?php
/**
 * Default_Post_Queries class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

use Alley\WP\Types\Post_Queries;
use Alley\WP\Types\Post_Query;
use WP_Query;
use WP_Term;

/**
 * Queries implementation for most cases.
 */
final class Default_Post_Queries implements Post_Queries {
	/**
	 * Query for posts using literal arguments.
	 *
	 * @param array $args The arguments to be used in the query.
	 * @return Post_Query
	 */
	public function post_query_for_args( array $args ): Post_Query {
		return new Origin_Post_Query( new WP_Query( $args ) );
	}

	/**
	 * Query for posts in a term.
	 *
	 * @param int   $term_id The term ID to be queried.
	 * @param array $args    The arguments to be used in the query.
	 * @return Post_Query
	 */
	public function post_query_for_term( int $term_id, array $args ): Post_Query {
		$term = get_term( $term_id );

		if ( $term instanceof WP_Term ) {
			if ( ! isset( $args['tax_query'] ) || ! is_array( $args['tax_query'] ) ) {
				$args['tax_query'] = [];
			}

			$args['tax_query']['relation'] = 'AND';
			$args['tax_query'][]           = [
				[
					'taxonomy' => $term->taxonomy,
					'field'    => 'term_id',
					'terms'    => $term->term_id,
				],
			];
		}

		return $this->post_query_for_args( $args );
	}
}
