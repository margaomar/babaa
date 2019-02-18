<?php if(is_singular('fik_product') || is_post_type_archive('fik_product')){ ?>
    <?php dynamic_sidebar('sidebar-store'); ?>
<?php }else{ ?>
    <?php dynamic_sidebar('sidebar-primary'); ?>
<?php } ?>
