<?php if (!have_posts()) : ?>
    <div class="alert alert-warning">
        <?php _e('Sorry, no results were found.', 'roots'); ?>
    </div>
    <?php get_search_form(); ?>
<?php endif; ?>

<div class="row">
<?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('templates/content-fik_product-cols-3', get_post_format()); ?>
<?php endwhile; ?>
</div>

<?php if ($wp_query->max_num_pages > 1) : ?>
    <nav class="post-nav row">
       <div class="col-sm-12">
          <ul class="pager">
              <li class="previous"><?php next_posts_link(__('<span class="arrow">&larr;</span> <span class="text">Anterior</span>', 'roots')); ?></li>
              <li class="next"><?php previous_posts_link(__('<span class="text">Siguiente</span> <span class="arrow">&rarr;</span>', 'roots')); ?></li>
          </ul>
       </div>
    </nav>
<?php endif; ?>
