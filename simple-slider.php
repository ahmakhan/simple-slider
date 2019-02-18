<?php
/*
Plugin Name: Simple Slider
Description: This plugin install will create a custom post type 'Simple Slider'. Create posts with title, content, and featured image. Then use shortcode '[simple_slider]' into your code editor.
Version: 2.0
Author: Mohammad Khan
*/

// enque custom script and stylesheet
function custom_scripts_enqueue() {
  wp_enqueue_script('simple-slider-script', plugins_url() .'/simple-slider/simple-slider-script.js', array('jquery'), '1.0', true );
  wp_enqueue_style('simple-slider-style', plugins_url() .'/simple-slider/simple-slider-style.css', '1');
}
add_action('wp_enqueue_scripts', 'custom_scripts_enqueue');

// Register Custom Post Type 'Simple Slider'
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Simple Sliders', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Simple Slider', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Simple Sliders', 'text_domain' ),
		'name_admin_bar'        => __( 'Simple Slider', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Simple Slider', 'text_domain' ),
		'description'           => __( 'Simple Slider content', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'simple_slider', $args );

}
add_action( 'init', 'custom_post_type', 0 );

// Simple Slider Shortcode
function simple_slider_shortcode() {
  ob_start(); ?>

  <div id="simple-slider">
    <div class="simple-slider-wrap simple-slider">
      <?php
        $count = 1;
        $args = array( 'post_type' => 'simple_slider', 'posts_per_page' => 10 );
        $loop = new WP_Query( $args );
        echo '<ul class="entry-content simple-slides">';
          while ( $loop->have_posts() ) : $loop->the_post();
            echo '<li class="simple-slide'.($count == 1 ? ' current-slide' : '').'" data-slide='.$count.'>';
              the_content();
              echo '<h4>'.get_the_title().'</h4>';
              echo '<div>'.get_the_post_thumbnail().'</div>';
            echo '</li>';
            $count++;
          endwhile;
          wp_reset_postdata();
        echo '</ul>';
        echo '<ol class="slider-index-holder">';
          for ($i=1; $i<$count; $i++) {
            echo '<li class="slider-index'.($i == 1 ? ' current-index' : '').'" data-index='.$i.'></li>';
          }
        echo '</ol>';
      ?>
    </div>
  </div>

  <?php
	return ob_get_clean();
}
add_shortcode( 'simple_slider', 'simple_slider_shortcode' );
?>
