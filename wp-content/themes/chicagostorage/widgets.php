<?php

// Custom Text Widget without <div>
class Custom_Widget_Text extends WP_Widget {

	function Custom_Widget_Text() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __('Arbitrary text or HTML', 'chicagostorage'));
		$control_ops = array('width' => 400, 'height' => 350);
		$this->WP_Widget('text', __('Text', 'chicagostorage'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$text = apply_filters( 'widget_text', $instance['text'], $instance );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
			<?php echo $instance['filter'] ? wpautop($text) : $text; ?>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);

		//replace site-url by shortcodes
		$instance['text'] = str_replace(get_template_directory_uri(), '[template-url]', $instance['text']);
		$instance['text'] = str_replace(home_url(), '[site-url]', $instance['text']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = esc_textarea($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'chicagostorage'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs', 'chicagostorage'); ?></label></p>
<?php
	}
}

add_action('widgets_init', create_function('', 'unregister_widget("WP_Widget_Text"); return register_widget("Custom_Widget_Text");'));


//Custom widget Recent Posts From Specific Category
class Widget_Recent_Posts_From_Category extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_recent_entries_from_category', 'description' => __( 'The most recent posts from specific category on your site', 'chicagostorage') );
        parent::__construct('recent-posts-from-category', __('Recent Posts From Specific Category', 'chicagostorage'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries_from_category';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_recent_posts_from_category', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts', 'chicagostorage') : $instance['title'], $instance, $this->id_base);
        if ( ! $number = absint( $instance['number'] ) )
             $number = 10;

        $r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'cat' => $instance['cat']));
        if ($r->have_posts()) :
?>
<?php echo $before_widget; ?>
<?php if ( $title ) echo $before_title . $title . $after_title; ?>
<ul>
<?php  while ($r->have_posts()) : $r->the_post(); ?>
<li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></li>
<?php endwhile; ?>
</ul>
<?php echo $after_widget; ?>
<?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts_from_category', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['cat'] = (int) $new_instance['cat'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries_from_category']) )
            delete_option('widget_recent_entries_from_category');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_recent_posts_from_category', 'widget');
    }

    function form( $instance ) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $cat = $instance['cat'];
?>
<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'chicagostorage'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

<p>
<label>
<?php _e( 'Category', 'chicagostorage' ); ?>:
<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat"), 'selected' => $instance["cat"] ) ); ?>
</label>
</p>

<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'chicagostorage'); ?></label>
<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
    }
}

add_action('widgets_init', create_function('', 'return register_widget("Widget_Recent_Posts_From_Category");'));

//Custom widget Recent Posts From Specific Category
class Widget_Recent_Custom_Posts extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_recent_entries_from_cpt', 'description' => __( 'The most recent posts from specific post type on your site', 'chicagostorage') );
        parent::__construct('recent-posts-from-cpt', __('Recent Posts From Specific Post type', 'chicagostorage'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries_from_cpt';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_recent_posts_from_cpt', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts', 'chicagostorage') : $instance['title'], $instance, $this->id_base);
        if ( ! $number = absint( $instance['number'] ) )
             $number = 10;
        $r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'post_type' => $instance['post_type'],'post_parent__not_in'=>array(0,)));
        if ($r->have_posts()) :
?>
<?php echo $before_widget; ?>
<?php if ( $title ) echo $before_title . $title . $after_title; ?>
<ul>
<?php  while ($r->have_posts()) : $r->the_post(); ?>
	<li>
		<i class="icon-box"></i>
		<?php $tax = get_the_terms(get_the_ID(),'sizes'); ?>
		<?php $parent = get_topmost_parent(get_the_ID()); ?>
		<?php if (!empty($tax)): ?>
			<div class="holder">
				<div class="item-size">
					<?php foreach($tax as $value): ?>
						<strong><?php echo $value->name; ?></strong>
					<?php endforeach; ?>
					<?php _e('unit','chicagostorage'); ?>
				</div>
			</div>
		<?php endif; ?>
		<?php global $post; ?>
		<?php $link = get_permalink();  ?>
		<?php $post = get_post($parent); ?>
		<?php setup_postdata($post); ?>
		<div class="description">
			<strong class="title"><?php the_title(); ?></strong>
			<?php echo wpautop(get_field('location'),false);; ?>
			<a href="<?php echo $link; ?>" class="more"><?php _e('Look At This Facility','chicagostorage'); ?></a>
		</div>
		<?php wp_reset_postdata(); ?>
	</li>
