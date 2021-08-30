<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */

get_header();
?>

<div id="primary" class="content-area">
	<div class="bfg-wrapper-hero has-text-align-center">
		<?php
			$bfgProyectos = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$currentSesion = basename($bfgProyectos);
			if($currentSesion === 'ods-01') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 1';
			}
			if($currentSesion === 'ods-02') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 2';
			}
			if($currentSesion === 'ods-03') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 3';
			}
			if($currentSesion === 'ods-04') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 4';
			}
			if($currentSesion === 'ods-05') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 5';
			}
			if($currentSesion === 'ods-06') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 6';
			}
			if($currentSesion === 'ods-07') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 7';
			}
			if($currentSesion === 'ods-08') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 8';
			}
			if($currentSesion === 'ods-09') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 9';
			}
			if($currentSesion === 'ods-10') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 10';
			}
			if($currentSesion === 'ods-11') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 11';
			}
			if($currentSesion === 'ods-12') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 12';
			}
			if($currentSesion === 'ods-13') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 13';
			}
			if($currentSesion === 'ods-14') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 14';
			}
			if($currentSesion === 'ods-15') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 15';
			}
			if($currentSesion === 'ods-16') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 16';
			}
			if($currentSesion === 'ods-17') {
				$bfgSlug = 'Proyectos asociados al Objetivo ODS 17';
			}
		?>
		<h2><?php echo $bfgSlug; ?></h2>
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
    
    <div class="wrapper-post-proyectos-page flex bfg-flex-grap">
      <?php
          $args = array(
            'posts_per_page' => -1,
            'post_type' => 'proyectos',
            'order' => 'ASC',
						'tax_query' => array(
							array(
								'taxonomy' => 'ods',
								'field'    => 'slug',
								'terms'    => basename($bfgProyectos),
							)
						),
          );
          $query = new WP_Query( $args );
          while($query->have_posts()): $query->the_post();
			    $terms = get_the_terms( get_the_ID(), 'ods' );
      ?>
      <?php
					$thumbID = get_post_thumbnail_id( get_the_ID() );
					$imgDestacada = wp_get_attachment_url( $thumbID );
				?>

      <div class="bfg-item-proyectos">
				<a class="no-color" href="<?php the_permalink(); ?>">
					<div class="bfg-header-cover-sesiones bfg-has-avatar item-profile flex" style="background-image:url(<?php echo $imgDestacada; ?>)">
          </div>
          <div class="bfg-avatar-proyecto" style="background-image: url(<?php echo the_field('logo_proyecto'); ?>)"></div>
					<hgroup class="bfg-content-inprofile resumen-proyecto">
						<div class=" ">
							<?php
								$title = get_the_title();
								$short_title = wp_trim_words( $title, 12, '...' );
							?>
							<h2 class="title-bit"><?php echo $short_title; ?></h2>
						</div>
						<div class="group-description">
						
							<?php echo the_excerpt(); ?>
						</div>
					</hgroup>
					<div class="bfg-miembros-proyecto flex bfg-flex-grap">
					<?php
							$miembros = get_post_meta( get_the_ID(), 'miembros', true );
							$user_id = get_the_author_meta( 'ID' );
							if($miembros) {
								foreach($miembros as $userID){
									$userName = xprofile_get_field_data('1', $userID);
									$args = array( 
										'item_id' => $userID, 
										'object' => '', 
										'type' => '' 
									); 
									echo bp_core_fetch_avatar($args); 
								}
							}
						?>
					</div>
					<div class="bfg-ods-proyecto">
						<ul class="bfg-list flex">
						<?php foreach($terms as $term): ?>
								<li class="<?php echo $term->slug; ?>">
									<img src="<? echo get_stylesheet_directory_uri() . '/assets/images/' . $term->slug . '.png';  ?>" alt="">
								</li>
							<?php endforeach; ?>
							</ul>
          </div>
				</a>
			</div>
      <?php
        endwhile; wp_reset_postdata();
      ?>
    </div>
  </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
