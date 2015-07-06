<?php
/*
 * Template Name: Mapa: página completa
 * 
 */


?>

<html>
 <head>
<title>Mapa de <?php bloginfo('name'); ?></title>
<link rel='stylesheet' id='interface_style-css' href="<?php echo get_bloginfo('template_directory');?>/style.css?ver=4.2.2" type='text/css' media='all' />
 </head>
 <body>
<div style="position:fixed; background-color:#000000; right:0px; height:5px; left:0px; width:100%; top:0%;z-index:1000"></div>
<div style="position:fixed; background-color:#000000; right:0px; height:5px; left:0px; width:100%; bottom:0%;z-index:1000"></div>
<div style="position:fixed; background-color: #FFFFFF; right:0px; height:auto; left:0px; width:100%; bottom:7px; z-index:1000"><center><h1 id="site-title"> <a href="<?php echo get_site_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a></h1><?php echo GeoMashup::term_legend("check_all=true&format=ul&check_all=false") // Retirada línea 222 de taxonomy ?></center></div>
<div style="display:scroll;position:fixed;bottom:1%;right:1%;text-align:center;z-index: 200"></div>

<iframe style="background: transparent; left: 0px; top:5px; height: 90%; position: fixed; width: 100%; border-bottom: #C12733 3px solid; display: block; " src="<?php echo get_site_url(); ?>?geo_mashup_content=render-map&amp;height=100%&amp;width=100%&amp;map_content=global&amp;center_lng=-2.488333&amp;center_lat=42.218056&amp;&amp;name=gm-map-1" frameborder="0" allowfullscreen></iframe>

 </body>
</html>

