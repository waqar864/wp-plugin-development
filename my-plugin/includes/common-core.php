<?php
// this is for common functionality that runs on both front end and back end

//custom post type



/**
 * Register the "book" custom post type
 */
function pluginprefix_setup_post_type() {
    $post_type_arguments = array(
			'labels'      => array(
				'name'          => __('Books', 'pluginprefix'),
                'singular_name' => __('book', 'pluginprefix'),
                'add_new' => __('Add New Book', 'pluginprefix'),
                'add_new_item' => __('Add New Book', 'pluginprefix'),
			),
				'public'      => true,
				'has_archive' => true,
                'rewrite'     => array( 'slug' => 'codo_books' ),
		);
	register_post_type( 'book', apply_filters('pluginprefix_book_post_type_arguments', $post_type_arguments)); 
} 
add_action( 'init', 'pluginprefix_setup_post_type' );

//changing the main query to display custom post types as well

function pluginprefix_add_custom_post_types($query) {
	if ( is_home() && $query->is_main_query() ) {
		$query->set( 'post_type', array( 'post','book' ) );
	}
	return $query;
}
add_action('pre_get_posts', 'pluginprefix_add_custom_post_types');
//add text using custom hook
function pluginprefix_add_content_using_custom_hook(){
    ?>
    <h3>This content is added using custom hook</h3>
    <p>This is a paragraph added using custom hook</p>
    <?php
}

add_action('pluginprefix_after_settings_page_html','pluginprefix_add_content_using_custom_hook');


//changing custom post arguments using custom hook filter

function pluginprefix_change_post_type_arguments($post_type_arguments){
    $post_type_arguments['labels'] = array(
        'name'          => __('eBooks', 'pluginprefix'),
        'singular_name' => __('eBook', 'pluginprefix'),
        'add_new' => __('Add New eBook', 'pluginprefix'),
        'add_new_item' => __('Add New eBook', 'pluginprefix'),    );
    return $post_type_arguments;
}
add_filter('pluginprefix_book_post_type_arguments','pluginprefix_change_post_type_arguments');



?>