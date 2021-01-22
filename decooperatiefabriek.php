<?php
/*
Plugin Name: de Coöperatie Fabriek
Description: Core functionality for de Coöperatie Fabriek.
Version: 1.0
Author: Stijn de Jong
Author URI: http://www.stijndejong.com
*/

/*----------------------------------------------------------------------------------------------

[Table of contents]

1. Defaults
2. Custom post types
3. WPAlchemy
4. Options admin page

----------------------------------------------------------------------------------------------*/

/*----------------------------------------------------------------------------------------------
[Defaults]
----------------------------------------------------------------------------------------------*/

/*--- REMOVE GENERATOR META TAG ---*/  
remove_action('wp_head', 'wp_generator');

$plugin_dir_path = __DIR__;

/*----------------------------------------------------------------------------------------------
[Custom post types]
----------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------
[Programma's]
----------------------------------------------------------------------------------------------*/

add_action( 'init', 'create_courses' );
function create_courses() {
  $labels = array(
    'name' => _x("Programma's", 'courses'),
    'singular_name' => _x('Programma', 'courses'),
    'add_new' => _x('Nieuw programma', 'courses')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'capability_type' => 'page',
    'hierarchical' => true,
    'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt'),
    'rewrite' => array('slug' => 'programma'),
    'menu_icon' => WP_PLUGIN_URL . '/decooperatiefabriek-plugin/images/courses.png'
  ); 
  register_post_type('courses',$args);
}

function courses_taxonomy() {  
   register_taxonomy(  
    	'categorie',  
    	'courses',  
    	array(  
        	'hierarchical' => true,
        	'label' => 'Categorie',
        	'query_var' => true,
        	'show_ui' => true,
        	'query_var' => true,
        	'rewrite' => array('slug' => 'categorie'),
        	'show_admin_column' => true
    	)
	);
}
  
add_action( 'init', 'courses_taxonomy' );

add_filter("manage_edit-courses_columns", "courses_edit_columns");
add_action("manage_courses_posts_custom_column", "courses_columns_display");
 
function courses_edit_columns($courses_columns){
	$courses_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Titel",
		"date" => "Datum",
		"tax" => "Categorie",
		"active" => "Actief op homepagina",
		"descript" => "Samenvatting",
		"thumb" => "Thumbnail"
	);
	return $courses_columns;
}

function courses_columns_display($courses_columns){
	switch ($courses_columns)
	{
		case "tax":
			$tags = get_the_terms($post->ID, 'categorie'); //lang is the first custom taxonomy slug
			if ( !empty( $tags ) ) {
				$out = array();
				foreach ( $tags as $c )
			    	$out[] = esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'lang', 'display'));
			    	echo join( ', ', $out );
			} else {
				_e('Geen categorie.');  //No Taxonomy term defined
			}  
		break;
		case "active":
			global $course_meta;
			$course_meta->the_meta();
			if($course_meta->get_the_value('extra_active')) { echo "<mark>Ja</mark>"; }
		break;
		case "descript":
			echo wp_trim_words( get_the_excerpt(), 25 );
		break;
		case "thumb":
			echo the_post_thumbnail( array(50, 50) );
		break;
	}
}

function courses_register_sortable( $columns )
{
	$columns['tax'] = 'tax';
	return $columns;
}

add_filter("manage_edit-courses_sortable_columns", "courses_register_sortable" );


/*----------------------------------------------------------------------------------------------
[Team]
----------------------------------------------------------------------------------------------*/

add_action( 'init', 'create_team' );
function create_team() {
  $labels = array(
    'name' => _x("Team", 'team'),
    'singular_name' => _x('Teamlid', 'team'),
    'add_new' => _x('Nieuw teamlid', 'team')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'capability_type' => 'post',
    'hierarchical' => false,
    'supports' => array( 'title', 'editor', 'thumbnail'),
    'rewrite' => array('slug' => 'teamlid'),
    'menu_icon' => WP_PLUGIN_URL . '/decooperatiefabriek-plugin/images/team.png'
  ); 
  register_post_type('team',$args);
}

