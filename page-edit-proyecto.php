<?php
/**
 * Template Name: Editar proyectos
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */

acf_form_head();
get_header('content');
?>

<div class="content-area">
	<?php
		$postEdit = $_GET["edit"];
		
	?>
	<a class="bfg-button-primary wp-block-button__link has-white-color has-text-color has-background" href="<?php echo get_the_permalink($postEdit); ?>">
			Volver al proyecto
	</a>
  <?php
  
	acf_form(array(
	 'post_id' => $postEdit,
	 'new_post' => false,
	 'uploader' => 'wp',
	 'id' => 'acf-form',
	 'post_title' => true,
	 'post_content' => true,
	 'updated_message' => __("Proyecto actualizado", 'acf'),
		
));
  ?>
</div>

<?php
get_footer();