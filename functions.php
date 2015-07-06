<?php
/**
 * Interface defining constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @package Theme Horse
 * @subpackage Interface
 * @since Interface 1.0
 */
add_action( 'after_setup_theme', 'interface_setup' );
/**
 * This content width is based on the theme structure and style.
 */
 function interface_setup() {
	 	global $content_width;
		if ( ! isset( $content_width ) ){
			$content_width = 700;
		}
 }


add_action( 'interface_init', 'interface_constants', 10 );
/**
 * This function defines the Interface theme constants
 *
 * @since 1.0
 */
function interface_constants() {

	/** Define Directory Location Constants */
	define( 'GEO_MASHUP_TERM_ORDER_FIELD', 'slug' );
	define( 'INTERFACE_PARENT_DIR', get_template_directory() );
	define( 'INTERFACE_CHILD_DIR', get_stylesheet_directory() );
	define( 'INTERFACE_IMAGES_DIR', INTERFACE_PARENT_DIR . '/images' );
	define( 'INTERFACE_INC_DIR', INTERFACE_PARENT_DIR. '/inc' );
	define( 'INTERFACE_PARENT_CSS_DIR', INTERFACE_PARENT_DIR. '/css' );
	define( 'INTERFACE_ADMIN_DIR', INTERFACE_INC_DIR . '/admin' );
	define( 'INTERFACE_ADMIN_IMAGES_DIR', INTERFACE_ADMIN_DIR . '/images' );
	define( 'INTERFACE_ADMIN_JS_DIR', INTERFACE_ADMIN_DIR . '/js' );
	define( 'INTERFACE_ADMIN_CSS_DIR', INTERFACE_ADMIN_DIR . '/css' );
	define( 'INTERFACE_JS_DIR', INTERFACE_PARENT_DIR . '/js' );
	define( 'INTERFACE_CSS_DIR', INTERFACE_PARENT_DIR . '/css' );	
	define( 'INTERFACE_FUNCTIONS_DIR', INTERFACE_INC_DIR . '/functions' );
	define( 'INTERFACE_SHORTCODES_DIR', INTERFACE_INC_DIR . '/footer_info' );
	define( 'INTERFACE_STRUCTURE_DIR', INTERFACE_INC_DIR . '/structure' );
	if ( ! defined( 'INTERFACE_LANGUAGES_DIR' ) ) /** So we can define with a child theme */
		define( 'INTERFACE_LANGUAGES_DIR', INTERFACE_PARENT_DIR . '/languages' );
	define( 'INTERFACE_WIDGETS_DIR', INTERFACE_INC_DIR . '/widgets' );

	/** Define URL Location Constants */
	define( 'INTERFACE_PARENT_URL', get_template_directory_uri() );
	define( 'INTERFACE_CHILD_URL', get_stylesheet_directory_uri() );
	define( 'INTERFACE_IMAGES_URL', INTERFACE_PARENT_URL . '/images' );
	define( 'INTERFACE_INC_URL', INTERFACE_PARENT_URL . '/inc' );
	define( 'INTERFACE_ADMIN_URL', INTERFACE_INC_URL . '/admin' );
	define( 'INTERFACE_ADMIN_IMAGES_URL', INTERFACE_ADMIN_URL . '/images' );
	define( 'INTERFACE_ADMIN_JS_URL', INTERFACE_ADMIN_URL . '/js' );
	define( 'INTERFACE_ADMIN_CSS_URL', INTERFACE_ADMIN_URL . '/css' );
	define( 'INTERFACE_JS_URL', INTERFACE_PARENT_URL . '/js' );
	define( 'INTERFACE_CSS_URL', INTERFACE_PARENT_URL . '/css' );
	define( 'INTERFACE_FUNCTIONS_URL', INTERFACE_INC_URL . '/functions' );
	define( 'INTERFACE_SHORTCODES_URL', INTERFACE_INC_URL . '/footer_info' );
	define( 'INTERFACE_STRUCTURE_URL', INTERFACE_INC_URL . '/structure' );
	if ( ! defined( 'INTERFACE_LANGUAGES_URL' ) ) /** So we can predefine to child theme */
		define( 'INTERFACE_LANGUAGES_URL', INTERFACE_PARENT_URL . '/languages' );
	define( 'INTERFACE_WIDGETS_URL', INTERFACE_INC_URL . '/widgets' );

}

