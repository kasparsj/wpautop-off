<?php
/*
Plugin Name: wpautop-off
Plugin URI: http://github.com/kasparsj/wpautop-off
Description: Turn wpautop off
Author: Kaspars Jaudzems
Author URI: http://kasparsj.wordpress.com/
Version: 1.0
*/

if ( is_admin() ) {
  add_filter('tiny_mce_before_init', 'wpautop_control_tiny_mce_before_init');

  function wpautop_control_tiny_mce_before_init($tinymce) {
    $tinymce['wpautop'] = false;
    return $tinymce;
  }
}
else { // ! is_admin()
  add_filter('the_content', 'wpautop_control_before', 9);
  add_filter('the_excerpt', 'wpautop_control_before', 9);
  add_filter('the_content', 'wpautop_control_after', 11);
  add_filter('the_excerpt', 'wpautop_control_after', 11);

  function wpautop_control_before($content) {
    $remove_filter = preg_match('/<p[^>]*>/i', $content);

    if ( $remove_filter ) {
      remove_filter('the_content', 'wpautop');
      remove_filter('the_excerpt', 'wpautop');
    }

    return $content;
  }
  
  function wpautop_control_after($content) {
    $add_filter = preg_match('/<p[^>]*>/i', $content);
    
    if ( $add_filter ) {
      add_filter('the_content', 'wpautop');
      add_filter('the_excerpt', 'wpautop');
    }
    
    return $content;
  }
}

?>
