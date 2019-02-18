<?php

function bootstrap_clearfix_cols($columns) {
    global $wp_query;
    if ($columns == 3){

        if(($wp_query->current_post + 1) % 3 == 0) {
            echo '<div class="clearfix hidden-xs hidden-sm"></div>';
        }

        if(($wp_query->current_post + 1) % 2 == 0) {
            echo '<div class="clearfix visible-sm-block"></div>';
        }

    }elseif($columns == 4){

        if(($wp_query->current_post + 1) % 2 == 0) {
            echo '<div class="clearfix visible-sm-block"></div>';
        }

        if(($wp_query->current_post + 1) % 4 == 0) {
            echo '<div class="clearfix visible-md-block visible-lg-block"></div>';
        }
    }

}
add_action('clearfix_hook_cols', 'bootstrap_clearfix_cols');
