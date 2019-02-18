<?php while (have_posts()) : the_post(); ?>
  <?php
//         Uncomment the next line for show page headers in default template ()
//         get_template_part('templates/page', 'header');
  ?>
  <?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>