add_action( 'interface_init', 'interface_load_files', 15 );
/**
 * Loading the included files.
 *
 * @since 1.0
 */
function interface_load_files() {
	/** 
	 * interface_add_files hook
	 *
	 * Adding other addtional files if needed.
	 */
	do_action( 'interface_add_files' );

	/** Load functions */
	require_once( INTERFACE_FUNCTIONS_DIR . '/i18n.php' );
	require_once( INTERFACE_FUNCTIONS_DIR . '/custom-header.php' );
	require_once( INTERFACE_FUNCTIONS_DIR . '/functions.php' );
	require_once( INTERFACE_FUNCTIONS_DIR . '/custom-style.php' );
	require_once( INTERFACE_ADMIN_DIR . '/interface-themedefaults-value.php' );
	require_once( INTERFACE_ADMIN_DIR . '/theme-option.php' );
	require_once( INTERFACE_ADMIN_DIR . '/interface-metaboxes.php' );
	

	/** Load Shortcodes */
	require_once( INTERFACE_SHORTCODES_DIR . '/interface-footer_info.php' );

	/** Load Structure */
	require_once( INTERFACE_STRUCTURE_DIR . '/header-extensions.php' );
	require_once( INTERFACE_STRUCTURE_DIR . '/searchform-extensions.php' );
	require_once( INTERFACE_STRUCTURE_DIR . '/sidebar-extensions.php' );
	require_once( INTERFACE_STRUCTURE_DIR . '/footer-extensions.php' );
	require_once( INTERFACE_STRUCTURE_DIR . '/content-extensions.php' );

	/** Load Widgets and Widgetized Area */
	require_once( INTERFACE_WIDGETS_DIR . '/interface_widgets.php' );
}

add_action( 'interface_init', 'interface_core_functionality', 20 );
/**
 * Adding the core functionality of WordPess.
 *
 * @since 1.0
 */
