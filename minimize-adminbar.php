<?php
/**
 * Plugin Name: 		Minimize Admin Bar
 * Description: 		This plugin lets you minimize WP admin bar so that you can work with your content with less distraction.
 * Version: 			1.0.0
 * Requires at least: 	6.9
 * Requires PHP:      	8.0
 * Author: 				Bharat Thapa
 * Author URI: 			https://bharatt.com.np
 * Text Domain: 		minimize-adminbar
 * License:           	GPLv3
 * License URI:       	https://www.gnu.org/licenses/gpl-3.0.html
 */

/*
 *  Minimize Admin Bar is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License, version 3, as
 *  published by the Free Software Foundation.
 *
 *  Minimize Admin Bar is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Minimize Admin Bar; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

defined( 'ABSPATH' ) || exit;
! class_exists( 'Minimize_AdminBar' ) || exit;

define( 'MAB_PLUGIN_FILE', __FILE__ );
define( 'MAB_PLUGIN_BASENAME', plugin_basename( MAB_PLUGIN_FILE ) );
define( 'MAB_PLUGIN_PATH', dirname( MAB_PLUGIN_FILE ) . '/' );
define( 'MAB_PLUGIN_URL', plugins_url( '/', MAB_PLUGIN_FILE ) );
define( 'MAB_PLUGIN_VERSION', '1.0.0' );

include_once MAB_PLUGIN_PATH . 'inc/main-class.php';

/**
 * Bootstrap and run the plugin.
 *
 * @return void
 */
function minimize_adminbar_init(): void {
	new Minimize_AdminBar();
}

add_action( 'plugins_loaded', 'minimize_adminbar_init' );
