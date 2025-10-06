<?php
// this is for common functionality that runs on both front end and back end

//custom post type



/**
 * Register the "book" custom post type
 */
function pluginprefix_setup_post_type() {
	register_post_type( 'book', array(
			'labels'      => array(
				'name'          => __('Books', 'pluginprefix'),
                'singular_name' => __('book', 'pluginprefix'),
                'add_new' => __('Add New Book', 'pluginprefix'),
                'add_new_item' => __('Add New Book', 'pluginprefix'),
			),
				'public'      => true,
				'has_archive' => true,
                'rewrite'     => array( 'slug' => 'codo_books' ),
		) ); 
} 
add_action( 'init', 'pluginprefix_setup_post_type' );




?>