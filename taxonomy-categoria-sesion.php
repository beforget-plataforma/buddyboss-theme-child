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
		<?
			$bfgSesion = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$currentSesion = basename($bfgSesion);
			var_dump(basename($bfgSesion));
			if(basename($bfgSesion) === 'educacion') {
				$bfgSlug = 'Educación';
			}
			if(basename($bfgSesion) === 'bienestar') {
				$bfgSlug = 'Vienestar';
			}
			if(basename($bfgSesion) === 'creatividad') {
				$bfgSlug = 'Creatividad';
			}
			if(basename($bfgSesion) === 'empleabilidad') {
				$bfgSlug = 'Empleabilidad';
			}
			if(basename($bfgSesion) === 'tecnologia') {
				$bfgSlug = 'Tecnología';
			}
			if(basename($bfgSesion) === 'ventas-extraordinarias') {
				$bfgSlug = 'Ventas extraordinarias';
			}
			if(basename($bfgSesion) === 'cultura-colaborativa') {
				$bfgSlug = 'Cultura Colaborativa';
			}
			if(basename($bfgSesion) === 'liderazgo') {
				$bfgSlug = 'Liderazgo';
			}
			if(basename($bfgSesion) === 'productividad') {
				$bfgSlug = 'Productividad';
			}
			if(basename($bfgSesion) === 'comunicacion') {
				$bfgSlug = 'Comunicación';
			}
		?>
		<h2><? echo $bfgSlug; ?></h2>
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
								'terms'    => basename($bfgSesion),
							)
						),
					);
						$query = new WP_Query( $args );
						while($query->have_posts()): $query->the_post();
						$users = get_field("ponente");
						$userName = xprofile_get_field_data('1', $users[0]->ID);
						$userLastName = xprofile_get_field_data('2', $users[0]->ID);
				?>
				<div class="bfg-item-sesiones">
					<a class="no-color" href="<?php the_permalink(); ?>">
						<div class="bfg-header-cover-sesiones item-profile flex"
							style="background-color:<?php the_field('brand_color'); ?>">
							<span class="bfg-icon-smile inprofile">
								<img src="<? echo wp_get_attachment_url(167); ?>" alt="">
							</span>
							<hgroup>
								<div class="bfg-container-title item-profile ">
									<?php
											$title = get_the_title();
											$short_title = wp_trim_words( $title, 12, '...' );
										?>
										<h2 class="title-bit"><? echo get_the_title(); ?></h2>
									</div>
										<?php
											$ponenteName = $users[0]->display_name;
											$ponenteAvatar = get_avatar($users[0]->ID);
										?>
										<div class="bfg-profile-author bfg-icon-small">
										<?
											if($users[0]->ID != null){
												echo $ponenteAvatar;
										?> 
										<span><? echo $userName .' '. $userLastName; ?></span>
										<?php
									} else {
										?>
										<img src="<? echo wp_get_attachment_url(805); ?>" alt="">
										<span><? echo 'BeForGet';?></span>
										<?php
									}
									?>
								</div>
							</hgroup>
						</div>
						<span class="line-divisor <? echo basename($bfgSesion); ?>"></span>
						<div class="bfg-content-inprofile">
							<p>
								<?php
									echo wp_trim_words( get_the_content(), 30, '...' );
								?>
							</p>
						</div>
						<div class="line footer-date"></div>
						<div class="flex bfg-footer-item">
							<div class="bfg-icon-date inprofile">
								<img src="<? echo wp_get_attachment_url(166); ?>" alt="">
							</div>
							<div class="bfg-block time-footer">
								<p>
									<?php
										$unixtimestamp = strtotime( get_field('hora_de_la_sesion') );
										echo date_i18n( "l d F, H:i", $unixtimestamp );
									?>
									hrs
								</p>
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
