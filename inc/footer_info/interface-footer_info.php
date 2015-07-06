<?php
/**
 * Contains all the current date, year of the theme.
 *
 * @package Theme Horse
 * @subpackage Interface
 * @since Interface 1.0
 */
/**
 * To display the current year.
 *
 * @uses date() Gets the current year.
 * @return string
 */
function interface_the_year() {
   return date( 'Y' );
}
/**
 * To display a link back to the site.
 *
 * @uses get_bloginfo() Gets the site link
 * @return string
 */
function interface_site_link() {
   return '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
}
/**
 * To display a link to WordPress.org.
 *
 * @return string
 */
function interface_wp_link() {
   return '<a href="http://www.jose-fernandez.com.es" target="_blank" title="José Fernández: documentación & cultura digital"><span>José Fernández</span></a>. <strong><a title="Tema Ptolomeo para Wordpress" href="http://www.jose-fernandez.com.es/laboratorio/ptolomeo-cartografiar-y-documentar-con-wordpress">Tema Ptolomeo para Wordpress</a></strong>, realizado a partir del tema <a target="_blank" title="Tema Interface para Wordpress" href="http://www.themehorse.com/themes/interface/">Interface</a>';
}

?>
