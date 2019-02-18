<?php setup_postdata($post); ?>
<?php if ( is_tax('store-section') || is_post_type_archive( 'fik_product' ) || is_home() || is_page_template( 'page-templates/store-front-page.php' ) || is_search() ) : // Only display product excerpt for home, archive page, store section and search ?>

<article class="product-preview col-xs-12 col-sm-6 col-md-4">

<?php get_template_part('templates/content-fik_product-thumb'); ?>

</article>

<?php do_action('clearfix_hook_cols', '3'); ?>

<?php else: ?>

<?php get_template_part('templates/content-fik_product-single'); ?>

<?php endif; ?>
