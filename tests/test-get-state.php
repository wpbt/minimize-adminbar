<?php
/**
 * Tests for Minimize_AdminBar::get_state().
 *
 * @package MinimizeAdminBar
 */

class Test_Get_State extends WP_UnitTestCase {

	/**
	 * The plugin instance under test.
	 *
	 * @var Minimize_AdminBar
	 */
	private $plugin;

	/**
	 * Set up a fresh plugin instance before each test.
	 */
	public function setUp(): void {
		parent::setUp();
		$this->plugin = new Minimize_AdminBar();
	}

	/**
	 * A user with no saved meta should get default state.
	 */
	public function test_default_state_for_new_user() {
		$user_id = $this->factory->user->create();
		wp_set_current_user( $user_id );

		$state = $this->invoke_get_state();

		$this->assertFalse( $state['hidden'] );
	}

	/**
	 * A user with previously saved meta should get their saved value.
	 */
	public function test_saved_state_is_returned() {
		$user_id = $this->factory->user->create();
		wp_set_current_user( $user_id );

		update_user_meta( $user_id, '_admin_bar_state', array( 'hidden' => true ) );

		$state = $this->invoke_get_state();

		$this->assertTrue( $state['hidden'] );
	}

	/**
	 * Helper to call the private get_state() method via Reflection,
	 * since PHP doesn't allow calling private methods directly from outside the class.
	 *
	 * @return array
	 */
	private function invoke_get_state() {
		$reflection = new ReflectionMethod( $this->plugin, 'get_state' );
		$reflection->setAccessible( true );
		return $reflection->invoke( $this->plugin );
	}
}
