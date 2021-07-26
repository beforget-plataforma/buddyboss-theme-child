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

/* for redirecting to the profile page after login */
function custom_login_redirect_to($user_login, $user) {
	if (isset($_COOKIE['bfg_history_page'])) {
		bp_core_redirect( $_COOKIE['bfg_history_page'] );
	}else {
		bp_core_redirect( home_url("dashboard") );
	}
	
}

//* Redirect WordPress to Homepage Upon Logout
//add_action('wp_logout', create_function('','wp_redirect(home_url("wp-login.php"));exit();'));
//buddyboss support change the deprecated function -->> create_function
function wp_redirect_upon_logout(){
    wp_redirect(home_url("wp-login.php"));
    exit();
}
add_action('wp_logout', 'wp_redirect_upon_logout', 10, 2);


define ( 'BP_AVATAR_DEFAULT', 'https://beforget.community/wp-content/uploads/2020/12/icon_usuario_bfg.png' );
define ( 'BP_AVATAR_DEFAULT_THUMB', 'https://beforget.community/wp-content/uploads/2020/12/icon_usuario_bfg.png' );

add_filter( 'bp_core_fetch_avatar_no_grav', '__return_true' );


function bfg_breadcrumb($name, $post) {
  $currentURL = get_site_url( );
  $title = $post->post_title;
  $permalink = get_the_permalink( $post->ID );
  ?>
  <div class="bfg-breadcruƒmb main-navs bp-navs single-screen-navs horizontal groups-nav">
    <ul>
      <li>
        <a href="<? echo $currentURL.'/'.$name.'/'; ?>"><? echo $name; ?></a>
      </li>
      <li>
        <b><? echo $title; ?></b>
      </li>
    </ul>
  </div>
  <?php
}


// add this to functions.php
//register acf fields to Wordpress API
//https://support.advancedcustomfields.com/forums/topic/json-rest-api-and-acf/

function create_ACF_meta_in_REST() {
  $postypes_to_exclude = ['proyectos'];
  $extra_postypes_to_include = ["sesiones"];
  $post_types = array_diff(get_post_types(["_builtin" => false], 'names'),$postypes_to_exclude);

  array_push($post_types, $extra_postypes_to_include);

  foreach ($post_types as $post_type) {
      register_rest_field( $post_type, 'ACF', [
          'get_callback'    => 'expose_ACF_fields',
          'schema'          => null,
     ]
   );
  }

}

function expose_ACF_fields( $object ) {
  $ID = $object['id'];
  return get_fields($ID);
}

add_action( 'rest_api_init', 'create_ACF_meta_in_REST' );

add_action( 'transition_post_status', 'bfg_new_proyecto_notification', 10, 3 );

function bfg_new_proyecto_notification( $new_status, $old_status, $post  ) {
  if($post->post_type == 'proyectos' && $new_status != 'publish'){
    bfgSendNotificationPendingPost($post);
  }
}
function bfgSendNotificationPendingPost($post) {
    
    $config = array( 
        "text" => "Hola! Hay un nuevo proyecto que espera a ser aprobado ".get_permalink( $post->ID ).".", 
    ); 
    $payload = json_encode($config);

	  $args = array(
	    'headers' => array(
	        'Content-Type' => 'Content-Type'
	    ),
	    'body' =>  $payload
	  );
	  wp_remote_post( "https://hooks.slack.com/services/T41M9ERPD/B01A6QCEJSJ/".get_option( 'webhook_slack_option' )."", $args );
}

add_filter( 'bp_xprofile_is_richtext_enabled_for_field', 'my_disable_rt_function', 10, 2 );
function my_disable_rt_function( $enabled, $field_id ) {
  // 14 is the id of the field I want to be plain text.
  if ( 341 == $field_id ) {
    $enabled = false;
  }
  return $enabled;
}


function bfgCheckWww() {
  $CURRENT_URL = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  if (strpos($CURRENT_URL, 'www') === false) {
    wp_redirect(home_url($_SERVER['REQUEST_URI']));
    exit();
  }
}
// add_action( 'init', 'bfgCheckWww');

//redirec to dashboard if login
function bfg_dash_redirect() {
    if(is_user_logged_in() && is_front_page()){
      bp_core_redirect( home_url("dashboard") );
      exit();
    }
  }
  add_action('wp', 'bfg_dash_redirect');

  // define the login_init callback 
function action_login_init() { 
	$bfg_request = wp_get_referer();
	setcookie('bfg_history_page', $bfg_request, time()+3600);
}; 
         
// add the action 
add_action( 'login_init', 'action_login_init', 10, 1 ); 


//Redirección para el BUG de meberpress a recordar la url del cual viene el usuario
function bfg_check_login_memberpress_redirect() {
	if(is_user_logged_in() && $_GET["action"] === 'mepr_unauthorized') {
	    bp_core_redirect( home_url("dashboard") );
	    exit();
	}
	
}
add_action('init', 'bfg_check_login_memberpress_redirect');

?>