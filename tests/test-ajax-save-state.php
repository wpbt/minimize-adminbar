<?php
/**
 * Tests for Minimize_AdminBar::ajax_save_state().
 *
 * @package MinimizeAdminBar
 *
 * @group ajax
 */

class Test_Ajax_Save_State extends WP_Ajax_UnitTestCase {

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
	 * A logged-in user's save should persist to their own user meta.
	 */
	public function test_save_persists_to_user_meta() {
		$user_id = $this->factory->user->create();
		wp_set_current_user( $user_id );

		$_POST['nonce']  = wp_create_nonce( 'mab_nonce' );
		$_POST['hidden'] = 'true';

		try {
			$this->_handleAjax( 'save_admin_bar_state' );
		} catch ( WPAjaxDieContinueException $e ) {
			// Expected — wp_send_json_success() triggers this in test mode.
			unset( $e );
		}

		$saved = get_user_meta( $user_id, '_admin_bar_state', true );
		$this->assertTrue( $saved['hidden'] );
	}

	/**
	 * Two different users saving state should never affect each other's meta.
	 */
	public function test_users_state_is_isolated() {
		$user_a = $this->factory->user->create();
		$user_b = $this->factory->user->create();

		// User A hides their bar.
		wp_set_current_user( $user_a );
		$_POST['nonce']  = wp_create_nonce( 'mab_nonce' );
		$_POST['hidden'] = 'true';
		try {
			$this->_handleAjax( 'save_admin_bar_state' );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}

		// User B leaves theirs shown — never calls save, should stay default.
		$state_b = get_user_meta( $user_b, '_admin_bar_state', true );

		$this->assertTrue( get_user_meta( $user_a, '_admin_bar_state', true )['hidden'] );
		$this->assertSame( '', $state_b ); // User B never saved anything — no meta exists yet.
	}

	/**
	 * A logged-out request should be rejected, not silently succeed.
	 */
	public function test_rejects_when_not_logged_in() {
		wp_set_current_user( 0 ); // 0 = logged out.

		$_POST['nonce']  = wp_create_nonce( 'mab_nonce' );
		$_POST['hidden'] = 'true';

		try {
			$this->_handleAjax( 'save_admin_bar_state' );
		} catch ( WPAjaxDieContinueException $e ) {
			// Expected — wp_send_json_error() also triggers this in test mode, same as wp_send_json_success().
			unset( $e );
		}

		$response = json_decode( $this->_last_response, true );
		$this->assertFalse( $response['success'] );
	}
}