add_filter("manage_edit-team_columns", "team_edit_columns");
add_action("manage_team_posts_custom_column", "team_columns_display");

function team_taxonomy() {  
   	
   register_taxonomy(  
    	'team_category',  
    	'team',  
    	array(  
        	'hierarchical' => true,
        	'labels' => array(
        			'name'                       => _x( 'Categorieën', 'team' ),
        			'singular_name'              => _x( 'Categorie', 'team' ),
        			'search_items'               => __( 'Zoek categorie' ),
        			'all_items'                  => __( 'Alle categorieën' ),
        			'edit_item'                  => __( 'Pas categorie aan' ),
        			'update_item'                => __( 'Update categorie' ),
        			'add_new_item'               => __( 'Voeg nieuwe categorie toe' ),
        			'menu_name'                  => __( 'Categorieën' )
        		),
        	'query_var' => true,
        	'show_ui' => true,
        	'rewrite' => array('slug' => 'team_categorie'),
        	'show_admin_column' => true
    	)
	);
}
  
add_action( 'init', 'team_taxonomy' );
 
function team_edit_columns($team_columns){
	$team_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Titel",
		"tax" => "Categorie",
		"function" => "Functie",
		"thumb" => "Thumbnail",
	);
	return $team_columns;
}

function team_columns_display($team_columns){
	global $team_meta; $meta = get_post_meta(get_the_ID(), $team_meta->get_the_id(), TRUE);
	switch ($team_columns)
	{
		case "tax":
			$tags = get_the_terms($post->ID, 'team_category');
			if ( !empty( $tags ) ) {
				$out = array();
				foreach ( $tags as $c )
			    	$out[] = esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'lang', 'display'));
			    	echo join( ', ', $out );
			} else {
				_e('Geen categorie.');  //No Taxonomy term defined
			} 
		break;
		case "thumb":
			echo the_post_thumbnail( array(50, 50) );
		break;
		case "function":
			echo $meta['team_teacher'];
		break;
	}
}

function taxonomy_filter_restrict_manage_posts() {
    global $typenow;
	
	if($typenow != 'team') { return; }

    $post_types = get_post_types( array( '_builtin' => false ) );

    if ( in_array( $typenow, $post_types ) ) {
    	$filters = get_object_taxonomies( $typenow );

        foreach ( $filters as $tax_slug ) {
            $tax_obj = get_taxonomy( $tax_slug );
            wp_dropdown_categories( array(
                'show_option_all' => __('Laat alle '.$tax_obj->label.' zien' ),
                'taxonomy' 	  => $tax_slug,
                'name' 		  => $tax_obj->name,
                'orderby' 	  => 'name',
                'selected' 	  => $_GET[$tax_slug],
                'hierarchical' 	  => $tax_obj->hierarchical,
                'show_count' 	  => false,
                'hide_empty' 	  => true
            ) );
        }
    }
}

add_action( 'restrict_manage_posts', 'taxonomy_filter_restrict_manage_posts' );

function taxonomy_filter_post_type_request( $query ) {
  global $pagenow, $typenow;

  if ( 'edit.php' == $pagenow ) {
    $filters = get_object_taxonomies( $typenow );
    foreach ( $filters as $tax_slug ) {
      $var = &$query->query_vars[$tax_slug];
      if ( isset( $var ) ) {
        $term = get_term_by( 'id', $var, $tax_slug );
        $var = $term->slug;
      }
    }
  }
}

//add_filter( 'parse_query', 'taxonomy_filter_post_type_request' );


/*----------------------------------------------------------------------------------------------
[Klanten]
----------------------------------------------------------------------------------------------*/

