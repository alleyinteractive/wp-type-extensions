<?php
/**
 * WidgetFeatureTest class file
 *
 * @package wp-type-extensions
 */

namespace Alley\WP\Tests\Feature;

use Alley\WP\Features\Widget_Feature;
use Alley\WP\Features\Widget_Features;
use Mantle\Testkit\Test_Case;
use WP_Widget;

/**
 * WidgetFeatureTest test case.
 */
class WidgetFeatureTest extends Test_Case {

	public function test_register_a_single_widget_feature(): void {
		global $wp_widget_factory;

		$widget_class = new class extends WP_Widget {
			public function __construct() {
				parent::__construct( 'test_widget', 'Test Widget' );
			}

			public function widget( $args, $instance ): string {
				echo '<div>Test Widget</div>';
				return '';
			}
		};

		$this->assertTrue( class_exists( $widget_class::class ) );
		$this->assertInstanceOf( WP_Widget::class, $widget_class );

		$widget_feature = new Widget_Feature( $widget_class::class );
		$widget_feature->boot();

		// Register widgets.
		do_action( 'widgets_init' );

		$this->assertArrayHasKey( $widget_class::class, $wp_widget_factory->widgets );

		unregister_widget( $widget_class::class );

		$this->assertArrayNotHasKey( $widget_class::class, $wp_widget_factory->widgets );
	}

	/**
	 * This test is similar to the previous one, but it registers multiple widgets.
	 */
	public function test_register_several_widget_features(): void {
		global $wp_widget_factory;

		$widget_class_1 = new class extends WP_Widget {
			public function __construct() {
				parent::__construct( 'test_widget_1', 'Test Widget 1' );
			}

			public function widget( $args, $instance ): string {
				echo '<div>Test Widget 1</div>';
				return '';
			}
		};

		$widget_class_2 = new class extends WP_Widget {
			public function __construct() {
				parent::__construct( 'test_widget_2', 'Test Widget 2' );
			}

			public function widget( $args, $instance ): string {
				echo '<div>Test Widget 2</div>';
				return '';
			}
		};

		$this->assertTrue( class_exists( $widget_class_1::class ) );
		$this->assertTrue( class_exists( $widget_class_2::class ) );
		$this->assertInstanceOf( WP_Widget::class, $widget_class_1 );
		$this->assertInstanceOf( WP_Widget::class, $widget_class_2 );

		$widget_feature = new Widget_Features( $widget_class_1::class );
		$widget_feature->include( $widget_class_2::class );
		$widget_feature->boot();

		// Register widgets.
		do_action( 'widgets_init' );

		$this->assertArrayHasKey( $widget_class_1::class, $wp_widget_factory->widgets );
		$this->assertArrayHasKey( $widget_class_2::class, $wp_widget_factory->widgets );

		unregister_widget( $widget_class_1::class );

		$this->assertArrayNotHasKey( $widget_class_1::class, $wp_widget_factory->widgets );
		$this->assertArrayHasKey( $widget_class_2::class, $wp_widget_factory->widgets );

		unregister_widget( $widget_class_2::class );

		$this->assertArrayNotHasKey( $widget_class_2::class, $wp_widget_factory->widgets );
	}
}
