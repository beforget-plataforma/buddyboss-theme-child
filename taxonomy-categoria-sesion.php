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
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		?>
		<h2><?php echo $term->name; ?></h2>
	</div>
	<main id="main" class="site-main">
		<div class="wrapper-post-sesiones-profile flex bfg-flex-grap">
				<?php
					$args = array(
						'posts_per_page' => -1,
						'post_type' => 'sesiones',
						'order' => 'DESC',
						'tax_query' => array(
							array(
								'taxonomy' => 'categoria-sesion',
								'field'    => 'slug',
								'terms'    => $term->slug,
							)
						),
					);
						$query = new WP_Query( $args );
						while($query->have_posts()): $query->the_post();
						$terms = get_the_terms( $post->ID, 'tipo-sesion' );
						$users = get_field("ponente");
						$ponente = get_post_meta( get_the_ID(), 'ponente', true);
						$participantes = get_post_meta( get_the_ID(), 'ponente', true);
				?>
				<div class="bfg-item-sesiones">
					<a class="no-color" href="<?php the_permalink(); ?>">
						<div class="bfg-header-cover-sesiones item-profile flex"
							style="background-color:#1263f0;">
							<span class="bfg-icon-smile inprofile">
								<img src="<? echo wp_get_attachment_url(171); ?>" alt="">
							</span>
							<hgroup>
								<div class="bfg-container-title item-profile ">
									<?php
										$title = get_the_title();
										$short_title = wp_trim_words( $title, 12, '...' );
									?>
									<h1>
										<?php echo $title; ?>
									</h1>
								</div>
								<?php
									$args = array( 
										'item_id' => get_the_author_meta('ID')
									); 
								?>
								<?php
									$users = get_field("ponente");
									$ponenteName = $users[0]->display_name;
									$userName = xprofile_get_field_data('1', $participantes[0]);
									$userLastName = xprofile_get_field_data('2', $participantes[0]);
									$ponenteAvatar = get_avatar($participantes[0]);

									?>
								<div class="bfg-profile-author bfg-icon-small">
								<?php
								if($participantes[0] != null){
									echo $ponenteAvatar;
								?>
								<span><?php echo $userName . ' ' . $userLastName; ?></span>
								<?php
								}else{
								?>
									<img class="bfg-avatar-reset" src="<?php echo wp_get_attachment_url(805); ?>" alt="">
									<span><?php echo 'BeForGet';?></span>
								<?php
								}
								?>
								</div>
							</hgroup>
						</div>
						<span class="line-divisor <?php echo $term->name ; ?>"></span>
						<div class="bfg-content-inprofile">
							<p>
								<?php
									echo wp_trim_words( get_the_content(), 30, '...' );
								?>
							</p>
						</div>
						<div class="line footer-date"></div>
						<div class="flex bfg-date-sesion">
							<div class="bfg-date-wrapper">
								<div class="bfg-icon-date inprofile">
									<img src="<?php echo wp_get_attachment_url(920); ?>" alt="">
								</div>
								<div class="bfg-block time-footer">
										<?php
											$unixtimestamp = strtotime( get_field('hora_de_la_sesion') );
											echo date_i18n( "d / m / Y", $unixtimestamp );
										?>
								</div>
							</div>
							<div class="bfg-miembros-proyecto flex bfg-flex-grap">
								<?php
									$index = 0;
									if($participantes){

										foreach($participantes as $userID){
											$userName = xprofile_get_field_data('1', $userID);
											$args = array( 
												'item_id' => $userID
											);
											if($index != 0) {
												echo bp_core_fetch_avatar($args);
											}
											$index ++;
										}
									}
								?>
							</div>
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