add_action( 'init', 'create_clients' );
function create_clients() {
  $labels = array(
    'name' => _x("Klanten", 'clients'),
    'singular_name' => _x('Klant', 'clients'),
    'add_new' => _x('Nieuwe klant', 'clients')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'has_archive' => true,
    'show_ui' => true, 
    'capability_type' => 'page',
    'hierarchical' => true,
    'supports' => array( 'title', 'thumbnail'),
    'rewrite' => array('slug' => 'klant'),
    'menu_icon' => WP_PLUGIN_URL . '/decooperatiefabriek-plugin/images/clients.png'
  ); 
  register_post_type('clients',$args);
}

add_filter("manage_edit-clients_columns", "clients_edit_columns");
add_action("manage_clients_posts_custom_column", "clients_columns_display");
 
function clients_edit_columns($clients_columns){
	$clients_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Titel",
		"reference" => "Referenties",
		"thumb" => "Thumbnail",
	);
	return $clients_columns;
}

function clients_columns_display($clients_columns){
	switch ($clients_columns)
	{	
		case "thumb":
			echo the_post_thumbnail( array(50, 50) );
		break;
		case "reference":
			global $repeating_textareas;
			if(isset($repeating_textareas)){
				$meta = $repeating_textareas->the_meta();
				$i = 0;
				if(isset($meta['repeating_textareas'])) {
					foreach($meta['repeating_textareas'] as $area){
						echo $area['title'] . '<br/>';
					}
				}
			}
		break;
	}
}

function connect_clients_to_courses() {
	p2p_register_connection_type( array(
		'name' => 'clients_to_courses',
		'from' => 'clients',
		'to' => 'courses',
		'title' => 'Gevolgde miniMasters',
		'admin_box' => array(
			'show' => 'from',
			'context' => 'side'
		),
		'to_labels' => array(
			'singular_name' => __('Programma', 'coop'),
			'search_items' => __('Zoek programma', 'coop'),
			'not_found' => __('Niets gevonden.', 'coop'),
			'create' => __('Link een programma', 'coop')
		)
	) );
}
add_action( 'p2p_init', 'connect_clients_to_courses' );

function clients_attachments( $attachments )
{
 $fields         = array(
     array(
       'name'      => 'title',                         // unique field name
       'type'      => 'text',                          // registered field type
       'label'     => __( 'Titel', 'attachments' ),    // label to display
       'default'   => 'titel',                         // default value upon selection
     ),
     array(
         'name'      => 'description',                       // unique field name
         'type'      => 'textarea',                           // registered field type
         'label'     => __( 'Beschrijving', 'attachments' ),  // label to display
         'default'   => 'beschrijving',                       // default value upon selection
       ),
   );
 
   $args = array(
 
     // title of the meta box (string)
     'label'         => 'Bijlagen',
 
     // all post types to utilize (string|array)
     'post_type'     => array( 'clients' ),
 
     // meta box position (string) (normal, side or advanced)
     'position'      => 'side',
 
     // meta box priority (string) (high, default, low, core)
     'priority'      => 'low',
 
     // allowed file type(s) (array) (image|video|text|audio|application)
     'filetype'      => null,  // no filetype limit
 
     // include a note within the meta box (string)
     'note'          => 'Voeg hier de bestanden toe.',
 
     // by default new Attachments will be appended to the list
     // but you can have then prepend if you set this to false
     'append'        => true,
 
     // text for 'Attach' button in meta box (string)
     'button_text'   => __( 'Voeg bestanden toe', 'attachments' ),
 
     // text for modal 'Attach' button (string)
     'modal_text'    => __( 'Voeg toe', 'attachments' ),
 
     // which tab should be the default in the modal (string) (browse|upload)
     'router'        => 'browse',
 
     // fields array
     'fields'        => $fields,
 
   );

  $attachments->register( 'clients_attachments', $args ); // unique instance name
}

add_action( 'attachments_register', 'clients_attachments' );

/*----------------------------------------------------------------------------------------------
[Deelnemers]
----------------------------------------------------------------------------------------------*/

