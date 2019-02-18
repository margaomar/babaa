<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
    </div>
  <![endif]-->

  <?php
    do_action('get_header');
    get_template_part('templates/header');
  ?>

  <?php if ( is_front_page() && is_active_sidebar( 'widget-area-home-top-1' ) ) : ?>
      <section class="jumbotron widget-area-full widget-area-top widget-area-home widget-area-home-first">
        <?php dynamic_sidebar('widget-area-home-top-1'); ?>
      </section>
  <?php endif; ?>

  <?php if ( is_front_page() && is_active_sidebar( 'widget-area-home-top-2' ) ) : ?>
      <section class="jumbotron widget-area-full widget-area-top widget-area-home">
        <div class="container">
            <?php dynamic_sidebar('widget-area-home-top-2'); ?>
        </div>
      </section>
  <?php endif; ?>

  <?php if ( is_page_template( 'template-contact.php' ) && is_active_sidebar( 'widget-area-contact-top' ) ) : ?>
      <section class="jumbotron widget-area-full widget-area-top widget-area-contact">
        <?php dynamic_sidebar('widget-area-contact-top'); ?>
      </section>
  <?php endif; ?>

  <?php  if ( has_post_thumbnail() && !is_singular('fik_product') && !is_singular('post') && !is_archive() && !is_blog()) { ?>
      <figure class="featured-image page-featured-image">
        <?php the_post_thumbnail( 'page-header-custom-thumbnail', array('class' => 'img-responsive') ); ?>
      </figure>
  <?php } ?>

  <div class="wrap container" role="document">
    <div class="content row">
      <main class="main <?php echo roots_main_class(); ?>" role="main">
        <?php include roots_template_path(); ?>
      </main><!-- /.main -->
      <?php if (roots_display_sidebar()) : ?>
        <aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
          <?php include roots_sidebar_path(); ?>
        </aside><!-- /.sidebar -->
      <?php endif; ?>
    </div><!-- /.content -->
  </div><!-- /.wrap -->

  <?php if ( is_front_page() && is_active_sidebar( 'widget-area-home-bottom' ) ) : ?>
      <section class="jumbotron widget-area-full widget-area-bottom widget-area-home">
        <div class="container">
            <?php dynamic_sidebar('widget-area-home-bottom'); ?>
        </div>
      </section>
  <?php endif; ?>

  <?php get_template_part('templates/footer'); ?>

</body>
</html>
