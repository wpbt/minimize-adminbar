<?php

// Exit if accessed directly!
defined( 'ABSPATH' ) || exit;

class Minimize_AdminBar {
	const META_KEY = '_admin_bar_state';

	public function __construct() {
		add_action( 'init', [ $this, 'load_text_domain' ] );

		add_action( 'wp_footer', [ $this, 'print_toggle_button' ] );
		add_action( 'admin_footer', [ $this, 'print_toggle_button' ] );

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
		add_action( 'wp_ajax_save_admin_bar_state', [ $this, 'ajax_save_state' ] );

		add_action( 'wp_head', [ $this, 'print_early_state_script' ] );
		add_action( 'admin_head', [ $this, 'print_early_state_script' ] );
	}

	/**
	 * Loads the plugin's text domain for translations.
	 */
	public function load_text_domain(): void {
		load_plugin_textdomain(
			'minimize-adminbar',
			false,
			dirname( MAB_PLUGIN_FILE ) . '/languages'
		);
	}

	private function get_state() {
		$defaults = [
			'hidden'   => false,
			'position' => 'top',
		];

		$saved = get_user_meta( get_current_user_id(), self::META_KEY, true );

		if ( ! is_array( $saved ) ) $saved = array();

		return wp_parse_args( $saved, $defaults );
	}

	public function print_early_state_script() {
		if ( ! is_admin_bar_showing() ) return;

		$state = $this->get_state();

		if ( $state['hidden'] ) {
			echo '<script>document.documentElement.classList.add("cab-bar-hidden");</script>' . "\n";
		}
	}

	public function print_toggle_button() {
		if ( ! is_admin_bar_showing() ) return;

		$state = $this->get_state();
		$label = $state['hidden']
			? __( 'Show admin bar', 'minimize-adminbar' )
			: __( 'Hide admin bar', 'minimize-adminbar' );

		printf(
			'<button type="button" id="cab-toggle" title="%1$s"><span class="cab-caret" aria-hidden="true">%2$s</span><span class="screen-reader-text">%1$s</span></button>',
			esc_attr( $label ),
			$this->caret_svg()
		);
	}

	private function caret_svg() {
		return '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 6 15 12 9 18"></polyline></svg>';
	}

	public function enqueue_assets() {
		if ( ! is_admin_bar_showing() ) return;

		$state = $this->get_state();

		wp_enqueue_script(
			'minimize-adminbar-js',
			MAB_PLUGIN_URL . 'assets/admin-bar.js',
			array(),
			MAB_PLUGIN_VERSION,
			true
		);

		wp_enqueue_style(
			'minimize-adminbar-css',
			MAB_PLUGIN_URL . 'assets/admin-bar.css',
			array(),
			MAB_PLUGIN_VERSION
		);

		wp_localize_script( 'minimize-adminbar-js', 'MAB_DATA', array(
			'ajaxUrl' 	 	=> admin_url( 'admin-ajax.php' ),
			'nonce'   	 	=> wp_create_nonce( 'mab_nonce' ),
			'state'      	=> $state,
			'visibleText' 	=> __( 'Hide admin bar', 'minimize-adminbar'),
			'hiddenText' 	=> __( 'Show admin bar', 'minimize-adminbar' ),
		) );
	}

	public function ajax_save_state() {
		check_ajax_referer( 'mab_nonce', 'nonce' );

		if ( ! is_user_logged_in() ) wp_send_json_error( 'not_logged_in' );

		$hidden = isset( $_POST['hidden'] ) ? (bool) json_decode( sanitize_text_field( $_POST['hidden'] ) ) : false;

		$state = $this->get_state();
		$state['hidden'] = $hidden;

		update_user_meta( get_current_user_id(), self::META_KEY, $state );

		wp_send_json_success( $state );
	}
}