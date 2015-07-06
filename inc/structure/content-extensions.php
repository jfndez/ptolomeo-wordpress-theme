<?php
/**
 * Adds content structures.
 *
 * @package 		Theme Horse
 * @subpackage 		Interface
 * @since 			Interface 1.0
 * @license 		http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link 			http://themehorse.com/themes/interface
 */

/****************************************************************************************/

add_action( 'interface_main_container', 'interface_content', 10 );
/**
 * Function to display the content for the single post, single page, archive page, index page etc.
 */
function interface_content() {
	global $post;	
	global $interface_theme_default;
	$options = $interface_theme_default;
	if( $post ) {
		$layout = get_post_meta( $post->ID, 'interface_sidebarlayout', true );
	}
	if( empty( $layout ) || is_archive() || is_search() || is_home() ) {
		$layout = 'default';
	}
   if( 'default' == $layout ) {   //checked from the themeoptions.
		$themeoption_layout = $options[ 'default_layout' ];

		if( 'left-sidebar' == $themeoption_layout ) {
			get_template_part( 'content','leftsidebar' );  //used content-leftsidebar.php
		}
		elseif( 'right-sidebar' == $themeoption_layout ) {
			get_template_part( 'content','rightsidebar' ); //used content-rightsidebar.php
		}
		else {
			get_template_part( 'content','nosidebar' ); //used content-nosidebar.php
		}
   }
   elseif( 'left-sidebar' == $layout ) { //checked from the particular page / post.
      get_template_part( 'content','leftsidebar' ); //used content-leftsidebar.php
   }
   elseif( 'right-sidebar' == $layout ) {
      get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
   }
   else {
      get_template_part( 'content','nosidebar' ); //used content-nosidebar.php
   }

}

/****************************************************************************************/

add_action( 'interface_before_loop_content', 'interface_loop_before', 10 );     
/**
 * Contains the opening div
 */
function interface_loop_before() {
	echo '<div id="content">';
}

/****************************************************************************************/

add_action( 'interface_loop_content', 'interface_theloop', 10 );
/**
 * Shows the loop content
 */
function interface_theloop() {
	if( is_page() ) {
		if( is_page_template( 'page-templates/page-template-blog-image-large.php' ) ) {
			
			interface_theloop_for_template_blog_image_large();
			
		}
		elseif( is_page_template( 'page-templates/page-template-blog-image-medium.php' ) ) {
			interface_theloop_for_template_blog_image_medium();
		}
		elseif( is_page_template( 'page-templates/page-template-blog-full-content.php' ) ) {
			
			interface_theloop_for_template_blog_full_content();
			
		}
		else {
			interface_theloop_for_page();
		}
	}
	elseif( is_single() ) {
		interface_theloop_for_single();
	}
	elseif( is_search() ) {
		interface_theloop_for_search();
	}
	
	else {
		interface_theloop_for_archive();
	}
}

/****************************************************************************************/

if ( ! function_exists( 'interface_theloop_for_archive' ) ) :
/**
 * Fuction to show the archive loop content.
 */
