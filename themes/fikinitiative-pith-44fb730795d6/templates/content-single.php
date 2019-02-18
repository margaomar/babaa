<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <?php if ( has_post_thumbnail() ) { ?>
      <figure class="featured-image">
        <?php the_post_thumbnail( 'post-custom-thumbnail', array('class' => 'img-responsive') ); ?>
      </figure>
    <?php } ?>
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
    <?php if ( is_active_sidebar( 'widget-area-post-bottom' ) ) : ?>
      <footer class="widget-area-post">
        <?php dynamic_sidebar('widget-area-post-bottom'); ?>
      </footer>
    <?php endif; ?>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
