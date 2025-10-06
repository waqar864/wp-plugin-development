<?php
/*
 * Plugin Name:       My Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       dummy test plugin for learning.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            waqar khan
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-plugin
 * Domain Path:       /languages
 
 */

/*
My Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

My Plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with My Plugin. If not, see https://example.com/plugins/the-basics/.
*/

if(!defined( 'PLUGINPREFIX_DIR_PATH')) {
    define( 'PLUGINPREFIX_DIR_PATH', plugin_dir_path( __FILE__ ) );
}



/**
 * Register the "book" custom post type
 */
function pluginprefix_setup_post_type() {
	register_post_type( 'book', ['public' => true ] ); 
} 
add_action( 'init', 'pluginprefix_setup_post_type' );




/**
* Uninstall hook 
*/
register_uninstall_hook(
	__FILE__,
	'pluginprefix_function_to_run'
);

if ( is_admin() ) {
    // we are in admin mode
  include ( PLUGINPREFIX_DIR_PATH . 'admin/admin-core.php' );
} else {
    // we are in non-admin mode
    // add_action( 'init', 'pluginprefix_setup_post_type' );
}

?>