<?php
/*
Plugin Name: Fik Social Share Widget
Description: Allow users to share your posts and pages in common social websites.
Author: FikStores
Version: 1.0
*/

class fikSocialWidget extends WP_Widget {

	private $services = array(
		'delicious' => array(
			'slug' => 'delicious',
			'name' => 'Del.icio.us',
			'label' => 'Del.icio.us',
			'url' => 'http://del.icio.us/post?url=[URL]&title=[TITLE]]&notes=[DESCRIPTION]'
		),
		'digg' => array(
			'slug' => 'digg',
			'name' => 'Digg',
			'label' => 'Digg',
			'url' => 'http://www.digg.com/submit?phase=2&url=[URL]&title=[TITLE]'
		),
		'facebook' => array(
			'slug' => 'facebook',
			'name' => 'Facebook',
			'label' => 'Facebook',
			'url' => 'http://www.facebook.com/share.php?u=[URL]&title=[TITLE]'
		),
		'google-plus' => array(
			'slug' => 'google-plus',
			'name' => 'Google+',
			'label' => 'Google+',
			'url' => 'https://plus.google.com/share?url=[URL]'
		),
		'linkedin' => array(
			'slug' => 'linkedin',
			'name' => 'LinkedIn',
			'label' => 'LinkedIn',
			'url' => 'http://www.linkedin.com/shareArticle?mini=true&url=[URL]&title=[TITLE]&source=[DOMAIN]'
		),
		'pinterest' => array(
			'slug' => 'pinterest',
			'name' => 'Pinterest',
			'label' => 'Pinterest',
			'url' => 'http://pinterest.com/pin/create/button/?url=[URL]&media=[URL]&description=[DESCRIPTION]'
		),
		'reddit' => array(
			'slug' => 'reddit',
			'name' => 'Reddit',
			'label' => 'Reddit',
			'url' => 'http://www.reddit.com/submit?url=[URL]&title=[TITLE]'
		),
		'stumbleupon' => array(
			'slug' => 'stumbleupon',
			'name' => 'StumbleUpon',
			'label' => 'StumbleUpon',
			'url' => 'http://www.stumbleupon.com/submit?url=[URL]&title=[TITLE]'
		),
		'tumblr' => array(
			'slug' => 'tumblr',
			'name' => 'Tumblr',
			'label' => 'Tumblr',
			'url' => 'http://www.tumblr.com/share?v=3&u=[URL]&t=[TITLE]'
		),
		'twitter' => array(
			'slug' => 'twitter',
			'name' => 'Twitter',
			'label' => 'Twitter',
			'url' => 'http://twitter.com/home?status=[TITLE]+[URL]'
		)
	);

	// Widget actual processes
	function __construct() {
		parent::WP_Widget('fik_social_widget', 'Fik Social Share', array('description' => 'Display icons to share your content in common social websites.'));
	}