function interface_theloop_for_archive() {
	global $post;

	if( have_posts() ) {
		while( have_posts() ) {
			the_post();

			do_action( 'interface_before_post' );
			
?>
<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php do_action( 'interface_before_post_header' ); ?>
  <article>
    
    <header class="entry-header">
      <?php if (get_the_author() !=''){?>
      <div class="entry-meta"> <span class="cat-links">
        <?php the_category(', '); ?>
        </span><!-- .cat-links --> 
      </div>
      <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title();?></a></h1>
      <!-- .entry-title -->
      <div class="entry-meta clearfix">
        <div class="by-author vcard author"><span class="fn"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php  esc_attr(the_author()); ?>">
          <?php the_author(); ?>
          </a></span></div>
        <div class="date updated"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>">
          <?php the_time( get_option( 'date_format' ) ); ?>
          </a></div>
        <?php if ( comments_open() ) { ?>
        <div class="comments">
          <?php comments_popup_link( __( 'Sin comentarios', 'interface' ), __( '1 Comentario', 'interface' ), __( '% Comentarios', 'interface' ), '', __( 'Comments Off', 'interface' ) ); ?>
        </div>
        <?php } ?>
      </div>
  

	
      <!-- .entry-meta --> 
    </header>
    <!-- .entry-header -->
<?php
					if( has_post_thumbnail() ) {
						$image = '';        			
							$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
							$image .= '<figure class="post-featured-image">';
							$image .= '<a href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">';
							$image .= get_the_post_thumbnail( $post->ID, 'featured', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
						$image .='<span class="arrow"></span>';
							$image .= '</figure>';

							echo $image;
						}
						?>
    <div class="entry-content clearfix">
           <?php
$my_meta = get_post_meta($post->ID,'_my_meta',TRUE);

if (!empty($my_meta['name'])) {
echo '<strong>Dirección:</strong> '.$my_meta['name'].'<br>';
			}
?>

 <?php 
    $term_list = get_the_term_list( get_the_ID(), 'localidad' );
    if(!empty($term_list)):
?><strong>Localidad:</strong> <?php echo get_the_term_list( $post->ID, 'localidad', '', ', ' ); ?><?php endif ;?>


<?php 
    $term_list = get_the_term_list( get_the_ID(), 'region' );
    if(!empty($term_list)):
?>(<?php echo get_the_term_list( $post->ID, 'region', '', ', ' ); ?>)<?php endif ;?> <?php echo get_the_term_list( $post->ID, 'responsable', '<br><strong>Autoría:</strong> ', ' | ' ); ?> <?php echo get_the_term_list( $post->ID, 'fecha', '<br><strong>Fecha:</strong> ', ', ' ); ?>

<?php if ( !empty( $post->post_content) ) :?>
<?php $content = get_the_content();
      $content = strip_tags($content);
      echo '<br><br>'.substr($content, 0, 350).' [...] <br>';
?>
<?php endif ;?>
    </div>
    <!-- .entry-content -->
    <footer class="entry-meta clearfix"> <span class="tag-links">
      <?php $tag_list = get_the_tag_list( '', __( ' ', 'interface' ) );
						if(!empty($tag_list)){
					echo $tag_list;
					
						}?>
      </span><!-- .tag-links -->
      <?php
						echo '<a class="readmore" href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">'.__( 'Leer más', 'interface' ).'</a>';
						?>
    </footer>
    <!-- .entry-meta --> 
     <?php } else { ?>
   </header>
		    <?php the_content();
      } ?>
  </article>
</section>
<!-- .post -->
<?php
			do_action( 'interface_after_post' );

		}
	}
	else {
		?>
<h1 class="entry-title">
  <?php _e( 'No hay resultados para la búsqueda.', 'interface' ); ?>
</h1>
<?php
   }
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'interface_theloop_for_page' ) ) :
/**
 * Fuction to show the page content.
 */
function interface_theloop_for_page() {
	global $post;

	if( have_posts() ) {
		while( have_posts() ) {
			the_post();

			do_action( 'interface_before_post' );
?>
<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <article>
    <?php do_action( 'interface_before_post_header' ); ?>
    <?php do_action( 'interface_after_post_header' ); ?>
    <?php do_action( 'interface_before_post_content' ); ?>
    <div class="entry-content clearfix">
      <?php the_content(); ?>
	<?php if (is_page_template('page-tags.php')) : ?>

		<table>
	<tr>
		<td><?php echo wp_list_categories('taxonomy=category&echo=0&show_count=1&title_li=<h2>Categorías</h2>');?></td>
		<td><?php echo wp_list_categories('taxonomy=region&echo=0&show_count=1&title_li=<h2>Regiones</h2>');?></td>
	</tr>

	<tr>
		<td><?php echo wp_list_categories('taxonomy=localidad&echo=0&show_count=1&title_li=<h2>Localidades</h2>');?></td>
		<td><?php echo wp_list_categories('taxonomy=responsable&echo=0&show_count=1&title_li=<h2>Autores</h2>');?></td>
	</tr>

	
</table>


	<?php endif ;?>

      <?php
    				wp_link_pages( array( 
						'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'interface' ),
						'after'             => '</div>',
						'link_before'       => '<span>',
						'link_after'        => '</span>',
						'pagelink'          => '%',
						'echo'              => 1 
               ) );
    			?>
    </div>
    <!-- entry-content clearfix-->
    
    <?php 

  			do_action( 'interface_after_post_content' );

  			do_action( 'interface_before_comments_template' ); 

         comments_template(); 

         do_action ( 'interface_after_comments_template' );

         ?>
  </article>
</section>
<?php
			do_action( 'interface_after_post' );

		}
	}
	else {
		?>
<h1 class="entry-title">
  <?php _e( 'No hay resultados para la búsqueda.', 'interface' ); ?>
</h1>
<?php
   }
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'interface_theloop_for_single' ) ) :
/**
 * Fuction to show the single post content.
 */
