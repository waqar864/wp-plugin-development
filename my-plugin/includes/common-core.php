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
                'taxonomies' => array('book_category'),
		);
	register_post_type( 'book', apply_filters('pluginprefix_book_post_type_arguments', $post_type_arguments)); 
} 
add_action( 'init', 'pluginprefix_setup_post_type' );


//making custom taxonomy

/*
* Plugin Name: eBooks Taxonomy
* Description: A short example showing how to add a taxonomy called Course.
* Version: 1.0
* Author: developer.wordpress.org
* Author URI: https://codex.wordpress.org/User:Aternus
*/

function pluginprefix_register_taxonomy_book_category() {
	 $labels = array(
		 'name'              => _x( 'Book Categories', 'pluginprefix' ),
		 'singular_name'     => _x( 'Book Category', 'pluginprefix' ),
		 'search_items'      => __( 'Search Book Categories' ),
		 'all_items'         => __( 'All Book Categories' ),
		 'parent_item'       => __( 'Parent Book Category' ),
		 'parent_item_colon' => __( 'Parent Book Category:' ),
		 'edit_item'         => __( 'Edit Book Category' ),
		 'update_item'       => __( 'Update Book Category' ),
		 'add_new_item'      => __( 'Add New Book Category' ),
		 'new_item_name'     => __( 'New Book Category Name' ),
		 'menu_name'         => __( 'Book Categories' ),
	 );
	 $args   = array(
		 'hierarchical'      => true, // make it hierarchical (like categories)
		 'labels'            => $labels,
		 'show_ui'           => true,
		 'show_admin_column' => true,
		 'query_var'         => true,
		 'rewrite'           => [ 'slug' => 'book-category' ],
	 );
	 register_taxonomy( 'book-category', [ 'book' ], $args );
}
add_action( 'init', 'pluginprefix_register_taxonomy_book_category' );

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

// function pluginprefix_change_post_type_arguments($post_type_arguments){
//     $post_type_arguments['labels'] = array(
//         'name'          => __('eBooks', 'pluginprefix'),
//         'singular_name' => __('eBook', 'pluginprefix'),
//         'add_new' => __('Add New eBook', 'pluginprefix'),
//         'add_new_item' => __('Add New eBook', 'pluginprefix'),    );
//     return $post_type_arguments;
// }
// add_filter('pluginprefix_book_post_type_arguments','pluginprefix_change_post_type_arguments');


//add meta box

function pluginprefix_custom_box_html($post){
    // var_dump($post);
    $current_book_author = get_post_meta($post->ID,'_pluginprefix_book_author',true);
    $current_book_type = get_post_meta($post->ID,'_pluginprefix_book_type',true);
    $current_book_downloadable = get_post_meta($post->ID,'_pluginprefix_book_downloadable',true);
	$metabox_nonce = wp_create_nonce('pluginprefix_book_metabox');
    // echo $current_book_downloadable;
    // echo "<br>";
    // echo $current_book_type;
    ?>
    <label for="pluginprefix_book_author"><?php esc_html_e('Book Author name') ?></label>
    <input type="text" name="pluginprefix_book_author" id="pluginprefix_book_author" value="<?php echo esc_attr($current_book_author); ?>">
    <br><br>

    	<label for="pluginprefix_book_type"><?php esc_html_e('the book is available in') ?></label>
	
    <select name="pluginprefix_book_type" id="pluginprefix_book_type" class="postbox">
		<option value="" <?php selected( $current_book_type, '') ?>><?php esc_html_e('Select Option') ?></option>
		<option value="pdf" <?php selected( $current_book_type, 'pdf') ?>><?php esc_html_e('PDF') ?></option>
		<option value="worddoc" <?php selected( $current_book_type, 'worddoc') ?>><?php esc_html_e('Word Document') ?></option>
        <option value="both" <?php selected( $current_book_type, 'both') ?> ><?php esc_html_e('Both') ?></option>
	</select>
    <br><br>
    <label for="pluginprefix_book_downloadable"><?php esc_html_e('Book is Downloadable') ?></label>
    <input type="checkbox" name="pluginprefix_book_downloadable" id="pluginprefix_book_downloadable" <?php if($current_book_downloadable == 'on'){echo 'checked="checked"';} ?> />
	<input type="hidden" name="pluginprefix_book_metabox" id="pluginprefix_book_metabox" value="<?php echo esc_attr($metabox_nonce); ?>" />
    <?php
}
function pluginprefix_add_custom_meta_box(){
    	add_meta_box(
			'pluginprefix_box_id',                 // Unique ID
			'Custom Meta Box Title',      // Box title
			'pluginprefix_custom_box_html',  // Content callback, must be of type
            'book'                            // Post type' callable
		
		);

}
function pluginprefix_save_postdata( $post_id ) {

	if ( !array_key_exists( 'pluginprefix_book_metaboxr', $_POST ) && !wp_verify_nonce( $_POST['pluginprefix_book_metabox'], 'pluginprefix_book_metabox' ) ) {
       
		return;
	}
    // var_dump($_POST,'pluginprefix_book_downloadable');die();
	if ( array_key_exists( 'pluginprefix_book_author', $_POST ) ) {
        $book_author = sanitize_text_field($_POST['pluginprefix_book_author']);
		update_post_meta(
			$post_id,
			'_pluginprefix_book_author',
			$book_author
		);
	}
    if ( array_key_exists( 'pluginprefix_book_type', $_POST ) ) {
        $book_type = sanitize_text_field($_POST['pluginprefix_book_type']);
		update_post_meta(
			$post_id,
			'_pluginprefix_book_type',
            $book_type
		);
	}
     $current_checkbox_value = ($_POST
        ['pluginprefix_book_downloadable']) ? $_POST
        ['pluginprefix_book_downloadable'] : 'off';
        // echo $current_checkbox_value;die(); 
        update_post_meta(
			$post_id,
			'_pluginprefix_book_downloadable',
           
			$current_checkbox_value
		);
   
}
add_action( 'save_post', 'pluginprefix_save_postdata' );

add_action('add_meta_boxes','pluginprefix_add_custom_meta_box');

//custom shortcode

add_shortcode('pluginprefix_myshortcode', 'pluginprefix_shortcode');
function pluginprefix_shortcode( $atts = [], $content = null) {
	$content = 'this is our shortcode';
    // do something to $content
    // always return
    return $content;
}
//shprtcode with closing tag

add_shortcode('pluginprefix_enclosing_shortcode', 'pluginprefix_enclosing_shortcode_function');
function pluginprefix_enclosing_shortcode_function( $atts = [], $content = null) {
	$content .= 'this is our enclosing shortcode';
	// do something to $content
	// always return
	return $content;
}


// ajax handler function for frontend and backend both

add_action( 'wp_ajax_pluginprefix_ajax_example', 'pluginprefix_ajax_handler' ); // for logged in users

//for non-logged in users
add_action( 'wp_ajax_nopriv_pluginprefix_ajax_example', 'pluginprefix_ajax_handler' ); //for non-logged in users

/**
 * Handles my AJAX request.
 */
function pluginprefix_ajax_handler() {
	// Handle the ajax request here
	check_ajax_referer( 'pluginprefix_ajax_nonce');

	//Task: sent the total number of books available as response
	$args = array(
		'post_type' => 'book',
		// 'post_status' => 'publish',
		'posts_per_page' => -1,
	);
	$the_query = new WP_Query( $args );
	$total_books = $the_query->post_count;

	wp_send_json( esc_html($total_books) );

	wp_die(); // All ajax handlers die when finished
}

?>