	// Outputs the options form on admin
	function form($instance) {

		// Set up default widget settings
		$defaults = array(
			'title' => 'Share',
			'fikcss' => false,
			'pages' => false,
			'posts' => true,
			'homepage' => false,
			'home_share' => 'home_general',
			'order' => '',
			'on_delicious' => false,
			'on_digg' => false,
			'on_facebook' => true,
			'on_google-plus' => true,
			'on_linkedin' => true,
			'on_pinterest' => true,
			'on_reddit' => false,
			'on_stumbleupon' => false,
			'on_tumblr' => true,
			'on_twitter' => true,
		);

		$instance = wp_parse_args((array)$instance, $defaults);

		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo($instance['title']); ?>" style="width:100%;" />
			</p>

			<p>Where should Fik Social Share be used:</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['pages']); ?> id="<?php echo $this->get_field_id('pages'); ?>" name="<?php echo $this->get_field_name('pages'); ?>" />
				<label for="<?php echo $this->get_field_id('pages'); ?>"> Pages</label><br />
				<input class="checkbox" type="checkbox" <?php checked($instance['posts']); ?> id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" />
				<label for="<?php echo $this->get_field_id('posts'); ?>"> Posts</label><br />
				<input class="checkbox" type="checkbox" <?php checked($instance['homepage']); ?> id="<?php echo $this->get_field_id('homepage'); ?>" name="<?php echo $this->get_field_name('homepage'); ?>" />
				<label for="<?php echo $this->get_field_id('homepage'); ?>"> Homepage</label><br />
			</p>
			<p>What should be shared:</p>
			<p>
				<?php $options = get_option( 'my_option' ); ?>
				<input class="radio" type="radio" value="home_general" <?php checked($instance['home_share'] == 'home_general'); ?> id="<?php echo $this->get_field_id('home_share'); ?>" name="<?php echo $this->get_field_name('home_share'); ?>" />
				<label for="<?php echo $this->get_field_id('home_share'); ?>"> Site title and tagline</label><br />
				<input class="radio" type="radio" value="home_post" <?php checked($instance['home_share'] == 'home_post'); ?> id="<?php echo $this->get_field_id('home_share'); ?>" name="<?php echo $this->get_field_name('home_share'); ?>" />
				<label for="<?php echo $this->get_field_id('home_share'); ?>"> Latest post on post listing</label>
			</p>
			<p>Services enabled:</p>
			<p>
				<?php
					foreach($this->services as $service) {
						if($instance['on_' . $service['slug']]) $checked = 'checked="checked"'; else $checked = '';
						echo('<input class="checkbox" type="checkbox" ' . $checked . ' id="' . $this->get_field_id('on_' . $service['slug']) . '" name="' . $this->get_field_name('on_' . $service['slug']) . '" />');
						echo('<label for="' . $this->get_field_id('on_' . $service['slug']) . '"> ' . $service['name'] . ' (' . $service['slug']  . ')</label><br />');
					}
				?>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('order'); ?>">Order to display icons:</label>
				<input id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" value="<?php echo($instance['order']); ?>" style="width:100%;" />
			</p>
		<?php
	}

	// Processes widget options to be saved
	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		// Strip tags (if needed) and update the widget settings
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['fikcss'] = (bool)$new_instance['fikcss'];
		$instance['pages'] = (bool)$new_instance['pages'];
		$instance['posts'] = (bool)$new_instance['posts'];
		$instance['homepage'] = (bool)$new_instance['homepage'];
		$instance['home_share'] = $new_instance['home_share'];
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['on_delicious'] = (bool)$new_instance['on_delicious'];
		$instance['on_digg'] = (bool)$new_instance['on_digg'];
		$instance['on_facebook'] = (bool)$new_instance['on_facebook'];
		$instance['on_google-plus'] = (bool)$new_instance['on_google-plus'];
		$instance['on_linkedin'] = (bool)$new_instance['on_linkedin'];
		$instance['on_pinterest'] = (bool)$new_instance['on_pinterest'];
		$instance['on_reddit'] = (bool)$new_instance['on_reddit'];
		$instance['on_stumbleupon'] = (bool)$new_instance['on_stumbleupon'];
		$instance['on_tumblr'] = (bool)$new_instance['on_tumblr'];
		$instance['on_twitter'] = (bool)$new_instance['on_twitter'];

		return($instance);

	}

	// Outputs the content of the widget
	function widget($args, $instance) {

        // Define variables

        $elements = '';

		// Check if it should display widget
		if(is_front_page() || is_page() || is_single() || is_404()) {
			if(is_page() && !$instance['pages']) return;
			if(is_single() && !$instance['posts']) return;
			if(is_front_page() && !$instance['homepage']) return;
			if( is_404() ) return;
		}

		extract($args);

		// User-selected settings
		$title = apply_filters('widget_title', $instance['title'] );

		// Before widget
		echo $before_widget;

		// Title of widget
		if($title) echo($before_title . $title . $after_title);

		?>
		<ul class="fik-share inline">
			<?php

				// Define what to share on homepage
				$homeTitle = '';
				$homeDescription = '';
				$homeURL = '';
				if(is_front_page()) {
					// Share post info
					if($instance['home_share'] == 'home_post') {
						query_posts('posts_per_page=1');
						if(have_posts()){
							while (have_posts()){
								the_post();
								$homeTitle = get_the_title();
								$homeExcerpt = get_the_excerpt();
								$homeURL = get_permalink();
							}
						}
						wp_reset_query();
					}
					// Share site info
					if($instance['home_share'] == 'home_general') {
						$homeTitle = get_bloginfo('name');
						$homeExcerpt = get_bloginfo('description');
						$homeURL = get_home_url();
					}
				}

				// Start by the ordered elements
				$order = str_replace(' ', '', $instance['order']);
				if($order != '') {
					$elements = explode(',', $order);
					foreach($elements as $element) {
						if($instance['on_' . $element]) {
							echo('<li class="fik-share-item">');
							echo('<a href="' . $this->processUrl($this->services[$element]['url'], $homeTitle, $homeDescription, $homeURL) . '" target="_blank"><span class="fik-share-icon fa fa-' . $this->services[$element]['slug'] . ' fa-lg"></span></a>');
							echo('</li>');
						}
					}
				}

				// Do the others
				foreach($this->services as $service) {
					if($instance['on_' . $service['slug']] && !in_array($service['slug'], $elements)) {
						echo('<li class="fik-share-item">');
						echo('<a href="' . $this->processUrl($service['url'], $homeTitle, $homeDescription, $homeURL) . '" target="_blank"><span class="fik-share-icon fa fa-' . $service['slug'] . ' fa-lg"></span></a>');
						echo('</li>');
					}
				}

			?>
		</ul>
		<?php

		// After widget
		echo $after_widget;

	}

	function processUrl($url, $homeTitle, $homeDescription, $homeURL) {
		$url = str_replace('[DOMAIN]', urlencode(get_bloginfo('url')), $url);
		if($homeURL == '')
			$url = str_replace('[URL]', urlencode(get_permalink()), $url);
		else
			$url = str_replace('[URL]', urlencode($homeURL), $url);
		if($homeTitle == '')
			$url = str_replace('[TITLE]', urlencode(get_the_title()), $url);
		else
			$url = str_replace('[TITLE]', urlencode($homeTitle), $url);
		if($homeDescription == '')
			$url = str_replace('[DESCRIPTION]', urlencode(get_the_excerpt()), $url);
		else
			$url = str_replace('[DESCRIPTION]', urlencode($homeDescription), $url);
		return $url;
	}

}

// Register widget
add_action('widgets_init', 'fikSocialWidget_load_widgets');

function fikSocialWidget_load_widgets() {
    register_widget('fikSocialWidget');
}

?>
