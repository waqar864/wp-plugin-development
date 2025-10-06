<?php

 
echo plugins_url('', __FILE__);
echo "<br>";
echo 'PLUGINPREFIX_DIR_PATH';
echo PLUGINPREFIX_DIR_PATH . 'uninstall.php';

    do_action( 'pluginprefix_after_settings_page_html' );

    // add_post_meta(10,'my-custom-key','any custom value',true);

    // $responce = update_post_meta(10,'new-key','another value',true);

    // $responce = delete_post_meta(10,'my-custom-key');
    // var_dump($responce);

?>

<h2>My Plugin Settings Page</h2>
   