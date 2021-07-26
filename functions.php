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
  wp_enqueue_style( 'buddyboss-child-css', get_stylesheet_directory_uri().'/assets/css/custom.css', array(), true );

  // Javascript
  wp_enqueue_script( 'buddyboss-child-js', get_stylesheet_directory_uri().'/assets/js/custom.js', array(), true );
}
add_action( 'wp_enqueue_scripts', 'buddyboss_theme_child_scripts_styles', 9999 );


/****************************** CUSTOM FUNCTIONS ******************************/

// Add your own custom functions here

/**
 * 
 */

function bfgCheck3w() {
  $CURRENT_URL = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

  if(strpos($CURRENT_URL, '.local') === false ) {
    if (strpos($CURRENT_URL, 'www') === false) {
        wp_redirect(home_url($_SERVER['REQUEST_URI']));
        exit();
    }
  }
}
add_action( 'init', 'bfgCheck3w');


/* Disable MemberPress auto-login */
function mepr_disable_auto_login($auto_login, $membership_id, $mepr_user) {
  return false;
}
add_filter('mepr-auto-login', 'mepr_disable_auto_login', 3, 3);

/* for redirecting to the profile page after login */
function custom_login_redirect_to($user_login, $user) {
	if (isset($_COOKIE['bfg_history_page'])) {
		bp_core_redirect( $_COOKIE['bfg_history_page'] );
	}else {
		bp_core_redirect( home_url("dashboard") );
	}
	
}
add_action('wp_login', 'custom_login_redirect_to', 10, 2);


//* Redirect WordPress to Homepage Upon Logout
function wp_redirect_upon_logout(){
    wp_redirect(home_url("wp-login.php"));
    exit();
}
add_action('wp_logout', 'wp_redirect_upon_logout', 10, 2);


define ( 'BP_AVATAR_DEFAULT', 'https://beforget.community/wp-content/uploads/2020/12/icon_usuario_bfg.png' );
define ( 'BP_AVATAR_DEFAULT_THUMB', 'https://beforget.community/wp-content/uploads/2020/12/icon_usuario_bfg.png' );

add_filter( 'bp_core_fetch_avatar_no_grav', '__return_true' );


/* Estilos para el backend de wordpress */

function admin_style() {
  wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/assets/css/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');


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

  $config = array( 
      "text" => "[Nuevo Proyecto en la comunidad] ".$display_name." ha subido un nuevo proyecto, esta es la url: ".get_permalink( $post->ID )."", 
  ); 
  $payload = json_encode($config);

	$args = array(
	    'headers' => array(
	        'Content-Type' => 'Content-Type'
	    ),
	    'body' =>  $payload
	  );
	  
  	if (!isset($_COOKIE[$bfgCookieName])) {
      wp_remote_post( get_option( 'webhook_url_slack_option' ), $args );
      setcookie($bfgCookieName, $value);
    }
}


/* ---------------------------------------------------------------------------
 * Show the Cookie Banner
 * --------------------------------------------------------------------------- */

function cmplz_show_banner_on_click() {
  ?>
  <script>
        jQuery(document).ready(function ($) {
            $(document).on('click', '.cmplz-show-banner', function(){
                $('.cc-revoke').click();
                $('.cc-revoke').fadeOut();
            });
        });
  </script>
  <?php
}
add_action( 'wp_footer', 'cmplz_show_banner_on_click' );


// define the login_init callback 
function action_login_init() { 
	$bfg_request = wp_get_referer();
	setcookie('bfg_history_page', $bfg_request, time()+3600);
}; 
         
// add the action 
add_action( 'login_init', 'action_login_init', 10, 1 ); 


//redirec to dashboard if login
function bfg_dash_redirect() {
	if(is_user_logged_in() && is_front_page()){
	  bp_core_redirect( home_url("dashboard") );
	  exit();
	}
}
add_action('wp', 'bfg_dash_redirect');

/* Add Matomo Tag Manager */
add_action('wp_head', 'matomo_tag_manager');
function matomo_tag_manager(){
  $CURRENT_URL = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  if(strpos($CURRENT_URL, '.local') === false ) {
    ?>
     <!-- Matomo Tag Manager -->
      <script type="text/javascript">
      var _mtm = window._mtm = window._mtm || [];
      _mtm.push({'mtm.startTime': (new Date().getTime()), 'event': 'mtm.Start'});
      var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
      g.type='text/javascript'; g.async=true; g.src='https://cdn.matomo.cloud/beforget.matomo.cloud/container_s4Ee9pDo.js'; s.parentNode.insertBefore(g,s);
      </script>
      <!-- End Matomo Tag Manager -->
      <?php
  }

};

/**
 * Ulr especifica desde un mailing
 */
if($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] == 'beforget.community/wp-login.php%20,'){
	header("Location: https://www.beforget.community/wp-login.php");  
	echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
};


//Redirección para el BUG de meberpress a recordar la url del cual viene el usuario
function bfg_check_login_memberpress_redirect() {
	if(is_user_logged_in() && $_GET["action"] === 'mepr_unauthorized') {
	    bp_core_redirect( home_url("dashboard") );
	    exit();
	}
	
}
add_action('init', 'bfg_check_login_memberpress_redirect');

?>