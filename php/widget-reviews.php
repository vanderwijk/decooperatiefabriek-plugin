<?php 

function review() {

	$labels = array(
		'name'                => _x( 'Reviews', 'Post Type General Name', 'dcf' ),
		'singular_name'       => _x( 'Review', 'Post Type Singular Name', 'dcf' ),
		'menu_name'           => __( 'Reviews', 'dcf' ),
		'name_admin_bar'      => __( 'Review', 'dcf' ),
		'parent_review_colon'   => __( 'Parent Review:', 'dcf' ),
		'all_reviews'           => __( 'All Reviews', 'dcf' ),
		'add_new_review'        => __( 'Add New Review', 'dcf' ),
		'add_new'             => __( 'Add New', 'dcf' ),
		'new_review'            => __( 'New Review', 'dcf' ),
		'edit_review'           => __( 'Edit Review', 'dcf' ),
		'update_review'         => __( 'Update Review', 'dcf' ),
		'view_review'           => __( 'View Review', 'dcf' ),
		'search_reviews'        => __( 'Search Review', 'dcf' ),
		'not_found'           => __( 'Not found', 'dcf' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'dcf' ),
	);
	$args = array(
		'label'               => __( 'Review', 'dcf' ),
		'description'         => __( 'Reviews', 'dcf' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'          => array( 'review_category' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-quote',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'Review', $args );

}
add_action( 'init', 'review', 0 );

// Register Custom Taxonomy
function review_category() {
	
		$labels = array(
			'name'                       => _x( 'Taxonomies', 'Taxonomy General Name', 'dcf' ),
			'singular_name'              => _x( 'Taxonomy', 'Taxonomy Singular Name', 'dcf' ),
			'menu_name'                  => __( 'Taxonomy', 'dcf' ),
			'all_items'                  => __( 'All Items', 'dcf' ),
			'parent_item'                => __( 'Parent Item', 'dcf' ),
			'parent_item_colon'          => __( 'Parent Item:', 'dcf' ),
			'new_item_name'              => __( 'New Item Name', 'dcf' ),
			'add_new_item'               => __( 'Add New Item', 'dcf' ),
			'edit_item'                  => __( 'Edit Item', 'dcf' ),
			'update_item'                => __( 'Update Item', 'dcf' ),
			'view_item'                  => __( 'View Item', 'dcf' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'dcf' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'dcf' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'dcf' ),
			'popular_items'              => __( 'Popular Items', 'dcf' ),
			'search_items'               => __( 'Search Items', 'dcf' ),
			'not_found'                  => __( 'Not Found', 'dcf' ),
			'no_terms'                   => __( 'No items', 'dcf' ),
			'items_list'                 => __( 'Items list', 'dcf' ),
			'items_list_navigation'      => __( 'Items list navigation', 'dcf' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
		);
		register_taxonomy( 'review_category', array( 'review' ), $args );
	
	}
	add_action( 'init', 'review_category', 0 );


class dcf_widget_reviews extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'reviews', 'description' => __( 'Reviews widget' ) );
		parent::__construct( 'dcf_widget_reviews', __( 'Reviews' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget; ?>

		<?php 
		// Get the recent posts
		$q = 'orderby=rand&showposts=' . $instance[ 'numposts' ];
		if ( !empty( $instance[ 'post_type' ] )) $q .= '&post_type=' . $instance[ 'post_type' ];
		query_posts( $q );

		while (have_posts()) : the_post(); ?>
			<div class="review hreview">
				<span class="item">
					<span class="fn">Bart Hartog Bouw</span>
				</span>
				<span class="rating">5</span>
				<div class="description"><?php the_content(); ?></div>
                <?php $avatar = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
                $avatar_url = $avatar['0']; ?>
				<span class="reviewer" style="background-image: url( '<?php echo $avatar_url; ?> ')"><?php the_title(); ?></span>
			</div>
		<?php endwhile; ?>

		<?php
		echo $after_widget;
		wp_reset_query();
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'numposts' ] = $new_instance[ 'numposts' ];
		$instance[ 'post_type' ] = $new_instance[ 'post_type' ];
		return $instance;
	}

	function form( $instance ) {
		// Widget defaults
		$instance = wp_parse_args( (array) $instance, array( 
			'numposts' => 5,
			'post_type' => 'review'
		)); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'numposts' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'numposts' ); ?>" name="<?php echo $this->get_field_name( 'numposts' ); ?>" type="text" value="<?php echo $instance[ 'numposts' ]; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Custom post type:' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
			<option value=""><?php echo __( 'None' ) . ' (' . __( 'Posts' ) . ')'; ?></option>
			<?php
				$args = array(
					'public' => true,
					'_builtin' => false
				);
				$output = 'names'; // names or objects, note names is the default
				$operator = 'and'; // 'and' or 'or'
				$post_types = get_post_types( $args, $output, $operator );
				foreach ( $post_types  as $post_type ) {
					echo '<option value="' . $post_type . '"' . selected( $instance[ 'post_type' ], $post_type ). '>' . $post_type . '</option>';
				}
			?>
			</select>
		</p>

		<?php
	}
}