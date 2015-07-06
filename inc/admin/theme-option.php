<?php
/**
 * Interface Theme Options
 *
 * Contains all the function related to theme options.
 *
 * @package Theme Horse
 * @subpackage Interface
 * @since Interface 1.0
 */

/****************************************************************************************/

add_action( 'admin_enqueue_scripts', 'interface_jquery_javascript_file_cookie' );
/**
 * Register jquery cookie javascript file.
 *
 * jquery cookie used for remembering admin tabs, and potential future features... so let's register it early
 *
 * @uses wp_register_script
 */
function interface_jquery_javascript_file_cookie() {
   wp_register_script( 'jquery-cookie', INTERFACE_ADMIN_JS_URL . '/jquery.cookie.min.js', array( 'jquery' ) );
   wp_enqueue_style('thickbox');

    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
}

/****************************************************************************************/

add_action( 'admin_print_scripts-appearance_page_theme_options', 'interface_admin_scripts' );
/**
 * Enqueuing some scripts.
 *
 * @uses wp_enqueue_script to register javascripts.
 * @uses wp_enqueue_script to add javascripts to WordPress generated pages.
 */
function interface_admin_scripts() {
   wp_enqueue_script( 'interface_admin', INTERFACE_ADMIN_JS_URL . '/admin.js', array( 'jquery', 'jquery-ui-tabs', 'jquery-cookie', 'jquery-ui-sortable', 'jquery-ui-draggable' ) );
   wp_enqueue_script( 'interface_toggle_effect', INTERFACE_ADMIN_JS_URL . '/toggle-effect.js' );
   wp_enqueue_script( 'interface_image_upload', INTERFACE_ADMIN_JS_URL . '/add-image-script.js', array( 'jquery','media-upload', 'thickbox' ) );
}

/****************************************************************************************/

add_action( 'admin_print_styles-appearance_page_theme_options', 'interface_admin_styles' );
/**
 * Enqueuing some styles.
 *
 * @uses wp_enqueue_style to register stylesheets.
 * @uses wp_enqueue_style to add styles.
 */
function interface_admin_styles() {
	wp_enqueue_style( 'thickbox' );
	wp_enqueue_style( 'interface_admin_style', INTERFACE_ADMIN_CSS_URL. '/admin.css' );
}

/****************************************************************************************/

add_action( 'admin_print_styles-appearance_page_theme_options', 'interface_social_script', 100);
/**
 * Facebook, twitter script hooked at head
 * 
 * @useage for Facebook, Twitter and Print Script 
 * @Use add_action to display the Script on header
 */
function interface_social_script() { ?>
<!-- Facebook script -->


<div id="fb-root"></div>
<script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=284802028306078";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script> 

<!-- Twitter script --> 
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> 

<!-- Print Script --> 
<script src="http://cdn.printfriendly.com/printfriendly.js" type="text/javascript"></script>
<?php     
}

/****************************************************************************************/

add_action( 'admin_menu', 'interface_options_menu' );
/**
 * Create sub-menu page.
 *
 * @uses add_theme_page to add sub-menu under the Appearance top level menu.
 */
function interface_options_menu() {
    
	add_theme_page( 
		__( 'Opciones del tema', 'interface' ),           // Name of the page
		__( 'Opciones del tema', 'interface' ),           // Label in menu (Inside apperance)
		'edit_theme_options',                         // Capability 
		'theme_options',                              // Menu slug, which is used to define uniquely the page
		'interface_theme_options_add_theme_page'      // Function used to rendrs the options page
	);

}

/****************************************************************************************/

add_action( 'admin_init', 'interface_register_settings' );
	/**
		* Register options and function call back of validation
		*
		* this three options interface_theme_options', 'interface_theme_options', 'interface_theme_options_validate'
		* first parameter interface_theme_options  =>    To set all field eg:- social link, design options etc.
		* second parameter interface_theme_options =>	 Option value to sanitize and save. array values etc. can be called global 
		* third parameter interface_theme_options  => 	 Call back function
		* @uses register_setting
	*/
function interface_register_settings() {
   register_setting( 'interface_theme_options', 'interface_theme_options', 'interface_theme_options_validate' );
 
}

