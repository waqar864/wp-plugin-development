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


?>