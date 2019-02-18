<?php

// Bug testing only. Not to be used on a production site!!
add_action('wp_footer', 'roots_wrap_info');

function roots_wrap_info() {
    $format = '<h6>The %s template being used is: %s</h6>';
    $main   = Roots_Wrapping::$main_template;
    global $template;

    printf($format, 'Main', $main);
    printf($format, 'Base', $template);
}