function interface_core_functionality() {
	/** 
	 * interface_add_functionality hook
	 *
	 * Adding other addtional functionality if needed.
	 */
	do_action( 'interface_add_functionality' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	/*
	* Let WordPress manage the document title.
	* By adding theme support, we declare that this theme does not use a
	* hard-coded <title> tag in the document head, and expect WordPress to
	* provide it for us.
	*/
	add_theme_support( 'title-tag' );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page.
	add_theme_support( 'post-thumbnails' ); 
 
	// This theme uses wp_nav_menu() in header menu location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'interface' ) );

	// Add Interface custom image sizes
	add_image_size( 'featured', 670, 300, true );
	add_image_size( 'featured-medium', 230, 160, true );
	add_image_size( 'slider-narrow', 1038, 500, true ); 		// used on Featured Slider on Homepage Header for narrow layout
	add_image_size( 'slider-wide', 1440, 500, true ); 			// used on Featured Slider on Homepage Header for wide layout
	add_image_size( 'gallery', 474, 342, true ); 				// used to show gallery all images
	add_image_size( 'icon', 100, 100, true );						//usada para galería de imágenes del post
	add_image_size( 'mini-cartografia', 150, 150, true );           //usada en ventana del mapa
	add_image_size( 'cartografia', 250, 250, true );           //usada en post
	

	/**
	 * This theme supports custom background color and image
	 */
	add_theme_support( 'custom-background' );

	// Adding excerpt option box for pages as well
	add_post_type_support( 'page', 'excerpt' );
}

/** 
 * interface_init hook
 *
 * Hooking some functions of functions.php file to this action hook.
 */
do_action( 'interface_init' );

/* Taxonomías */

add_action( 'init', 'responsable' );
function responsable() {
	register_taxonomy(
		'responsable',
		'post',
		array(
			'label' => __( 'Responsables' ),
			'rewrite' => array( 'slug' => 'responsable' ),
			'show_ui'           => true,
		        'show_admin_column' => true,
			'hierarchical' => false,
			
		     )
			);
			}
add_action( 'init', 'localidad' );
function localidad() {
	register_taxonomy(
		'localidad',
		'post',
		array(
			'label' => __( 'Localidades' ),
			'rewrite' => array( 'slug' => 'localidad' ),
			'show_ui'           => true,
		        'show_admin_column' => true,
			'hierarchical' => false,
			
		     )
			);
			}

add_action( 'init', 'region' );
function region() {
	register_taxonomy(
		'region',
		'post',
		array(
			'label' => __( 'Región' ),
			'rewrite' => array( 'slug' => 'region' ),
			'show_ui'           => true,
		        'show_admin_column' => true,
			'hierarchical' => false,
			
		     )
			);
			}

add_action( 'init', 'fecha' );
function fecha() {
	register_taxonomy(
		'fecha',
		'post',
		array(
			'label' => __( 'Fecha' ),
			'rewrite' => array( 'slug' => 'fecha' ),
			'show_ui'           => true,
		        'show_admin_column' => true,
			'hierarchical' => false,
			
		     )
			);
			}


// Permitir incluir comas en los responsables http://wordpress.stackexchange.com/questions/25043/how-can-i-allow-commas-in-tag-names
// filter for tags with comma
//  replace '--' with ', ' in the output - allow tags with comma this way
//  e.g. save tag as "Fox--Peter" but display thx 2 filters like "Fox, Peter"

if(!is_admin()){ // make sure the filters are only called in the frontend
    function comma_tag_filter($tag_arr){
        $tag_arr_new = $tag_arr;
        if($tag_arr->taxonomy == 'responsable' && strpos($tag_arr->name, '--')){
            $tag_arr_new->name = str_replace('--',', ',$tag_arr->name);
        }
        return $tag_arr_new;    
    }
    add_filter('get_post_tag', 'comma_tag_filter');

    function comma_tags_filter($tags_arr){
        $tags_arr_new = array();
        foreach($tags_arr as $tag_arr){
            $tags_arr_new[] = comma_tag_filter($tag_arr);
        }
        return $tags_arr_new;
    }
    add_filter('get_terms', 'comma_tags_filter');
    add_filter('get_the_terms', 'comma_tags_filter');
}

// search all taxonomies, based on: http://projects.jesseheap.com/all-projects/wordpress-plugin-tag-search-in-wordpress-23

function atom_search_where($where){
  global $wpdb;
  if (is_search())
    $where .= "OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish')";
  return $where;
}

function atom_search_join($join){
  global $wpdb;
  if (is_search())
    $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
  return $join;
}

function atom_search_groupby($groupby){
  global $wpdb;

  // we need to group on post ID
  $groupby_id = "{$wpdb->posts}.ID";
  if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;

  // groupby was empty, use ours
  if(!strlen(trim($groupby))) return $groupby_id;

  // wasn't empty, append ours
  return $groupby.", ".$groupby_id;
}

add_filter('posts_where','atom_search_where');
add_filter('posts_join', 'atom_search_join');
add_filter('posts_groupby', 'atom_search_groupby');


// Featured thumbnail al inicio del post http://wordpress.stackexchange.com/questions/127117/how-can-i-display-my-featured-image-correctly-inside-my-single-posts

add_filter('the_content', 'put_thumbnail_in_posting');
function put_thumbnail_in_posting($content) {
global $post;
$term_list = get_the_term_list( get_the_ID(), array('localidad','region','fecha','responsable') );
if ( !empty($term_list) && has_post_thumbnail() && ( $post->post_type == 'post' ) ) { the_post_thumbnail( '', array( 'style' => 'width:200px;float:left;margin-right:15px;' ) ); }
return $content;
}

//otrp https://wordpress.org/support/topic/how-to-display-all-the-attached-images-of-the-posts


// Añadir rel de lightbox http://wordpress.findincity.net/view/63538464303732726664889/wpgetattachmentlink-add-rel-attribute-if-the-link-points-to-direct-image
add_filter( 'wp_get_attachment_link', 'sant_prettyadd', 10, 6);

function sant_prettyadd ($content, $id, $size, $permalink, $icon, $text) {
    if ($permalink) {
    return $content;    
    }
    $content = preg_replace("/<a/","<a title='Abrir imágenes' rel=\"lightbox\"",$content,1);
    return $content;
}


// custom field metabox http://www.farinspace.com/how-to-create-custom-wordpress-meta-box/
 
define('MY_WORDPRESS_FOLDER',$_SERVER['DOCUMENT_ROOT']);
define('MY_THEME_FOLDER',str_replace("\\",'/',dirname(__FILE__)));
define('MY_THEME_PATH','/' . substr(MY_THEME_FOLDER,stripos(MY_THEME_FOLDER,'wp-content')));
 
add_action('admin_init','my_meta_init');
 
function my_meta_init()
{
    // review the function reference for parameter details
    // http://codex.wordpress.org/Function_Reference/wp_enqueue_script
    // http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 
    //wp_enqueue_script('my_meta_js', MY_THEME_PATH . '/custom/meta.js', array('jquery'));
    wp_enqueue_style('my_meta_css', MY_THEME_PATH . '/custom/meta.css');
 
    // review the function reference for parameter details
    // http://codex.wordpress.org/Function_Reference/add_meta_box
 
    // add a meta box for each of the wordpress page types: posts and pages
    foreach (array('post') as $type) 
    {
        add_meta_box('my_all_meta', 'Dirección y descripción', 'my_meta_setup', $type, 'normal', 'high');
    }
     
    // add a callback function to save any data a user enters in
    add_action('save_post','my_meta_save');
}
 
function my_meta_setup()
{
    global $post;
  
    // using an underscore, prevents the meta variable
    // from showing up in the custom fields section
    $meta = get_post_meta($post->ID,'_my_meta',TRUE);
  
    // instead of writing HTML here, lets do an include
    include(MY_THEME_FOLDER . '/custom/meta.php');
  
    // create a custom nonce for submit verification later
    echo '<input type="hidden" name="my_meta_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
}
  
function my_meta_save($post_id) 
{
    // authentication checks
 
    // make sure data came from our meta box
    if (!wp_verify_nonce($_POST['my_meta_noncename'],__FILE__)) return $post_id;
 
    // check user permissions
    if ($_POST['post_type'] == 'page') 
    {
        if (!current_user_can('edit_page', $post_id)) return $post_id;
    }
    else
    {
        if (!current_user_can('edit_post', $post_id)) return $post_id;
    }
 
    // authentication passed, save data
 
    // var types
    // single: _my_meta[var]
    // array: _my_meta[var][]
    // grouped array: _my_meta[var_group][0][var_1], _my_meta[var_group][0][var_2]
 
    $current_data = get_post_meta($post_id, '_my_meta', TRUE);  
  
    $new_data = $_POST['_my_meta'];
 
    my_meta_clean($new_data);
     
    if ($current_data) 
    {
        if (is_null($new_data)) delete_post_meta($post_id,'_my_meta');
        else update_post_meta($post_id,'_my_meta',$new_data);
    }
    elseif (!is_null($new_data))
    {
        add_post_meta($post_id,'_my_meta',$new_data,TRUE);
    }
 
    return $post_id;
}
 
function my_meta_clean(&$arr)
{
    if (is_array($arr))
    {
        foreach ($arr as $i => $v)
        {
            if (is_array($arr[$i])) 
            {
                my_meta_clean($arr[$i]);
 
                if (!count($arr[$i])) 
                {
                    unset($arr[$i]);
                }
            }
            else
            {
                if (trim($arr[$i]) == '') 
                {
                    unset($arr[$i]);
                }
            }
        }
 
        if (!count($arr)) 
        {
            $arr = NULL;
        }
    }
}

// Install plugins
include TEMPLATEPATH . '/iclt-resources/iclt-deploy.php';
 
?>
