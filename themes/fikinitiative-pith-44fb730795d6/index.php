<?php // get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'roots'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', get_post_format()); ?>
<?php endwhile; ?>

<?php if ($wp_query->max_num_pages > 1) : ?>
  <nav class="post-nav row">
     <div class="col-sm-12">
        <ul class="pager">
            <li class="previous"><?php next_posts_link(__('<span class="arrow">&larr;</span> <span class="text">Older</span>', 'roots')); ?></li>
            <li class="next"><?php previous_posts_link(__('<span class="text">Newer</span> <span class="arrow">&rarr;</span>', 'roots')); ?></li>
        </ul>
     </div>
  </nav>
<?php endif; ?>
