<?php
/**
 * Template part for displaying sfwd content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */
?>

<?php acf_form_head(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?
		global $post;
		$thumbID = get_post_thumbnail_id( $post->ID );
		$imgDestacada = wp_get_attachment_url( $thumbID );
		$terms = get_the_terms( $post->ID, 'ods' );
		$authorID = get_the_author_meta('ID');
		$userName = xprofile_get_field_data('1', $authorID);
		$userLastName = xprofile_get_field_data('2', $authorID);
	?>
	<div id="buddypress" class="bfg-hero-project buddypress-wrap">
<!-- 		<?php acf_form(); ?> -->
		<div id="item-header" class="groups-header single-headers">
			<div id="cover-image-container">
				<div id="header-cover-image" class="bfg-header-cover-image" style="background-image: url('<? echo $imgDestacada; ?>')">
				</div>
				<div id="item-header-cover-image" class="item-header-wrap bb-enable-cover-img bfg-justify-center">
					<div class="bfg-avatar-proyecto detail-page" style="background-image: url(<? echo the_field('logo_proyecto'); ?>)">
					</div>
					<div id="item-header-content">
						<div class="flex align-items-center bp-group-title-wrap">
							<h2><? the_title() ?></h2>
						</div>
						<div class="group-description">
							<? echo the_excerpt(); ?>
						</div>
						<h4 class="bp-title">Organizador - <b><? echo $userName . ' ' . $userLastName; ?></b></h4>
					</div>
					<div>
					<?php
						$current_user = wp_get_current_user();
						if($current_user->ID === get_the_author_meta('ID')){
							?>
								<a class="bfg-my-6 bfg-button-primary wp-block-button__link has-white-color has-text-color has-background" href="<? echo get_site_url() . '/edit-proyecto/?edit='.$post->ID; ?>">Editar Proyecto</a>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
			// bfg_breadcrumb('proyectos', $post);
		?>
		<div class="bp-wrap">
			<nav id="object-nav" class="main-navs bp-navs single-screen-navs horizontal groups-nav">
				<ul>
					<li id="nav-pages-description-li" class="bp-groups-tab selected">
						<a href="#" class="bfg-nav-project" data-tab-id="tabs-1">
							Descripción
						</a>
					</li>
					<?
						
						$miembros = get_post_meta( get_the_ID(), 'miembros', true );	
						if($miembros){
								
							?>
							<li id="nav-pages-memeber-li" class="bp-groups-tab">
								<a href="#" class="bfg-nav-project" data-tab-id="tabs-2">
									Miembros
									<span class="count">
										<?
											
											$largo = sizeof($miembros);
											echo $largo;
											
										?>
									</span>
								</a>
							</li>
							<?
						}
					?>
				</ul>
			</nav>
		</div>
		<div class="bb-profile-grid bb-grid">
			<div class="item-body bfg-tabs">
				<div id="tabs-1" class="group_content bfg-project-content bfg-wrapper-content">
					<h2 class="title-bit">Descripción del proyecto</h2>
					<?	the_content();
					if(get_field('reto')){
						?>
						<br>
						<h2 class="title-bit">Reto</h2>
						<?
						echo get_field('reto');
					};
					?>
					<div class="bfg-grid bb-grid align-items-top mt-5">
						<div class="bfg-block">
							<div class="embed-container">
									<?php
									$iframe = get_field('video');
									$hasVideo = false;
									if($iframe !== '') {
											// Use preg_match to find iframe src.
											$hasVideo = true;
											preg_match('/src="(.+?)"/', $iframe, $matches);
											$src = $matches[1];
											// Add extra parameters to src and replcae HTML.
											$params = array(
													'controls'  => 1,
													'hd'        => 1,
													'autohide'  => 1
											);
											$new_src = add_query_arg($params, $src);
											$iframe = str_replace($src, $new_src, $iframe);

											// Add extra attributes to iframe HTML.
											$attributes = 'frameborder="0"';
											$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
											// Display customized HTML.
											echo $iframe;
									}
									?>
							</div>
							<?
								$isVideo = $hasVideo ? 'bfg-mt-5' : '';
							?>
						<?php if($terms) { ?>
							<div class="bfg-ods <? echo $isVideo; ?>">
								<div class="bfg-ods-proyecto sesion-details">
									<h2 class="title-bit">Objetivo de Desarrollo Sostenible</h2>
									<ul class="bfg-list bfg-list-no-padding flex">
								
									<?
										foreach($terms as $term): ?>
											<li class="<?php echo $term->slug; ?>">
												<img src="<? echo get_stylesheet_directory_uri() . '/assets/images/' . $term->slug . '.png';  ?>" alt="">
											</li>
										<?php endforeach; ?>
									
								</ul>
								</div>
							</div>
							<?}?>
						</div>
						<div>
							<div class="bfg-block-conoce-mas">
							<h3>Conoce Más</h3>
							<ul class="bfg-rrss-project">
								<?
								$rrss = get_field('redes_sociales');
									foreach ($rrss as $key => $value) {
										if($value !== ''){
											?>
												<li>
													<a class="<? echo $key; ?>" target="_blank" href="<? echo $value; ?>">
														<?php echo $key; ?>
													</a>
												</li>
												<?
										}
									}
								?>
							</ul>
							
							<?php
								$user_id = get_the_author_meta( 'ID' );
								$slackUnfo = xprofile_get_field_data('50', $user_id);
								$dataUSer = explode(' - ', $slackUnfo);
								// function bfg_show_button_slack($urlSrc, $text){
								// 	echo '<a class="bfg-button-primary friendship-button not_friends add" href="'.$urlSrc.'" id="connect-to-slack">'.$text.'</a>';
								// }
								// bfg_show_button_slack('slack://user?team='.$dataUSer[1].'', 'Ir a Slack');
								if(count($dataUSer) > 0){
									?>
										<p>
											Si quieres más información o colaborar con el proyecto ¡escribenos un mensaje!
										</p>
										<a class="bfg-button-primary wp-block-button__link has-white-color has-text-color has-background" href="slack://user?team=<? echo $dataUSer[1]; ?>&id=<? echo $dataUSer[0]?>" id="connect-to-slack">Contacto Slack</a>
									<?php
									
								}else{
									?>
										<p>
											Si quieres más información o colaborar con el proyecto contacta con algún miembro del equipo!
										</p>
										<button id="bfg-button-primary" class="bfg-button-primary wp-block-button__link has-white-color has-text-color has-background">Ponte en contacto</button>
									<?php
								}
							?>
							
							</div>
						</div>
					</div>
				</div>
				<div id="tabs-2" class="group_members bfg-project-content dir-list bfg-hidden">	
					<ul class="item-list members-group-list bp-list grid">
						<?
							$miembros = get_post_meta( get_the_ID(), 'miembros', true );							
							foreach($miembros as $userID){
								$userName = xprofile_get_field_data('1', $userID);
								$userLastName = xprofile_get_field_data('2', $userID);
								$args = array( 
									'item_id' => $userID, 
									'object' => '', 
									'type' => '' 
								); 
								?>
									<li class="item-entry odd is-online is-current-user">
										<div class="list-wrap">
											<div class="list-wrap-inner">
												<div class="item-avatar">
													<a href="<? echo bp_core_get_user_domain( $userID );?> ">
														<?
															echo bp_core_fetch_avatar($args); 
														?>
													</a>
												</div>
												<div class="item mt-2">
													<div class="item-block">
														<a href="<? echo bp_core_get_user_domain( $userID );?> ">
															<h2 class="list-title member-name">
															<? echo $userName . ' ' . $userLastName; ?>
															</h2>
														</a>
													</div>
												</div>
											</div>
										</div>
									</li>
								<?
								// $userName = bp_get_displayed_user_avatar('1', $userID);
								// An array of arguments. All arguments are technically optional; some will, if not provided, be auto-detected by bp_core_fetch_avatar(). This auto-detection is described more below, when discussing specific arguments. 
								

								// NOTICE! Understand what this does before running. 
								
								
							}
							?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="entry-content">
		<?php

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'buddyboss-theme' ),
			'after'	 => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
			sprintf(
			wp_kses(
			/* translators: %s: Name of current post. Only visible to screen readers */
			__( 'Edit <span class="screen-reader-text">%s</span>', 'buddyboss-theme' ), array(
				'span' => array(
					'class' => array(),
				),
			)
			), get_the_title()
			), '<span class="edit-link">', '</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>

</article>
<?
	acf_enqueue_uploader();
	bfg_project_tab_script();
?>
