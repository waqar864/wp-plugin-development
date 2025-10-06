<?php

 
echo plugins_url('', __FILE__);
echo "<br>";
echo 'PLUGINPREFIX_DIR_PATH';
echo PLUGINPREFIX_DIR_PATH . 'uninstall.php';

    do_action( 'pluginprefix_after_settings_page_html' );

?>

<h2>My Plugin Settings Page</h2>
   