add_action( 'init', 'create_participants' );
function create_participants() {
  $labels = array(
    'name' => _x("Deelnemers", 'participants'),
    'singular_name' => _x('Deelnemer', 'participants'),
    'add_new' => _x('Nieuwe deelnemer', 'participants')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'has_archive' => false,
    'show_ui' => true, 
    'capability_type' => 'post',
    'hierarchical' => false,
    'supports' => array( 'title', 'editor', 'thumbnail'),
    'rewrite' => array('slug' => 'deelnemer'),
    'menu_icon' => WP_PLUGIN_URL . '/decooperatiefabriek-plugin/images/participants.png'
  ); 
  register_post_type('participants',$args);
}

add_filter("manage_edit-participants_columns", "participants_edit_columns");
add_action("manage_participants_posts_custom_column", "participants_columns_display");
 
function participants_edit_columns($participants_columns){
	$participants_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Titel",
		"thumb" => "Thumbnail",
	);
	return $participants_columns;
}

function participants_columns_display($participants_columns){
	switch ($participants_columns)
	{	
		case "thumb":
			echo the_post_thumbnail( array(50, 50) );
		break;
	}
}

/*----------------------------------------------------------------------------------------------
[Partners]
----------------------------------------------------------------------------------------------*/

add_action( 'init', 'create_partners' );
function create_partners() {
  $labels = array(
    'name' => _x("Partners", 'partners'),
    'singular_name' => _x('Partner', 'partners'),
    'add_new' => _x('Nieuwe partner', 'partners')
  );
  $args = array(
    'labels' => $labels,
    'public' => false,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'capability_type' => 'post',
    'hierarchical' => false,
    'supports' => array( 'title', 'editor', 'thumbnail'),
    'rewrite' => array('slug' => 'partner'),
    'menu_icon' => WP_PLUGIN_URL . '/decooperatiefabriek-plugin/images/partners.png'
  ); 
  register_post_type('partners',$args);
}

add_filter("manage_edit-partners_columns", "partners_edit_columns");
add_action("manage_partners_posts_custom_column", "partners_columns_display");
 
function partners_edit_columns($partners_columns){
	$partners_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Titel",
		"thumb" => "Thumbnail"
	);
	return $partners_columns;
}

function partners_columns_display($partners_columns){
	switch ($partners_columns)
	{
		case "thumb":
			echo the_post_thumbnail( array(50, 50) );
		break;
	}
}

/*----------------------------------------------------------------------------------------------
[WPAlchemy]
----------------------------------------------------------------------------------------------*/

include_once 'php/MetaBox.php';
include_once 'php/MediaAccess.php';

add_action( 'init', 'my_metabox_styles' );
function my_metabox_styles()
{
    if ( is_admin() )
    {
        wp_enqueue_style( 'wpalchemy-metabox', WP_PLUGIN_URL . '/decooperatiefabriek-plugin/css/meta.css' );
        wp_enqueue_script( 'media-upload' );
    }
}

$home_meta = new WPAlchemy_MetaBox(array
(
    'id' => 'home_meta',
    'title' => 'Inleiding',
    'template' => $plugin_dir_path . '/php/home.php',
    'include_template' => array('template-home.php'),
    'context' => 'normal'
));

$course_meta = new WPAlchemy_MetaBox(array
(
    'id' => 'course_meta',
    'title' => 'Instellingen',
    'template' => $plugin_dir_path . '/php/course.php',
	'types' => array('courses'),
    'context' => 'normal'
));

$course_reference_meta = new WPAlchemy_MetaBox(array
(
    'id' => 'course_reference_meta',
    'title' => 'Referenties',
    'template' => $plugin_dir_path . '/php/course_reference.php',
	'types' => array('courses'),
    'context' => 'side',
    'priority' => 'low'
));


$team_meta = new WPAlchemy_MetaBox(array
(
    'id' => 'team_meta',
    'title' => 'Informatie',
    'template' => $plugin_dir_path . '/php/team.php',
	'types' => array('team'),
    'context' => 'side'
));

$clients_meta = new WPAlchemy_MetaBox(array
(
    'id' => 'klanten_meta',
    'title' => 'Informatie',
    'template' => $plugin_dir_path . '/php/clients.php',
	'types' => array('clients'),
    'context' => 'normal'
));