function interface_theloop_for_single() {
	global $post;

	if( have_posts() ) {
		while( have_posts() ) {
			the_post();

			do_action( 'interface_before_post' );
?>
<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <article>
    <header class="entry-header">
      <?php if(get_the_time( get_option( 'date_format' ) )) { ?>
      <div class="entry-meta"> 
<span class="cat-links">
        <?php the_category(', '); ?>
        </span>
<h1 class="entry-title"><?php the_title();?></h1>

<div class="entry-meta clearfix">
        <div class="by-author vcard author"><span class="fn"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php  esc_attr(the_author()); ?>">
          <?php the_author(); ?>
          </a></span></div>
        <div class="date updated"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>">
          <?php the_time( get_option( 'date_format' ) ); ?>
          </a></div>
        <?php if ( comments_open() ) { ?>
        <div class="comments">
          <?php comments_popup_link( __( 'Sin comentarios', 'interface' ), __( '1 Comentario', 'interface' ), __( '% Comentarios', 'interface' ), '', __( 'Comments Off', 'interface' ) ); ?>
        </div>
        <?php } ?>
      </div>

      <!-- .entry-title -->

<?php 
    $term_list = get_the_term_list( get_the_ID(), array('localidad','region','fecha','responsable') );
    if(!empty($term_list))
:?>

<center>
<?php
	$images =& get_children( array (
		'post_parent' => $post->ID,
		'post_type' => 'attachment',
		'post_mime_type' => 'image'
	));

	if ( empty($images) ) {
		// no attachments here
	} else { echo '<br>';
		foreach ( $images as $attachment_id => $attachment ) {
			echo wp_get_attachment_link( $attachment_id, 'icon' ).' ';
		} echo '<br><br>';
	}
?></center>

<blockquote>
<?php
$my_meta = get_post_meta($post->ID,'_my_meta',TRUE);

if (!empty($my_meta['description'])) {
echo '<b>'.$my_meta['description'].'</b><br><br>';
			}

if (!empty($my_meta['name'])) {
echo '<strong>Dirección:</strong> '.$my_meta['name'].'<br>';
			}
?>

<?php 
    $term_list = get_the_term_list( get_the_ID(), 'localidad' );
    if(!empty($term_list)):
?><strong>Localidad:</strong> <?php echo get_the_term_list( $post->ID, 'localidad', '', ', ' ); ?><?php endif ;?>


<?php 
    $term_list = get_the_term_list( get_the_ID(), 'region' );
    if(!empty($term_list)):
?>(<?php echo get_the_term_list( $post->ID, 'region', '', ', ' ); ?>)<?php endif ;?> <?php echo get_the_term_list( $post->ID, 'responsable', '<br><strong>Autoría:</strong> ', ' | ' ); ?> <?php echo get_the_term_list( $post->ID, 'fecha', '<br><strong>Fecha:</strong> ', ', ' ); ?> <br>

<?php if (function_exists('geo_mashup_map')) $coords = GeoMashup::post_coordinates(); if ($coords) {echo '<strong>Coordenadas:</strong> '; echo $coords['lat']; echo ' / '; echo $coords['lng']; echo ' <a href="http://maps.google.com/maps?q=';echo $coords['lat']; echo ','; echo $coords['lng']; echo'" title="Ver en Google Maps" target="_blank">  →</a>';} ?><br>

<?php
$my_meta = get_post_meta($post->ID,'_my_meta',TRUE);

if (!empty($my_meta['fuente'])) {
echo '[<a target="_blank" title="Información complementaria en nueva pestaña" href="'.$my_meta['fuente'].'"><strong>+ info</strong></a>]<br>';
			}

?>

</blockquote>

<?php echo GeoMashup::map("width=100%&height=350&zoom=16") ?><br>
<?php 
    endif;
?>


	<!-- .cat-links --> 
      </div>
      <!-- .entry-meta -->
     
      
      <div class="entry-meta clearfix">



      <div class="entry-meta clearfix">





<?php 
    $term_list = get_the_term_list( get_the_ID(), array('localidad','region','fecha','responsable') );
    if(empty($term_list)):
?>
<?php
				if( has_post_thumbnail() ) {
					$image = '';        			
		     		$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
		     		$image .= '<figure class="">';
		  			
		  			$image .= get_the_post_thumbnail( $post->ID, 'featured', array( 'alt' => esc_attr( $title_attribute ) ) ).'';
					$image .= '</figure>';

		  			echo $image;
		  		}




	  			?>




<?php 
    endif;
?>
        
      <!-- .entry-meta --> 
    </header>
    <!-- .entry-header -->
    <?php } ?>


        
   





  


    <div class="entry-content clearfix">


      <?php the_content();
    		
               wp_link_pages( array( 
						'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'interface' ),
						'after'             => '</div>',
						'link_before'       => '<span>',
						'link_after'        => '</span>',
						'pagelink'          => '%',
						'echo'              => 1 
               ) );
               ?>
    </div>
    <?php if(get_the_time( get_option( 'date_format' ) )) { ?>
  </header>
  <?php } ?>

    <!-- entry content clearfix -->
    
    <?php if( is_single() ) {
					    $tag_list = get_the_tag_list( '', __( ' ', 'interface' ) );

						if( !empty( $tag_list ) ) { ?>
    <footer class="entry-meta clearfix"> <span class="tag-links">
      <?php
								echo $tag_list;?>
      </span><!-- .tag-links --> 
    </footer>
    <!-- .entry-meta -->
    <?php  }
    do_action( 'interface_after_post_content' );
						 
             }

    do_action( 'interface_before_comments_template' ); 

		comments_template();

    do_action ( 'interface_after_comments_template' );

		?>
  </article>
</section>
<!-- .post -->
<?php
			do_action( 'interface_after_post' );

		}
	}
	else {
		?>
<h1 class="entry-title">
  <?php _e( 'No hay resultados para la búsqueda.', 'interface' ); ?>
</h1>
<?php
   }
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'interface_theloop_for_search' ) ) :
/**
 * Fuction to show the search results.
 */
