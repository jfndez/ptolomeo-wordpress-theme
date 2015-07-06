<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package Theme Horse
 * @subpackage Interface
 * @since Interface 1.0
 */

/****************************************************************************************/

add_action( 'widgets_init', 'interface_widgets_init');
/**
 * Function to register the widget areas(sidebar) and widgets.
 */
function interface_widgets_init() {

	

	// Registering main right sidebar
	register_sidebar( array(
		'name' 				=> __( 'Barra lateral derecha', 'interface' ),
		'id' 					=> 'interface_right_sidebar',
		'description'   	=> __( 'Mostrar los widgets en la barra lateral derecha.', 'interface' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h1 class="widget-title">',
		'after_title'   	=> '</h1>'
	) );

	

	
	
	
}

?>
