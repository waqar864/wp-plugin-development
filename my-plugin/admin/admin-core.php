<?php

  /**
 * Activate the plugin.
 */
function pluginprefix_activate() { 
	// Trigger our function that registers the custom post type plugin.
	pluginprefix_setup_post_type(); 
	// Clear the permalinks after the post type has been registered.
	flush_rewrite_rules(); 
}
register_activation_hook( __FILE__, 'pluginprefix_activate' );


//enqueuing admin js file 
function pluginprefix_enqueue_admin_files(){
	wp_enqueue_script(
		'admin-script',
		PLUGINPREFIX_DIR_URL . '/admin/js/admin.js',
		array(
			'jquery'
		),
		'1.0.0',
		true
	);

	wp_localize_script(
		'admin-script',
		'pluginprefix_ajax_object',
		array(
			'ajax_url'=>admin_url('admin-ajax.php'),
			'nonce'=>wp_create_nonce('pluginprefix_ajax_nonce'),
		));
}

add_action(('admin_enqueue_scripts'),'pluginprefix_enqueue_admin_files');

/**
 * Deactivation hook.
 */
function pluginprefix_deactivate() {
	// Unregister the post type, so the rules are no longer in memory.
	unregister_post_type( 'book' );
	// Clear the permalinks to remove our post type's rules from the database.
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'pluginprefix_deactivate' );

//code for menu button 
function pluginprefix_menu_content(){
    include( plugin_dir_path( __FILE__ ) . '/plugin-settings.php' );
}
//code for menu button define

add_action( 'admin_menu', 'pluginprefix_menu_button' );
function pluginprefix_menu_button() {
    add_menu_page(
        'My Plugin Title',
        'My Plugin',
        'manage_options',
        'myplugin',
        'pluginprefix_menu_content',
       
        'dashicons-admin-tools',
        60
    );
    //dashboard submenu
	add_submenu_page(
		'myplugin',
		'Dashboard',
		'Dashboard',
		'manage_options',
		'dashboard',
		'pluginprefix_menu_dashboard'
	);
	
    add_submenu_page(
		'myplugin',
		'My Submenu',
		'My Submenu',
		'manage_options',
		'submenu',
		'pluginprefix_add_submenu_page'
	);
}

//function for submenu page without parent menu
function pluginprefix_menu_dashboard(){
	include( PLUGINPREFIX_DIR_PATH . '/admin/plugin-dashboard.php' );
}
/*
function pluginprefix_add_submenu_page(){
    ?>

     <h1><?php esc_html_e('This is our submenu page' );?></h1> 

<?php
}


*/
?>