function interface_theloop_for_search() {
	global $post;

	if( have_posts() ) {
		while( have_posts() ) {
			the_post();

			do_action( 'interface_before_post' );
?>
<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <article>
    <?php do_action( 'interface_before_post_header' ); ?>
    <header class="entry-header">

	 <div class="entry-meta"> <span class="cat-links">
        <?php the_category(', '); ?>
        </span><!-- .cat-links --> 
      </div>
      <h1 class="entry-title"> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
        <?php the_title(); ?>
        </a> </h1>
<div class="entry-meta clearfix">
        <div class="by-author vcard author"><span class="fn"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php  esc_attr(the_author()); ?>">
          <?php the_author(); ?>
          </a></span></div>
        <div class="date updated"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>">
          <?php the_time( get_option( 'date_format' ) ); ?>
          </a></div>
        <?php if ( comments_open() ) { ?>
        <div class="comments">
          <?php comments_popup_link( __( 'Sin comentarios', 'interface' ), __( '1 Comentario', 'interface' ), __( '% Comentarios', 'interface' ), '', __( 'Comments Off', 'interface' ) ); ?>
        </div>
        <?php } ?>
      </div>
      <!-- .entry-title --> 
    </header>
    <?php do_action( 'interface_after_post_header' ); ?>
    <?php do_action( 'interface_before_post_content' ); ?>
<?php 
    $term_list = get_the_term_list( get_the_ID(), 'localidad' );
    if(!empty($term_list)):
?>Localidad: <?php echo get_the_term_list( $post->ID, 'localidad', '', ', ' ); ?><?php endif ;?>


<?php 
    $term_list = get_the_term_list( get_the_ID(), 'region' );
    if(!empty($term_list)):
?>(<?php echo get_the_term_list( $post->ID, 'region', '', ', ' ); ?>)<?php endif ;?> <?php echo get_the_term_list( $post->ID, 'responsable', '<br>Autoría: ', ' | ' ); ?> <?php echo get_the_term_list( $post->ID, 'fecha', '<br>Fecha: ', ', ' ); ?> <br><br>

    <div class="entry-content clearfix">
      <?php the_excerpt(); ?>
    </div>


    <?php do_action( 'interface_after_post_content' ); ?>
  </article>
</section>
<?php
			do_action( 'interface_after_post' );

		}
	}
	else {
		?>
<h1 class="entry-title">
  <?php _e( 'No hay resultados para la búsqueda.', 'interface' ); ?>
</h1>
<?php
   }
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'interface_theloop_for_template_blog_image_large' ) ) :
/**
 * Fuction to show the content of page template blog image large content.
 */
