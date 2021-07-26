<?php
/**
 * Template Name: newsletter BFG
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
  <div class="bfg-wrapper-hero-sesiones">
    <?
      echo the_content();
    ?>
  </div>
  <main id="main" class="site-main bfg-grid-content bfg-wrapper-container">
    <?
    	global $post;
    	$args = array( 
    		'post_type' => 'newsletter',
    	);
	    // The Query
		$the_query = new WP_Query( $args );
		// The Loop
		if ( $the_query->have_posts() ) {
		    echo '<ul class="bfg-newslater-container">';
		    while ( $the_query->have_posts() ) {
		        $the_query->the_post();
		        $mailster_data = get_post_meta($post->ID, '_mailster_preheader');
		        $fromName = get_post_meta($post->ID, '_mailster_$fromName');
				?>
						<?
							$findme   = '[No miembros]';
							$pos = strpos($post->post_title, $findme);
							if($pos !== 0) {
								$mailster_data_ = rawurldecode($mailster_data[0]);
								?>
									<li>
										<a href="<? echo the_permalink() ?>">
											<h4> <? echo $post->post_title; ?></h4>
											<p><? echo $mailster_data_; ?></p>
										</a>
									</li>
								<?
							}
						?>
				<?
		    }
		    echo '</ul>';
		} else {
		    // no posts found
		}
		/* Restore original Post Data */
		wp_reset_postdata();
    ?>
    <div class="bfg-wrapper-filter">
      
  </main><!-- #main -->

</div><!-- #primary -->

<?php

get_footer();