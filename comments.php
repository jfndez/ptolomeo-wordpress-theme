<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to interface_comment() which is
 * located in the content-extensions.php file under the function folder inside inc folder.
 *
 * @package Theme Horse
 * @subpackage Interface
 * @since Interface 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>
<?php if (!in_category('denuncia')) : ?>
<div id="comments" class="comments-area">
  <?php // You can start editing here -- including this comment! ?>
  <?php if ( have_comments() ) : ?>
  <h2 class="comments-title">
    <?php
				if( 1 == get_comments_number() ) {
					printf( __( 'Un comentario en &ldquo;%2$s&rdquo;', 'interface' ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
				}
				else {
					printf( __( '%1$s comentarios en &ldquo;%2$s&rdquo;', 'interface' ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
				}				
			?>
  </h2>
  <ol class="commentlist">
    <?php wp_list_comments( array( 'callback' => 'interface_comment', 'style' => 'ol' ) ); ?>
  </ol>
  <!-- .commentlist -->
  
  <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
  <ul class="default-wp-page clearfix">
    <h1 class="assistive-text section-heading">
      <?php _e( 'Comment navigation', 'interface' ); ?>
    </h1>
    <li class="previous">
      <?php previous_comments_link( __( '&larr; Comentarios anteriores', 'interface' ) ); ?>
    </li>
    <li class="next">
      <?php next_comments_link( __( 'Comentarios posteriores &rarr;', 'interface' ) ); ?>
    </li>
  </ul>
  <?php endif; // check for comment navigation ?>
  <?php // If comments are closed and there are comments, let's leave a little note.
		elseif ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
  <p class="nocomments">
    <?php _e( 'Los comentarios están cerrados.', 'interface' ); ?>
  </p>
  <?php endif; ?>
  <?php comment_form(); ?>
</div>
<!-- #comments .comments-area -->

<?php endif ;?>