function interface_theloop_for_template_blog_image_large() {
	global $post;

   global $wp_query, $paged;
	if( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	}
	elseif( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	}
	else {
		$paged = 1;
	}
	$blog_query = new WP_Query( array( 'post_type' => 'post', 'paged' => $paged ) );
	$temp_query = $wp_query;
	$wp_query = null;
	$wp_query = $blog_query;

	if( $blog_query->have_posts() ) {
		while( $blog_query->have_posts() ) {
			$blog_query->the_post();

			do_action( 'interface_before_post' );
?>
<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php do_action( 'interface_before_post_header' ); ?>
  <article>
    <?php
				if( has_post_thumbnail() ) {
					$image = '';        			
		     		$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
		     		$image .= '<figure class="post-featured-image">';
		  			$image .= '<a href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">';
		  			$image .= get_the_post_thumbnail( $post->ID, 'featured', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
					$image .='<span class="arrow"></span>';
		  			$image .= '</figure>';

		  			echo $image;
		  		}
	  			?>
    <header class="entry-header">
      <div class="entry-meta"> <span class="cat-links">
        <?php the_category(', '); ?>
        </span><!-- .cat-links --> 
      </div>
      <!-- .entry-meta -->
      <h1 class="entry-title"> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
        <?php the_title();?>
        </a> </h1>
      <!-- .entry-title -->
      <div class="entry-meta clearfix">
        <div class="by-author vcard author"><span class="fn"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"  title="<?php  esc_attr(the_author()); ?>">
          <?php the_author(); ?>
          </a></span></div>
        <div class="date updated"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>">
          <?php the_time( get_option( 'date_format' ) ); ?>
          </a></div>
        <?php if ( comments_open() ) { ?>
        <div class="comments">
          <?php comments_popup_link( __( 'No Comments111111', 'interface' ), __( '1 Comment', 'interface' ), __( '% Comments', 'interface' ), '', __( 'Comments Off', 'interface' ) ); ?>
        </div>
        <?php } ?>
      </div>
      <!-- .entry-meta --> 
    </header>
    <!-- .entry-header -->
    <div class="entry-content clearfix">
      <?php the_excerpt(); ?>
    </div>
    <!-- .entry-content -->
    <footer class="entry-meta clearfix"> <span class="tag-links">
      <?php $tag_list = get_the_tag_list( '', __( ' ', 'interface' ) );
						if(!empty($tag_list)){
					echo $tag_list;
					
						}?>
      </span><!-- .tag-links -->
      <?php
						echo '<a class="readmore" href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">'.__( 'Leer más', 'interface' ).'</a>';
						?>
    </footer>
    <!-- .entry-meta --> 
  </article>
</section>
<!-- .post -->

<?php
			do_action( 'interface_after_post' );

		}
		if ( function_exists('wp_pagenavi' ) ) { 
			wp_pagenavi();
		}
		else {
			if ( $wp_query->max_num_pages > 1 ) {
			?>
<ul class="default-wp-page clearfix">
  <li class="previous">
    <?php next_posts_link( __( '&laquo; Anterior', 'interface' ), $wp_query->max_num_pages ); ?>
  </li>
  <li class="next">
    <?php previous_posts_link( __( 'Siguiente &raquo;', 'interface' ), $wp_query->max_num_pages ); ?>
  </li>
</ul>
<?php 
			}
		}
	}
	else {
		?>
<h1 class="entry-title">
  <?php _e( 'No hay resultados para la búsqueda.', 'interface' ); ?>
</h1>
<?php
   }
   $wp_query = $temp_query;
	wp_reset_postdata();
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'interface_theloop_for_template_blog_image_medium' ) ) :
/**
 * Fuction to show the content of page template blog image medium content. Loop con miniatura media
 */