$partners_meta = new WPAlchemy_MetaBox(array
(
    'id' => 'partners_meta',
    'title' => 'Quote',
    'template' => $plugin_dir_path . '/php/partners.php',
	'types' => array('partners'),
    'context' => 'normal'
));

$participants_meta = new WPAlchemy_MetaBox(array
(
    'id' => 'deelnemers_meta',
    'title' => 'Quote',
    'template' => $plugin_dir_path . '/php/participants.php',
	'types' => array('participants'),
    'context' => 'side'
));

$repeating_textareas = new WPAlchemy_MetaBox(array(
	'id' => '_repeating_textareas_meta',
	'title' => 'Referenties',
	'template' => dirname ( __FILE__ ). '/php/repeating-textarea.php',
	'init_action' => 'kia_metabox_init',
	'types' => array('clients')
));

function kia_metabox_init(){
	// I prefer to enqueue the styles only on pages that are using the metaboxes
	//wp_enqueue_style('wpalchemy-metabox', get_stylesheet_directory_uri() . '/wpalchemy/extra_meta.css');

	//make sure we enqueue some scripts just in case ( only needed for repeating metaboxes )
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-widget');
	wp_enqueue_script('jquery-ui-mouse');
	wp_enqueue_script('jquery-ui-sortable');
	
	// special script for dealing with repeating textareas
	wp_register_script('kia-metabox', WP_PLUGIN_URL . '/decooperatiefabriek-plugin/php/kia-metabox.js',array('jquery','editor'), '1.0');
	
	// needs to run AFTER all the tinyMCE init scripts have printed since we're going to steal their settings
	add_action('after_wp_tiny_mce','kia_metabox_scripts',999);
}

function kia_metabox_scripts(){
	wp_print_scripts('kia-metabox');
}

/* 
 * Recreate the default filters on the_content
 * this will make it much easier to output the meta content with proper/expected formatting
*/

add_filter( 'meta_content', 'wptexturize'        );
add_filter( 'meta_content', 'convert_smilies'    );
add_filter( 'meta_content', 'convert_chars'      );

//use my override wpautop
if(function_exists('override_wpautop')){
	add_filter( 'meta_content', 'override_wpautop' );
} else {
	add_filter( 'meta_content', 'wpautop'          );
}
add_filter( 'meta_content', 'shortcode_unautop'  );
add_filter( 'meta_content', 'prepend_attachment' );

add_filter('get_media_item_args', 'allow_img_insertion');
function allow_img_insertion($vars) {
    $vars['send'] = true; // 'send' as in "Send to Editor"
    return($vars);
}


$wpalchemy_media_access = new WPAlchemy_MediaAccess();

/*----------------------------------------------------------------------------------------------
[Shortcodes]
----------------------------------------------------------------------------------------------*/

/*----------------------------------------------------------------------------------------------
[Lead intro]
----------------------------------------------------------------------------------------------*/

add_shortcode('lead', 'LeadShortcode');
function LeadShortcode( $atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => 'Lead'
	), $atts));
    return '<p class="lead">' . $content .'</p>';
}

add_action('init', 'add_leadbutton');
function add_leadbutton() {
 
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
     return;
   }
 
   if ( get_user_option('rich_editing') == 'true' ) {
     add_filter( 'mce_external_plugins', 'add_plugin' );
     add_filter( 'mce_buttons', 'register_lead' );
   }
 
}
 
function register_lead( $buttons ) {
 array_push( $buttons, "lead" );
 return $buttons;
}

function add_plugin( $plugin_array ) {
   $plugin_array['lead'] = WP_PLUGIN_URL .'/decooperatiefabriek-plugin/js/leadbutton.js';
   return $plugin_array;
}

/*----------------------------------------------------------------------------------------------
[Options admin page]
----------------------------------------------------------------------------------------------*/

require_once ( $plugin_dir_path . '/php/theme-options.php' );

require_once ( $plugin_dir_path . '/php/widget-reviews.php' );

?>