/****************************************************************************************/
/**
 * Render the options page
 */
function interface_theme_options_add_theme_page() {
?>
<div class="them_option_block clearfix">
  <div class="theme_option_title">
    <h2>
      Opciones
    </h2>
  </div>
  
<br/>
<br/>
<br/>

<div id="themehorse" class="wrap">
  <form method="post" action="options.php">
    <?php
			/**
			* should match with the register_settings first parameter of line no 117
			*/
				settings_fields( 'interface_theme_options' ); 
				global $interface_theme_default;
				$options = $interface_layouttheme_default;             
			?>
    <?php if( isset( $_GET [ 'settings-updated' ] ) && 'true' == $_GET[ 'settings-updated' ] ): ?>
    <div class="updated" id="message">
      <p><strong>
        <?php _e( 'Settings saved.', 'interface' );?>
        </strong></p>
    </div>
    <?php endif; ?>
    <div id="interface_tabs">
      
      <!-- .tab-navigation #main-navigation --> 
      <!-- Option for Design Options -->
      <div id="responsivelayout">
        
        
        
      <!-- #Responsive Layout -->
      <div id="designoptions">
        <div class="option-container">
          <h3 class="option-toggle"><a href="#">
            <?php _e( 'Cabecera', 'interface' ); ?>
            </a></h3>
          <div class="option-content inside">
            <table class="form-table">
              <tbody>
                <tr>
                  <th scope="row"><label for="header_logo">
                      <?php _e( 'Logo', 'interface' ); ?>
                    </label></th>
                  <td><input class="upload" size="65" type="text" id="header_logo" name="interface_theme_options[header_logo]" value="<?php echo esc_url( $options [ 'header_logo' ] ); ?>" />
                    <input class="upload-button button" name="image-add" type="button" value="<?php esc_attr_e( 'Cambiar logo', 'interface' ); ?>" /></td>
                </tr>
                <tr>
                  <th scope="row"><?php _e( 'Previo', 'interface' ); ?></th>
                  <td><?php
										       echo '<img src="'.esc_url( $options[ 'header_logo' ] ).'" alt="'.__( 'Logo', 'interface' ).'" />';
										   ?></td>
                </tr>
                <tr>
                  <th scope="row"><label>
                      <?php _e( 'Mostrar', 'interface' ); ?>
                    </label></th>
                  <td><?php // interface_theme_options[header_show] this is defined in register_setting second parameter?>
                    <input type="radio" name="interface_theme_options[header_show]" id="header-logo" <?php checked($options['header_show'], 'header-logo') ?> value="header-logo"  />
                    <?php _e( 'Sólo el logo', 'interface' ); ?>
                    </br>
                    <input type="radio" name="interface_theme_options[header_show]" id="header-text" <?php checked($options['header_show'], 'header-text') ?> value="header-text"  />
                    <?php _e( 'Sólo el texto', 'interface' ); ?>
                    </br>
                    <input type="radio" name="interface_theme_options[header_show]" id="header-text" <?php checked($options['header_show'], 'disable-both') ?> value="disable-both"  />
                    <?php _e( 'Deshabilitar', 'interface' ); ?>
                    </br></td>
                </tr>
                <tr>
                  <th> <?php _e( '¿Necesitas cambiar el logo?', 'interface' ); ?>
                  </th>
                  <td><?php printf( __('<a class="button" href="%s">Haz click aquí</a>', 'interface' ), admin_url('themes.php?page=custom-header')); ?></td>
                </tr>
                <tr>
                  <th scope="row"><?php _e( 'Ocultar buscador de la cabecera', 'interface' ); ?></th>
                  <input type='hidden' value='0' name='interface_theme_options[hide_header_searchform]'>
                  <td><input type="checkbox" id="headerlogo" name="interface_theme_options[hide_header_searchform]" value="1" <?php checked( '1', $options['hide_header_searchform'] ); ?> />
                    <?php _e('Selecionar para ocultar', 'interface'); ?></td>
                </tr>
              </tbody>
            </table>
            <p class="submit">
              <input type="submit" class="button-primary" value="<?php esc_attr_e( 'Guardar todos los cambios', 'interface' ); ?>" />
            </p>
          </div>
          <!-- .option-content --> 
        </div>
        <!-- .option-container -->
        
        <div class="option-container">
          <h3 class="option-toggle"><a href="#">
            <?php _e( 'Favicon', 'interface' ); ?>
            </a></h3>
          <div class="option-content inside">
            <table class="form-table">
              <tbody>
                <tr>
                  <th scope="row"><label for="disable_favicon">
                      <?php _e( 'Deshabilitar el favicon', 'interface' ); ?>
                    </label></th>
                  <input type='hidden' value='0' name='interface_theme_options[disable_favicon]'>
                  <td><input type="checkbox" id="disable_favicon" name="interface_theme_options[disable_favicon]" value="1" <?php checked( '1', $options['disable_favicon'] ); ?> />
                    <?php _e('Seleccionar para deshabilitar', 'interface'); ?></td>
                </tr>
                <tr>
                  <th scope="row"><label for="fav_icon_url">
                      <?php _e( 'Favicon URL', 'interface' ); ?>
                    </label></th>
                  <td><input class="upload" size="65" type="text" id="fav_icon_url" name="interface_theme_options[favicon]" value="<?php echo esc_url( $options [ 'favicon' ] ); ?>" />
                    <input class="upload-button button" name="image-add" type="button" value="<?php esc_attr_e( 'Cambiar el favicon', 'interface' ); ?>" /></td>
                </tr>
                <tr>
                  <th scope="row"><?php _e( 'Previo', 'interface' ); ?></th>
                  <td><?php
										       echo '<img src="'.esc_url( $options[ 'favicon' ] ).'" alt="'.__( 'favicon', 'interface' ).'" />';
										   ?></td>
                </tr>
              </tbody>
            </table>
            <p class="submit">
              <input type="submit" class="button-primary" value="<?php esc_attr_e( 'Guardar todos los cambios', 'interface' ); ?>" />
            </p>
          </div>
          <!-- .option-content --> 
        </div>
        <!-- .option-container -->
        
        
        
        <!-- .option-container -->
        
        
      </div>
      <!-- #designoptions --> 
      <!-- Options for Theme Options -->
      <div id="advancedoptions">
        <div class="option-container">
          <h3 class="option-toggle"><a href="#">
            <?php _e( 'Lema de la portada', 'interface' ); ?>
            </a></h3>
          <div class="option-content inside">
            <table class="form-table">
              <tbody>
                <tr>
                  <th scope="row"> <label for="slogan">
                      <?php _e( 'Deshabilitar lema', 'interface' ); ?>
                    </label>
                  </th>
                  <input type='hidden' value='0' name='interface_theme_options[disable_slogan]'>
                  <td><input type="checkbox" id="slogan" name="interface_theme_options[disable_slogan]" value="1" <?php checked( '1', $options['disable_slogan'] ); ?> />
                    <?php _e('Seleccionar para deshabilitar', 'interface'); ?></td>
                
                <tr>
                  <th scope="row"><label for="slogan_1">
                      <?php _e( 'Lema principal', 'interface' ); ?>
                    </label>
                    <p><small>
                      <?php _e( 'Alrededor de 10 palabras.', 'interface' ); ?>
                      </small></p>
                  </th>
                  <td><textarea class="textarea input-bg" id="slogan_1" name="interface_theme_options[home_slogan1]" cols="60" rows="3"><?php echo esc_textarea( $options[ 'home_slogan1' ] ); ?></textarea></td>
                </tr>
                <tr>
                  <th scope="row"><label for="slogan_2">
                      <?php _e( 'Lema secundario', 'interface' ); ?>
                    </label>
                    <p><small>
                      <?php _e( 'Alrededor de 10 palabras.', 'interface' ); ?>
                      </small></p>
                  </th>
                  <td><textarea class="textarea input-bg" id="slogan_2" name="interface_theme_options[home_slogan2]" cols="60" rows="3"><?php echo esc_textarea( $options[ 'home_slogan2' ] ); ?></textarea></td>
                </tr>
              </tbody>
            </table>
            <p class="submit">
              <input type="submit" class="button-primary" value="<?php esc_attr_e( 'Guardar todos los cambios', 'interface' ); ?>" />
            </p>
          </div>
          <!-- .option-content --> 
        </div>
        <!-- .option-container -->
        <!-- #advancedoptions --> 
      <!-- Option for Featured Post Slier -->
      <div id="featuredpostslider"> 
        
      <!-- #featuredpostslider --> 
      <!-- Option for Design Settings -->
      <div id="sociallink">
        
        <!-- .option-container -->
        
        <?php 
						$social_links = array(); 
						$social_links_name = array();
						$social_links_name = array( __( 'Facebook', 'interface' ),
													__( 'Twitter', 'interface' ),
													__( 'Google Plus', 'interface' ),
													__( 'Pinterest', 'interface' ),
													__( 'Youtube', 'interface' ),
													__( 'Vimeo', 'interface' ),
													__( 'LinkedIn', 'interface' ),
													__( 'Flickr', 'interface' ),
													__( 'Tumblr', 'interface' ),
													__( 'RSS', 'interface' )
													);
						$social_links = array( 	'Facebook' 		=> 'social_facebook',
														'Twitter' 		=> 'social_twitter',
														'Google-Plus'	=> 'social_googleplus',
														'Pinterest' 	=> 'social_pinterest',
														'You-tube'		=> 'social_youtube',
														'Vimeo'			=> 'social_vimeo',
														'linkedin'			=> 'social_linkedin',
														'Flickr'			=> 'social_flickr',
														'Tumblr'			=> 'social_tumblr',
														'RSS'				=> 'social_rss' 
													);
					?>
        <div class="option-container">
          <h3 class="option-toggle"><a href="#">
            <?php _e( 'Enlaces a redes sociales', 'interface' ); ?>
            </a></h3>
          <div class="option-content inside">
            <table class="form-table">
              <tbody>
                <?php
						$i = 0;
						foreach( $social_links as $key => $value ) {
						?>
                <tr>
                  <th scope="row" style="padding: 0px;"><h4><?php printf( __( '%s', 'interface' ), $social_links_name[ $i ] ); ?></h4></th>
                  <td><input type="text" size="45" name="interface_theme_options[<?php echo $value; ?>]" value="<?php echo esc_url( $options[$value] ); ?>" /></td>
                </tr>
                <?php
						$i++;
						}
						?>
              </tbody>
            </table>
            <p class="submit">
              <input type="submit" class="button-primary" value="<?php esc_attr_e( 'Guardar todos los cambios', 'interface' ); ?>" />
            </p>
          </div>
        </div>
      </div>
      <!-- #sociallink --> 
    </div>
    <!-- #interface_tabs -->
  </form>
</div>
<!-- .wrap -->
<?php
}

