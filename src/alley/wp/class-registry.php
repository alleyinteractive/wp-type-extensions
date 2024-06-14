<?php
/**
 * Registry class file.
 *
 * @package wp-type-extensions
 */

namespace Alley\WP;

/**
 * Registry pattern class.
 */
final class Registry {
	/**
	 * Store all instances of every class.
	 *
	 * @var object[][]
	 */
	private static array $collection = [];

	/**
	 * Add a new instance to the collection.
	 *
	 * @param object $instance The class instance.
	 * @return void
	 */
	public static function add( object $instance ): void {
		if ( class_exists( $instance::class ) ) {
			self::$collection[ $instance::class ] [] = $instance;
		}
	}

	/**
	 * Retrieve all instances of a class.
	 *
	 * @param string $class_name The class name.
	 * @return object[]
	 */
	public static function get( string $class_name ): array {
		if ( ! self::contains( $class_name ) ) {
			return [];
		}

		return self::$collection[ $class_name ];
	}

	/**
	 * Check if a class is registered in the collection.
	 *
	 * @param string $class_name The class name.
	 * @return bool
	 */
	public static function contains( string $class_name ): bool {
		if ( isset( self::$collection[ $class_name ] ) ) {
			return true;
		}

		return false;
	}
}
