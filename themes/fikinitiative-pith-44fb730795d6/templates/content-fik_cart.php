<?php
/**
 * * The template used for displaying page content in page.php
 * */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cart-page'); ?>>

    <?php the_fik_checkout(); ?>

</article><!-- #post -->
