<?php
/**
 * Recorded_Queries class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Post_Queries;

use Alley\WP\Post_IDs\Used_Post_IDs;
use Alley\WP\Types\Post_Queries;
use Alley\WP\Types\Post_Query;

/**
 * Record the post IDs returned by each query.
 */
final class Recorded_Queries implements Post_Queries {
	/**
	 * Set up.
	 *
	 * @param Used_Post_IDs $history Used post IDs.
	 * @param Post_Queries  $origin  Post_Queries object.
	 */
	public function __construct(
		private readonly Used_Post_IDs $history,
		private readonly Post_Queries $origin,
	) {}

	/**
	 * Query for posts using literal arguments.
	 *
	 * @param array<string, mixed> $args The arguments to be used in the query.
	 * @return Post_Query
	 */
	public function query( array $args ): Post_Query {
		$out = $this->origin->query( $args );
		$this->history->record( $out->post_ids() );
		return $out;
	}
}

