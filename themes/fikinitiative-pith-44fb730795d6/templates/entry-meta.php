<time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time>
<p class="byline author vcard"><?php echo __('By', 'roots'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a></p>
<?php if ( get_comments_number() != 0 && is_archive()) : ?>
    <small class="number-comments"><span class="fa fa-comment<?php if (get_comments_number() > 1) : echo('s'); endif;?>-o comments-icon"></span><?php printf(_n('1 comment', '%1$s comments', get_comments_number(), 'roots'), number_format_i18n(get_comments_number()), get_the_title()); ?></small>
<?php endif; ?>
