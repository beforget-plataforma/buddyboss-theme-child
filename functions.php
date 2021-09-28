<?php
/**
 * @package BuddyBoss Child
 * The parent theme functions are located at /buddyboss-theme/inc/theme/functions.php
 * Add your own functions at the bottom of this file.
 */


/****************************** THEME SETUP ******************************/

/**
 * Sets up theme for translation
 *
 * @since BuddyBoss Child 1.0.0
 */
function buddyboss_theme_child_languages()
{
  /**
   * Makes child theme available for translation.
   * Translations can be added into the /languages/ directory.
   */

  // Translate text from the PARENT theme.
  load_theme_textdomain( 'buddyboss-theme', get_stylesheet_directory() . '/languages' );

  // Translate text from the CHILD theme only.
  // Change 'buddyboss-theme' instances in all child theme files to 'buddyboss-theme-child'.
  // load_theme_textdomain( 'buddyboss-theme-child', get_stylesheet_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'buddyboss_theme_child_languages' );

/**
 * Enqueues scripts and styles for child theme front-end.
 *
 * @since Boss Child Theme  1.0.0
 */
function buddyboss_theme_child_scripts_styles()
{
  /**
   * Scripts and Styles loaded by the parent theme can be unloaded if needed
   * using wp_deregister_script or wp_deregister_style.
   *
   * See the WordPress Codex for more information about those functions:
   * http://codex.wordpress.org/Function_Reference/wp_deregister_script
   * http://codex.wordpress.org/Function_Reference/wp_deregister_style
   **/

  // Styles
  wp_enqueue_style( 'buddyboss-child-css', get_stylesheet_directory_uri().'/assets/css/custom.css', '', '1.0.0' );

  // Javascript
  wp_enqueue_script( 'buddyboss-child-js', get_stylesheet_directory_uri().'/assets/js/custom.js', '', '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'buddyboss_theme_child_scripts_styles', 9999 );


/****************************** CUSTOM FUNCTIONS ******************************/

// Add your own custom functions here

/********** Redirecting to the profile page after login **********/

function custom_login_redirect_to() {
    bp_core_redirect( home_url("dashboard") );
}
add_action('wp_login', 'custom_login_redirect_to', 10, 2);



//*********** Redirect WordPress to Homepage Upon Logout **********
//add_action('wp_logout', create_function('','wp_redirect(home_url("wp-login.php"));exit();'));
//buddyboss support change the deprecated function -->> create_function
function wp_redirect_upon_logout(){
    wp_redirect(home_url("/"));
    exit();
}
add_action('wp_logout', 'wp_redirect_upon_logout', 10, 2);



//***********  Redirect from homepage to dashboard if login **********
function bfg_dash_redirect() {
  if(is_user_logged_in() && is_front_page()){
    bp_core_redirect( home_url("dashboard") );
    exit();
  }
}
add_action('wp', 'bfg_dash_redirect');



/*********** Estilos para el backend de wordpress ***********/

function admin_style() {
  wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/assets/css/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');



/*********** Custum User Avatar Default ***********/

define ( 'BP_AVATAR_DEFAULT', 'https://community.thesocialcircle.es/wp-content/uploads/2021/09/avatar-user-00.jpg' );
define ( 'BP_AVATAR_DEFAULT_THUMB', 'https://community.thesocialcircle.es/wp-content/uploads/2021/09/avatar-user-00.jpg' );

add_filter( 'bp_core_fetch_avatar_no_grav', '__return_true' );



/*********** Disable MemberPress auto-login ***********/

function mepr_disable_auto_login($auto_login, $membership_id, $mepr_user) {
  return false;
}
add_filter('mepr-auto-login', 'mepr_disable_auto_login', 3, 3);


//Notificacion cuando se sube un proyecto
add_action( 'transition_post_status', 'bfg_new_proyecto_notification', 10, 3 );

function bfg_new_proyecto_notification( $new_status, $old_status, $post  ) {
  if($post->post_type == 'proyectos' && $new_status != 'publish'){
    bfgSendNotificationPendingPost($post);
  }
}
function bfgSendNotificationPendingPost($post) {
	$author_id = get_post_field ('post_author', $post->ID);
	$display_name = get_the_author_meta( 'first_name' , $author_id); 
 	
	$bfgCookieName = 'BfgNotication'.$post->ID;
	$value = $post->ID;
  $body_mail = "".$display_name." ha subido un nuevo proyecto, esta es la url:". get_permalink( $post->ID ). "";
	  
  if (!isset($_COOKIE[$bfgCookieName]) && (did_action('transition_post_status') === 1)) {
    wp_mail("hola@thesocialcircle.es", "[Nuevo Proyecto en la comunidad]", $body_mail);
    setcookie($bfgCookieName, $value);
  }
}

?>