function interface_theloop_for_template_blog_image_medium() {
	global $post;

	global $wp_query, $paged;
	if( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	}
	elseif( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	}
	else {
		$paged = 1;
	}
	$blog_query = new WP_Query( array( 'post_type' => 'post', 'paged' => $paged ) );
	$temp_query = $wp_query;
	$wp_query = null;
	$wp_query = $blog_query;

	if( $blog_query->have_posts() ) {
		while( $blog_query->have_posts() ) {
			$blog_query->the_post();

			do_action( 'interface_before_post' );
			
?>
<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php do_action( 'interface_before_post_header' ); ?>
  <article>
    <header class="entry-header">
      <div class="entry-meta"> <span class="cat-links">
        	<?php the_category(', '); ?>
        </span><!-- .cat-links --> 
      </div>
      <!-- .entry-meta -->
      <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title();?></a></h1>
      <!-- .entry-title -->
    
      <div class="entry-meta clearfix">
        <div class="by-author vcard author"><span class="fn"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php  esc_attr(the_author()); ?>">
          <?php the_author(); ?>
          </a></span></div>
        <div class="date updated"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>">
          <?php the_time( get_option( 'date_format' ) ); ?>
          </a></div>
        <?php if ( comments_open() ) { ?>
        <div class="comments">
          <?php comments_popup_link( __( 'Sin comentarios', 'interface' ), __( '1 Comentario', 'interface' ), __( '% Comentarios', 'interface' ), '', __( 'Comments Off', 'interface' ) ); ?>
        </div>
        <?php } ?>
      </div>	

	
      <!-- .entry-meta --> 
    </header>
    <!-- .entry-header -->
    <?php
					if( has_post_thumbnail() ) {
						$image = '';        			
							$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
							$image .= '<figure class="post-featured-image">';
							$image .= '<a href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">';
							$image .= get_the_post_thumbnail( $post->ID, 'featured-medium', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
						$image .='<span class="arrow"></span>';
							$image .= '</figure>';

							echo $image;
						}
						?>
    <div class="entry-content clearfix">
      <?php
$my_meta = get_post_meta($post->ID,'_my_meta',TRUE);

if (!empty($my_meta['name'])) {
echo '<strong>Dirección:</strong> '.$my_meta['name'].'<br>';
			}
?>

<?php 
    $term_list = get_the_term_list( get_the_ID(), 'localidad' );
    if(!empty($term_list)):
?><strong>Localidad:</strong> <?php echo get_the_term_list( $post->ID, 'localidad', '', ', ' ); ?><?php endif ;?>

<?php 
    $term_list = get_the_term_list( get_the_ID(), 'region' );
    if(!empty($term_list)):
?>(<?php echo get_the_term_list( $post->ID, 'region', '', ', ' ); ?>)<?php endif ;?> <?php echo get_the_term_list( $post->ID, 'responsable', '<br><strong>Autoría:</strong> ', ' | ' ); ?> <?php echo get_the_term_list( $post->ID, 'fecha', '<br><strong>Fecha:</strong> ', ', ' ); ?>
    </div>

<?php if ( !empty( $post->post_content) ) :?>
<?php $content = get_the_content();
      $content = strip_tags($content);
      echo ''.substr($content, 0, 150).' [...] <br>';
?>
<?php endif ;?>
    <!-- .entry-content -->
    <footer class="entry-meta clearfix"> <span class="tag-links">
      <?php $tag_list = get_the_tag_list( '', __( ' ', 'interface' ) );
					if(!empty($tag_list)){
				echo $tag_list;
				
					}?>
      </span><!-- .tag-links --> 
      <?php echo '<a class="readmore" href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">'.__( 'Leer más', 'interface' ).'</a>';
				?> </footer>
    <!-- .entry-meta --> 
  </article>
</section>
<!-- .post -->
<?php
			do_action( 'interface_after_post' );

		}
		if ( function_exists('wp_pagenavi' ) ) { 
			wp_pagenavi();
		}
		else {
			if ( $wp_query->max_num_pages > 1 ) {
			?>
<ul class="default-wp-page clearfix">
  <li class="previous">
    <?php next_posts_link( __( '&laquo; Entradas anteriores', 'interface' ), $wp_query->max_num_pages ); ?>
  </li>
  <li class="next">
    <?php previous_posts_link( __( 'Entradas posteriores &raquo;', 'interface' ), $wp_query->max_num_pages ); ?>
  </li>
</ul>
<?php 
			}
		}
	}
	else {
		?>
<h1 class="entry-title">
  <?php _e( 'No hay resultados para la búsqueda.', 'interface' ); ?>
</h1>
<?php
   }
   $wp_query = $temp_query;
	wp_reset_postdata();
}
endif;
/****************************************************************************************/

if ( ! function_exists( 'interface_theloop_for_template_blog_full_content' ) ) :
/**
 * Fuction to show the content of page template full content display.
 */
function interface_theloop_for_template_blog_full_content() {
	global $post;

	global $wp_query, $paged;
	if( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	}
	elseif( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	}
	else {
		$paged = 1;
	}
	$blog_query = new WP_Query( array( 'post_type' => 'post', 'paged' => $paged ) );
	$temp_query = $wp_query;
	$wp_query = null;
	$wp_query = $blog_query; 

	global $more;    // Declare global $more (before the loop).

	if( $blog_query->have_posts() ) {
		while( $blog_query->have_posts() ) {
			$blog_query->the_post();

			do_action( 'interface_before_post' );
			
?>
<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php do_action( 'interface_before_post_header' ); ?>
  <article>
    <header class="entry-header">
      <div class="entry-meta"> <span class="cat-links">
        <?php the_category(', '); ?>
        </span><!-- .cat-links --> 
      </div>
      <!-- .entry-meta -->
      <h1 class="entry-title"> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
        <?php the_title();?>
        </a> </h1>
      <!-- .entry-title -->
      <div class="entry-meta clearfix">
        <div class="by-author vcard author"><span class="fn"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"  title="<?php  esc_attr(the_author()); ?>">
          <?php the_author(); ?>
          </a></span></div>
        <div class="date updated"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>">
          <?php the_time( get_option( 'date_format' ) ); ?>
          </a></div>
        <?php if ( comments_open() ) { ?>
        <div class="comments">
          <?php comments_popup_link( __( 'No Comments333333', 'interface' ), __( '1 Comment', 'interface' ), __( '% Comments', 'interface' ), '', __( 'Comments Off', 'interface' ) ); ?>
        </div>
        <?php } ?>
      </div>
      <!-- .entry-meta --> 
    </header>
    <!-- .entry-header -->
    <div class="entry-content clearfix">
      <?php
	    				$more = 0;       // Set (inside the loop) to display content above the more tag.

	    				the_content( __( 'Leer más', 'interface' ) );

	    				wp_link_pages( array( 
							'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'interface' ),
							'after'             => '</div>',
							'link_before'       => '<span>',
							'link_after'        => '</span>',
							'pagelink'          => '%',
							'echo'              => 1 
	               ) );
	    			 ?>
    </div>
    <!-- .entry-content -->
    <?php $tag_list = get_the_tag_list( '', __( ' ', 'interface' ) );
						if(!empty($tag_list)){ ?>
    <footer class="entry-meta clearfix"> <span class="tag-links"> <?php echo $tag_list; ?> </span><!-- .tag-links --> 
    </footer>
    <!-- .entry-meta -->
    
    <?php } ?>
  </article>
</section>
<!-- .post -->
<?php
						do_action( 'interface_after_post' );
					}
					if ( function_exists('wp_pagenavi' ) ) { 
						wp_pagenavi();
					}
					else {
						if ( $wp_query->max_num_pages > 1 ) {
						?>
<ul class="default-wp-page clearfix">
  <li class="previous">
    <?php next_posts_link( __( '&laquo; Anterior', 'interface' ), $wp_query->max_num_pages ); ?>
  </li>
  <li class="next">
    <?php previous_posts_link( __( 'Siguiente &raquo;', 'interface' ), $wp_query->max_num_pages ); ?>
  </li>
</ul>
<?php 
						}
					}
				}
				else {
					?>
<h1 class="entry-title">
  <?php _e( 'No hay resultados para la búsqueda.', 'interface' ); ?>
</h1>
<?php
			   }
			   $wp_query = $temp_query;
				wp_reset_postdata();
			}
			endif;

/****************************************************************************************/

add_action( 'interface_after_loop_content', 'interface_next_previous', 5 );
/**
 * Shows the next or previous posts
 */
function interface_next_previous() {
	if( is_archive() || is_home() || is_search() ) {
		/**
		 * Checking WP-PageNaviplugin exist
		 */
		if ( function_exists('wp_pagenavi' ) ) : 
			wp_pagenavi();

		else: 
			global $wp_query;
			if ( $wp_query->max_num_pages > 1 ) : 
			?>
<ul class="default-wp-page clearfix">
  <li class="previous">
    <?php next_posts_link( __( '&laquo; Anterior', 'interface' ) ); ?>
  </li>
  <li class="next">
    <?php previous_posts_link( __( 'Siguiente &raquo;', 'interface' ) ); ?>
  </li>
</ul>
<?php
			endif;
		endif;
	}
}

/****************************************************************************************/

add_action( 'interface_after_post_content', 'interface_next_previous_post_link', 10 );
/**
 * Shows the next or previous posts link with respective names.
 */
function interface_next_previous_post_link() {
	if ( is_single() ) {
		if( is_attachment() ) {
		?>
<ul class="default-wp-page clearfix">
  <li class="previous">
    <?php previous_image_link( false, __( '&larr; Anterior', 'interface' ) ); ?>
  </li>
  <li class="next">
    <?php next_image_link( false, __( 'Siguiente &rarr;', 'interface' ) ); ?>
  </li>
</ul>
<?php
		}
		else {
		?>
<ul class="default-wp-page clearfix">
  <li class="previous">
    <?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'interface' ) . '</span> %title' ); ?>
  </li>
  <li class="next">
    <?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'interface' ) . '</span>' ); ?>
  </li>