/****************************************************************************************/

/**
 * Validate all theme options values
 * 
 * @uses esc_url_raw, absint, esc_textarea, sanitize_text_field, interface_invalidate_caches
 */
function interface_theme_options_validate( $options ) { //validate individual options before saving. using register_setting 3rd parameter interface_theme_options_validate
	global $interface_theme_default, $interface_default;
	$validated_input_values = $interface_theme_default;
	$input = array();
	$input = $options;

	if ( isset( $input[ 'header_logo' ] ) ) {
		$validated_input_values[ 'header_logo' ] = esc_url_raw( $input[ 'header_logo' ] );
	}
										//esc_url_raw -> To save at the databaseSSSS
										// esc_url -> to echo the url
										//sanitize_text_field -> for normal text only if you dont want html text.
	if( isset( $input[ 'header_show' ] ) ) {
		$validated_input_values[ 'header_show' ] = $input[ 'header_show' ];
	}

   if ( isset( $options[ 'hide_header_searchform' ] ) ) {
		$validated_input_values[ 'hide_header_searchform' ] = $input[ 'hide_header_searchform' ];
	}
    
	if ( isset( $options[ 'disable_slogan' ] ) ) {
		$validated_input_values[ 'disable_slogan' ] = $input[ 'disable_slogan' ];
	}

	if( isset( $options[ 'home_slogan1' ] ) ) {
		$validated_input_values[ 'home_slogan1' ] = sanitize_text_field( $input[ 'home_slogan1' ] );
	}

	if( isset( $options[ 'home_slogan2' ] ) ) {
		$validated_input_values[ 'home_slogan2' ] = sanitize_text_field( $input[ 'home_slogan2' ] );
	}

	if( isset( $input[ 'slogan_position' ] ) ) {
		$validated_input_values[ 'slogan_position' ] = $input[ 'slogan_position' ];
	}	

	if( isset( $options[ 'button_text' ] ) ) {
		$validated_input_values[ 'button_text' ] = sanitize_text_field( $input[ 'button_text' ] );
	}

	if( isset( $options[ 'redirect_button_link' ] ) ) {
		$validated_input_values[ 'redirect_button_link' ] = esc_url_raw( $input[ 'redirect_button_link' ] );
	}
        
	if ( isset( $input[ 'favicon' ] ) ) {
		$validated_input_values[ 'favicon' ] = esc_url_raw( $input[ 'favicon' ] );
	}

	if ( isset( $input['disable_favicon'] ) ) {
		$validated_input_values[ 'disable_favicon' ] = $input[ 'disable_favicon' ];
	}

	if ( isset( $input[ 'webpageicon' ] ) ) {
		$validated_input_values[ 'webpageicon' ] = esc_url_raw( $input[ 'webpageicon' ] );
	}

	if ( isset( $input['disable_webpageicon'] ) ) {
		$validated_input_values[ 'disable_webpageicon' ] = $input[ 'disable_webpageicon' ];
	}

	//Site Layout
	if( isset( $input[ 'site_layout' ] ) ) {
		$validated_input_values[ 'site_layout' ] = $input[ 'site_layout' ];
	}

   // Front page posts categories
	if( isset( $input['front_page_category' ] ) ) {
		$validated_input_values['front_page_category'] = $input['front_page_category'];
	}
    
	// Data Validation for Featured Slider
	if( isset( $input[ 'disable_slider' ] ) ) {
		$validated_input_values[ 'disable_slider' ] = $input[ 'disable_slider' ];
	}

	if ( isset( $input[ 'slider_quantity' ] ) ) {
		$validated_input_values[ 'slider_quantity' ] = absint( $input[ 'slider_quantity' ] ) ? $input [ 'slider_quantity' ] : 4;
	}
	if ( isset( $input['exclude_slider_post'] ) ) {
		$validated_input_values[ 'exclude_slider_post' ] = $input[ 'exclude_slider_post' ];	

	}
	if ( isset( $input[ 'featured_post_slider' ] ) ) {
		$validated_input_values[ 'featured_post_slider' ] = array();
	}   
	if( isset( $input[ 'slider_quantity' ] ) )   
	for ( $i = 1; $i <= $input [ 'slider_quantity' ]; $i++ ) {
		if ( intval( $input[ 'featured_post_slider' ][ $i ] ) ) {
			$validated_input_values[ 'featured_post_slider' ][ $i ] = absint($input[ 'featured_post_slider' ][ $i ] );
		}
	}  
	
	
	
   // data validation for transition effect
	if( isset( $input[ 'transition_effect' ] ) ) {
		$validated_input_values['transition_effect'] = wp_filter_nohtml_kses( $input['transition_effect'] );
	}

	// data validation for transition delay
	if ( isset( $input[ 'transition_delay' ] ) && is_numeric( $input[ 'transition_delay' ] ) ) {
		$validated_input_values[ 'transition_delay' ] = $input[ 'transition_delay' ];
	}

	// data validation for transition length
	if ( isset( $input[ 'transition_duration' ] ) && is_numeric( $input[ 'transition_duration' ] ) ) {
		$validated_input_values[ 'transition_duration' ] = $input[ 'transition_duration' ];
	}
    
   // data validation for Social Icons

   if ( isset( $input['disable_top'] ) ) {
		$validated_input_values[ 'disable_top' ] = $input[ 'disable_top' ];
	}
	 if ( isset( $input['disable_bottom'] ) ) {
		$validated_input_values[ 'disable_bottom' ] = $input[ 'disable_bottom' ];
	}
   if ( isset( $input[ 'social_phone' ] ) ) {
		$validated_input_values[ 'social_phone' ] = preg_replace("/[^() 0-9+-]/", '', $options[ 'social_phone' ]);
	}

	if( isset( $input[ 'social_email' ] ) ) {
		$validated_input_values[ 'social_email' ] = sanitize_email( $input[ 'social_email' ] );
	}
	if( isset( $input[ 'social_location' ] ) ) {
		$validated_input_values[ 'social_location' ] = sanitize_text_field( $input[ 'social_location' ] );
	}

	if( isset( $input[ 'social_facebook' ] ) ) {
		$validated_input_values[ 'social_facebook' ] = esc_url_raw( $input[ 'social_facebook' ] );
	}
	if( isset( $input[ 'social_twitter' ] ) ) {
		$validated_input_values[ 'social_twitter' ] = esc_url_raw( $input[ 'social_twitter' ] );
	}
	if( isset( $input[ 'social_googleplus' ] ) ) {
		$validated_input_values[ 'social_googleplus' ] = esc_url_raw( $input[ 'social_googleplus' ] );
	}
	if( isset( $input[ 'social_pinterest' ] ) ) {
		$validated_input_values[ 'social_pinterest' ] = esc_url_raw( $input[ 'social_pinterest' ] );
	}   
	if( isset( $input[ 'social_youtube' ] ) ) {
		$validated_input_values[ 'social_youtube' ] = esc_url_raw( $input[ 'social_youtube' ] );
	}
	if( isset( $input[ 'social_vimeo' ] ) ) {
		$validated_input_values[ 'social_vimeo' ] = esc_url_raw( $input[ 'social_vimeo' ] );
	}   
	if( isset( $input[ 'social_linkedin' ] ) ) {
		$validated_input_values[ 'social_linkedin' ] = esc_url_raw( $input[ 'social_linkedin' ] );
	}
	if( isset( $input[ 'social_flickr' ] ) ) {
		$validated_input_values[ 'social_flickr' ] = esc_url_raw( $input[ 'social_flickr' ] );
	}
	if( isset( $input[ 'social_tumblr' ] ) ) {
		$validated_input_values[ 'social_tumblr' ] = esc_url_raw( $input[ 'social_tumblr' ] );
	}   
	if( isset( $input[ 'social_myspace' ] ) ) {
		$validated_input_values[ 'social_myspace' ] = esc_url_raw( $input[ 'social_myspace' ] );
	}  
	if( isset( $input[ 'social_rss' ] ) ) {
		$validated_input_values[ 'social_rss' ] = esc_url_raw( $input[ 'social_rss' ] );
	}   

	//Custom CSS Style Validation
	if ( isset( $input['custom_css'] ) ) {
		$validated_input_values['custom_css'] = wp_filter_nohtml_kses($input['custom_css']);
	}

	if( isset( $input[ 'site_design' ] ) ) {
		$validated_input_values[ 'site_design' ] = $input[ 'site_design' ];
	}   
	
	if( isset( $input[ 'slider_content' ] ) ) {
		$validated_input_values[ 'slider_content' ] = $input[ 'slider_content' ];
	} 
    
	// Layout settings verification
	if( isset( $input[ 'reset_layout' ] ) ) {
		$validated_input_values[ 'reset_layout' ] = $input[ 'reset_layout' ];
	}
	if( 0 == $validated_input_values[ 'reset_layout' ] ) {
		if( isset( $input[ 'default_layout' ] ) ) {
			$validated_input_values[ 'default_layout' ] = $input[ 'default_layout' ];
		}
	}
	else {
		$validated_input_values['default_layout'] = $interface_default[ 'default_layout' ];
	}

	
    
	
    
   return $validated_input_values;
}
function interface_themeoption_invalidate_caches(){
	
	delete_transient( 'interface_socialnetworks' );  
	
}

/*	 _e() -> to echo the text
*	 __() -> to get the value
*	 printf () -> to echo the value eg:- my name is $name
*	 eg:- printf( __( 'Your city is %1$s, and your zip code is %2$s.', 'my-text-domain' ), $city, $zipcode );
*	 sprintf() - > to get the value 
* 	 eg:- $url = 'http://example.com';
*	 $link = sprintf( __( 'Check out this link to my <a href="%s">website</a> made with WordPress.', 'my-text-domain' ), esc_url( $url ) );
*	 echo $link;
*/

?>
