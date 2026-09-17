<?php
/**
 * A trivial test to confirm PHPUnit + WordPress test scaffold are wired correctly.
 *
 * @package MinimizeAdminBar
 */

class Test_Sanity extends WP_UnitTestCase {

	/**
	 * If this passes, PHPUnit is loading WordPress correctly.
	 */
	public function test_wordpress_loaded() {
		$this->assertTrue( function_exists( 'get_user_meta' ) );
	}

	/**
	 * If this passes, our plugin file loaded correctly and the class exists.
	 */
	public function test_plugin_class_exists() {
		$this->assertTrue( class_exists( 'Minimize_AdminBar' ) );
	}
}
