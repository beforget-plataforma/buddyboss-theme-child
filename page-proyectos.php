<?php
/**
 * Template Name: Proyectos
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

get_header('content');

?>

<div class="content-area">
  <div class="bfg-wrapper-hero-proyectos">
    <?php
      echo the_content();
    ?>
  </div>
  <main id="main" class="site-main bfg-grid-content bfg-wrapper-container">
    <?php
        $terms = get_terms( array(
            'taxonomy' => 'ods',
            'hide_empty' => false,
            'orderby' => 'slug',
            'order' => 'ASC',
        ));
      ?>
		<div class="bfg-nav-filter proyectos-nav-page">
      <?php if ($terms):?>
				
      <?php endif;?>
		</div>
		<div class="bfg-count-resultados ods"></div>
    <div class="wrapper-post-proyectos-page flex bfg-flex-grap">
      
    </div>
     <div class="wrapper-button-pagination">
    <button class="ver-mas-sesiones bfg-button-primary wp-block-button__link has-white-color has-text-color has-background">Ver más Proyectos</button>
  </div>
  </main><!-- #main -->
</div><!-- #primary -->
<?php
do_action('bfg_filter_proyecto_script');
get_footer();