</ul>
<?php
		}	
	}
}

/****************************************************************************************/

add_action( 'interface_after_loop_content', 'interface_loop_after', 10 );
/**
 * Contains the closing div
 */
function interface_loop_after() {
	echo '</div><!-- #content -->';
}

/****************************************************************************************/

if ( ! function_exists( 'interface_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own interface_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Interface 1.0
 */
function interface_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
  <p>
    <?php _e( 'Pingback:', 'interface' ); ?>
    <?php comment_author_link(); ?>
    <?php edit_comment_link( __( '(Edit)', 'interface' ), '<span class="edit-link">', '</span>' ); ?>
  </p>
  <?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
  <article id="comment-<?php comment_ID(); ?>" class="comment">
    <header class="comment-meta comment-author vcard">
      <?php
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( '', 'interface' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s a las %2$s', 'interface' ), get_comment_date(), get_comment_time() )
					);
				?>
    </header>
    <!-- .comment-meta -->
    
    <?php if ( '0' == $comment->comment_approved ) : ?>
    <p class="comment-awaiting-moderation">
      <?php _e( 'El comentario está pendiente de ser revisado. Disculpa las molestias.', 'interface' ); ?>
    </p>
    <?php endif; ?>
    <section class="comment-content comment">
      <?php comment_text(); ?>
      <?php edit_comment_link( __( 'Editar', 'interface' ), '<p class="edit-link">', '</p>' ); ?>
    </section>
    <!-- .comment-content -->
    
    <div class="reply">
      <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Responder <span>&darr;</span>', 'interface' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
    <!-- .reply --> 
  </article>
  <!-- #comment-## -->
  <?php
		break;
	endswitch; // end comment_type check
}
endif;

/****************************************************************************************/

add_action( 'interface_contact_page_template_content', 'interface_display_contact_page_template_content', 10 );
/**
 * Displays the contact page template content.
 */
function interface_display_contact_page_template_content() {
	global $post;

	if( have_posts() ) {
		while( have_posts() ) {
			the_post();

			do_action( 'interface_before_post' );
?>
  <div id="primary" class="no-margin-left">
    <div id="content">
      <?php do_action( 'interface_before_post_content' ); ?>
      <div class="entry-content clearfix">
        <?php the_content(); ?>
        <?php
		    				wp_link_pages( array( 
								'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'interface' ),
								'after'             => '</div>',
								'link_before'       => '<span>',
								'link_after'        => '</span>',
								'pagelink'          => '%',
								'echo'              => 1 
		               ) );
		    			?>
      </div>
      <?php 

		  			do_action( 'interface_after_post_content' );

		  			do_action( 'interface_before_comments_template' ); 

		         comments_template(); 

		         do_action ( 'interface_after_comments_template' );

					do_action( 'interface_after_post' );

				}
			}
			else {
				?>
      <h1 class="entry-title">
        <?php _e( 'No hay resultados para la búsqueda.', 'interface' ); ?>
      </h1>
      <?php
		   }
		   ?>
    </div>
    <!-- #content --> 
  </div>
  <!-- #primary -->
  
  <div id="secondary">
    <?php get_sidebar( 'contact-page' ); ?>
  </div>
  <!-- #secondary -->
  <?php		   
}

/****************************************************************************************/

add_action( 'interface_404_content', 'interface_display_404_page_content', 10 );
/**
 * Function to show the content for 404 page.
 */
function interface_display_404_page_content() {
?>
  <div id="content">
    <header class="entry-header">
      <h1 class="entry-title">
        <?php _e( 'Error 404 - Página no encontrada', 'interface' ); ?>
        </a></h1>
    </header>
    <div class="entry-content clearfix" >
      <p>
        <?php _e( 'Parece que el contenido que buscaba no existe.', 'interface' ); ?>
      </p>
      <h3>
        <?php _e( 'Esto puede ser a causa de:', 'interface' ); ?>
      </h3>
      <p>
        <?php _e( 'Se ha escrito incorrectamente la dirección o el contenido ha sido movido o eliminado.', 'interface' ); ?>
      </p>
      <h3>
        <?php _e( 'Puede intentar encontar ese contenido mediante el buscador:', 'interface' ); ?>
      </h3>
      <p>
       <?php get_search_form(); ?>
      </p>
    </div>
    <!-- .entry-content --> 
  </div>
  <!-- #content -->
  <?php
}

/****************************************************************************************/

add_action( 'interface_business_template_content', 'interface_business_template_widgetized_content');
/**
 * Displays the widget as contents
 */
function interface_business_template_widgetized_content() { ?>
  <?php if( is_active_sidebar( 'interface_business_page_sidebar' ) ) {
			echo '<div id="content">';

			// Calling the footer sidebar
			dynamic_sidebar( 'interface_business_page_sidebar' );
				
		echo '</div><!-- #content -->';
		}
		?>
  <?php
}
/****************************************************************************************/

add_action( 'interface_business_template_ourclients', 'interface_business_template_featured_image', 20 );

/**
 * Displays the widget of our clients
 */
function interface_business_template_featured_image() { ?>
  <?php if( is_active_sidebar( 'interface_business_page_our_client_sidebar' ) ) {

			// Calling the footer sidebar
			dynamic_sidebar( 'interface_business_page_our_client_sidebar' );
			
		}
}
?>