<?php endwhile; ?>
</ul>
<?php echo $after_widget; ?>
<?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts_from_cpt', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['post_type'] = $new_instance['post_type'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries_from_cpt']) )
            delete_option('widget_recent_entries_from_cpt');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_recent_posts_from_cpt', 'widget');
    }

    function form( $instance ) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $post_type = $instance['post_type'];
?>
<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'chicagostorage'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

<p>
<label>
<?php _e( 'Post Type', 'chicagostorage' ); ?>:
<?php
	$args=array(
	  'public'   => true,
	);
	$post_types = get_post_types($args,'objects'); ?>
	<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name("post_type"); ?>">
		<?php foreach($post_types as $key=>$value ): ?>
			<option value="<?php echo $key; ?>" <?php echo ($key == $post_type) ? 'selected="selected"' : ''; ?>><?php echo $value->label; ?></option>
		<?php endforeach; ?>
	</select>
</label>
</p>

<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'chicagostorage'); ?></label>
<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
    }
}

add_action('widgets_init', create_function('', 'return register_widget("Widget_Recent_Custom_Posts");'));

//Custom widget Recent Posts From Specific Category
class Widget_Recent_External_Blogs extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_recent_external_blogs', 'description' => __( 'The most recent posts from External blog posts', 'chicagostorage') );
        parent::__construct('recent-externals-blogs', __('Recent Posts From External Blog posts', 'chicagostorage'), $widget_ops);
        $this->alt_option_name = 'widget_recent_external_blogs';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_recent_external_blogs', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts', 'chicagostorage') : $instance['title'], $instance, $this->id_base);
        if ( ! $number = absint( $instance['number'] ) )
             $number = 10;
			 
		// connect to external db
		$db_user	= get_field('db_user','options') ? get_field('db_user','options') : DB_USER;
		$db_pass	= get_field('db_password','options') ? get_field('db_password','options') : DB_PASSWORD;
		$db_name 	= get_field('db_name','options') ? get_field('db_name','options') : DB_NAME;
		$db_host 	= get_field('db_host','options') ? get_field('db_host','options') : DB_HOST;
		$db_prefix 	= get_field('db_preffix','options') ? get_field('db_preffix','options') : 'wp_';
		
		// Save Current Database details
		global $wpdb, $post;
		$wpdb_new = new wpdb($db_user,$db_pass,$db_name,$db_host);
		$wpdb_new->set_prefix($db_prefix);
		$res = $wpdb_new->get_results("SELECT * FROM  $wpdb_new->posts where post_status = 'publish' ORDER BY  post_date DESC LIMIT 2");
		if (!empty($res)) :
			?>
			<?php echo $before_widget; ?>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>
			<ul>
			<?php  foreach($res as $post): setup_postdata($post); ?>
				<li>
					<i class="icon-newspaper"></i>
					<strong class="title"><a href="<?php the_permalink(); ?>"><?php echo get_the_title().' - '.get_the_time("m/d/Y"); ?></a></strong>
					<em class="meta"><?php _e('Posted on '.get_the_time("M d, Y").' by '.get_the_author(),'chicagostorage'); ?></em>
					<?php the_excerpt_max_charlength(90); ?>
					<a href="<?php the_permalink(); ?>" class="more"><?php _e('Read More','chicagostorage'); ?></a>
				</li>
				<?php wp_reset_postdata(); ?>
			<?php endforeach; ?>
			</ul>
			<?php echo $after_widget; ?>
			<?php

				endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_external_blogs', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_external_blogs']) )
            delete_option('widget_recent_external_blogs');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_recent_external_blogs', 'widget');
    }

    function form( $instance ) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $post_type = $instance['post_type'];
?>
<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'chicagostorage'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'chicagostorage'); ?></label>
<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
    }
}

add_action('widgets_init', create_function('', 'return register_widget("Widget_Recent_External_Blogs");'));
