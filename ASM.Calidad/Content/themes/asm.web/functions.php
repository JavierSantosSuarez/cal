<?php

load_theme_textdomain('asm.web', get_template_directory() . '/languages');
add_theme_support( 'post-thumbnails' );

global $blog_id;

function click_setup() {

    add_image_size( 'banner', 940, 300, true );
    add_image_size( 'newsletter', 200, 180, true);
    //add_image_size( 'micro', 70, 70, true );
    //add_image_size( 'micro', 70, 70, true );
  
}


add_action( 'init', 'click_setup' );



add_action('admin_menu', 'tarificador');

function tarificador() {
   add_menu_page('Tarificador', 'Tarificador', 'publish_posts', 'tarificador', 'tarificador_manager', '', 25);
}

function tarificador_manager(){ include 'manager.php'; }


add_action('admin_menu', 'newsletter');

function newsletter() {
   add_menu_page('Newsletter', 'Newsletter', 'publish_posts', 'newsletter', 'newsletter_manager', '', 30);
}

function newsletter_manager(){ include 'newsletter.php'; }








if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'menu' => 'Menú principal'
		)
	);
}

$args = array(
	'name'          => 'Barra lateral',
	'id'            => 'sidebar',
	'description'   => '',
	'before_widget' => '<div id="%1$s" class="widget %2$s block detach"><div class="inside">',
	'after_widget'  => '</div></div>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>' );
	
register_sidebar($args);

/* Custom Post Type for Banners */

add_action( 'init', 'asm_hero' );
function asm_hero() {
	register_post_type( 'banner',
		array(
			'labels' => array(
				'name' => __( 'Banners' ),
				'singular_name' => __( 'Banner' )
			),
			'public' => true,
			'has_archive' => false,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		)
	);
}





add_action( 'init', 'create_book_taxonomies', 0 );


function create_book_taxonomies() 
{
  
  $labels = array(
    'name' => _x( 'Ubicaciones', 'taxonomy general name' ),
    'singular_name' => _x( 'Ubicación', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar' ),
    'all_items' => __( 'Todass' ),
    'parent_item' => __( 'Parent' ),
    'parent_item_colon' => __( 'Parent:' ),
    'edit_item' => __( 'Editar' ), 
    'update_item' => __( 'Actualizar' ),
    'add_new_item' => __( 'Nueva' ),
    'new_item_name' => __( 'Nombre' ),
    'menu_name' => __( 'Ubicaciones' ),
  ); 	

  register_taxonomy('ubicaciones',array('banner'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'genre' ),
  ));

}






add_shortcode( 'include', 'include_html' );

function include_html($atts, $content = null){
	$page = $atts['page'];
	
	
		include $page; 
	
}



function get_post_picture($postid,$size='large'){
	
	if(has_post_thumbnail($postid)){
		$image_id = get_post_thumbnail_id($postid);  
		$image_url = wp_get_attachment_image_src($image_id,$size);  
		$image_url = $image_url[0];
	} else {
	
		if( function_exists( 'attachments_get_attachments' ) ){
	  
	  		$attachments = attachments_get_attachments($postid);
	  		$total_attachments = count( $attachments );
	  
	 
	  		$image = wp_get_attachment_image_src( $attachments[0]['id'], $size, true ); 
	  		$image = $image[0];
	  
	  		if($image){
		  		$image_url = $image;
	 		} else {
	 			$image_url = false;
	 		} 
	  
		} // end if function exists
	
	} //end if thumbnail
	
	
	$default = get_bloginfo('url').'/wp-includes/images/crystal/default.png';
	//If the default picture is returned, ignore it and return false.
	if($image_url == $default){
		return false;
	} else {
		return $image_url;
	}

}

include 'widgets/youtube.php';
include 'widgets/banners.php';

function get_pagelink($place){
	$option = "asm_loc_".$place;
	$pageid = get_option($option);
	
	$link = get_permalink($pageid);
	
	return $link;
	
}




function remove_dashboard_widgets() {
	

	global $wp_meta_boxes;

	
	if(!current_user_can('administrator')):
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	endif;
} 



add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );





function remove_menu_pages() {
if(!current_user_can('administrator')):
		remove_menu_page('link-manager.php');
		remove_menu_page('themes.php');
		remove_menu_page('plugins.php');
		remove_menu_page('users.php');
		remove_menu_page('tools.php');
		remove_menu_page('options-general.php');
		remove_menu_page('profile.php');
endif;	
}
add_action( 'admin_menu', 'remove_menu_pages' );


function custom_colors() {
 if(!current_user_can('administrator')):  echo '<style type="text/css">
           #misc-publishing-actions {display:none;}
         </style>';
 endif;
}

add_action('admin_head', 'custom_colors');




function remove_meta_boxes() {
if(!current_user_can('administrator')):
  remove_meta_box('linktargetdiv', 'link', 'normal');
  remove_meta_box('linkxfndiv', 'link', 'normal');
  remove_meta_box('linkadvanceddiv', 'link', 'normal');
  remove_meta_box('postexcerpt', 'post', 'normal');
  remove_meta_box('trackbacksdiv', 'post', 'normal');
  remove_meta_box('commentstatusdiv', 'post', 'normal');
  remove_meta_box('postcustom', 'post', 'normal');
  remove_meta_box('commentstatusdiv', 'post', 'normal');
  remove_meta_box('commentsdiv', 'post', 'normal');
  remove_meta_box('revisionsdiv', 'post', 'normal');
  remove_meta_box('authordiv', 'post', 'normal');
  remove_meta_box('sqpt-meta-tags', 'post', 'normal');
  remove_meta_box('slugdiv','post','normal');
  remove_meta_box('tagsdiv-post_tag','post','normal');
 endif;
}
add_action( 'admin_menu', 'remove_meta_boxes' );

