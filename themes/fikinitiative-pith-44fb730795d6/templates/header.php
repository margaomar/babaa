<header class="banner navbar navbar-default navbar-static-top" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>/">
          <?php the_store_logo(null, array('class' => 'logo')); ?>
      </a>
      <?php if(get_bloginfo('description') !=''){ ?>
        <div class="navbar-brand-description"><?php echo get_bloginfo('description'); ?></div>
      <?php } ?>
    </div>

    <nav class="pull-right cart-container">
      <?php
        if (has_nav_menu('cart_menu')) :
          wp_nav_menu(array('theme_location' => 'cart_menu', 'menu_class' => 'nav navbar-nav cart-menu'));
        endif;
        ?>
    </nav>

    <nav class="collapse navbar-collapse pull-right" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
        endif;
      ?>
    </nav>

  </div>
</header>
