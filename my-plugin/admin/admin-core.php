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
    add_submenu_page(
		'myplugin',
		'My Submenu',
		'My Submenu',
		'manage_options',
		'submenu',
		'pluginprefix_add_submenu_page'
	);
}

function pluginprefix_add_submenu_page(){
    ?>

    <h2>this is our submenu page </h2>
    <p>Testing for sub menu 

    </p>

<?php
}



?>