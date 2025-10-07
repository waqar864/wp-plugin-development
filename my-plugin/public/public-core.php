<?php
/**
 * the code for public side of plugin
 */


function pluginprefix_append_edit_buttont($content){
    if(is_singular('book') && is_user_logged_in() && current_user_can('edit_posts')){
        $edit_post_link = get_edit_post_link();
        $content .= '<p><a href="'.esc_url($edit_post_link).'" class="button">Edit This Post</a></p>';
    }
    return $content;
}
add_filter( 'the_content', 'pluginprefix_append_edit_buttont');

//enqueuing frontend js file 
function pluginprefix_enqueue_public_files(){
	wp_enqueue_script('public-script',PLUGINPREFIX_DIR_URL . '/public/js/public.js',array('jquery'),'1.0.0',true);
}

add_action(('wp_enqueue_scripts'),'pluginprefix_enqueue_public_files');


?>