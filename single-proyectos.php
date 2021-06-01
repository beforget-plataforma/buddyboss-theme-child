<?php
/**
 * The template for displaying single course
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package BuddyBoss_Theme
 */

get_header();
?>

	<div id="primary" class="content-area bgf-content-project">
		<main id="main" class="site-main">
			<?php
            
				while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'proyectos' );

			endwhile; // End of the loop.
       
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?
		// get_sidebar( 'page' );

	?>
<?php
get_footer();
