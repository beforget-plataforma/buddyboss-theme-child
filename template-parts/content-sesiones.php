<?php
/**
 * Template part for displaying sfwd content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		global $post;
		$slugTerms = [];
		$thumbID = get_post_thumbnail_id( $post->ID );
		$imgDestacada = wp_get_attachment_url( $thumbID );
		$terms = get_the_terms( $post->ID, 'tipo-sesion' );
		$participantes = get_post_meta( get_the_ID(), 'ponente', true);
	?>
	<div id="buddypress" class="bfg-hero-project buddypress-wrap">
		<div id="item-header" class="groups-header single-headers">
			<div class="bfg-header-cover-sesiones" style="background-color:<?php the_field('brand_color'); ?>">
					<span class="bfg-icon-smile">
							<img src="<?php echo wp_get_attachment_url(171); ?>" alt="">
					</span>
					<div class="bfg-tag-tipo">
						<?php if($terms):?>
						<?php foreach($terms as $term): ?>
							<a href="<?php echo get_term_link( $term->slug, 'tipo-sesion'); ?>" rel="tag" class="<?php echo $term->slug; ?>"><?php echo $term->name; ?></a>
							<?php array_push($slugTerms, $term->slug); ?>
						<?php endforeach; ?>
						<?php endif;?>
					</div>
					
					<div class="bfg-container-title">
						<h1>	<?php the_title() ?></h1>
					</div>
					<div class="bfg-profile-author name-detail flex">
							<?php
								$users = get_field("ponente");
								// $ponenteName = $participantes[0]->display_name;
								$ponenteAvatar = get_avatar($participantes[0]);
								$userName = xprofile_get_field_data('1', $participantes[0]);
								$userLastName = xprofile_get_field_data('2', $participantes[0]);
							?>
							<a class="bfg-link-author" href="<?php echo bp_core_get_user_domain($participantes[0]); ?>">
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
							</a>
					</div>
				</div>
			</div>
		<div class="bb-profile-grid bb-grid">
			<div class="item-body bfg-tabs">
				<div id="tabs-1" class="group_content bfg-project-content dir-list bfg-wrapper-content">
					<?php
					the_content(); 
					?>

					<span class="line"></span>
					<div class="flex bfg-date-sesion">
						<div class="bfg-date-wrapper">
							<div class="bfg-icon-date">
								<img src="<?php echo wp_get_attachment_url(247); ?>" alt="">
							</div>
							<div class="bfg-block bfg-date">
								<div class="bp-wrap">
									<?php
										$unixtimestamp = strtotime( get_field('hora_de_la_sesion') );
										// Display date in the format "l d F, Y".
										echo date_i18n( "d F, Y", $unixtimestamp );
									?>
								</div>
							</div>
						</div>
							<div class="bfg-miembros-sesiones flex bfg-flex-grap">
								<?php
									if($participantes){
										$index = 0;
										foreach($participantes as $userID){
											$userName = xprofile_get_field_data('1', $userID);
											$nickName = xprofile_get_field_data('3', $userID);
											get_post_meta( $userID, 'miembros', true );
											$args = array( 
												'item_id' => $userID,
												'width' => 250,
												'height' => 250,
											);
											if($index != 0) {
												?>
													<a href="<?php echo bp_core_get_user_domain($userID); ?>">
														<?php echo bp_core_fetch_avatar($args); ?> 
													</a>
												<?php
											}
											$index ++;
										}
									}
								?>
							</div>
					</div>
					<span class="line"></span>
							<?php if(current_user_can('mepr-active','rules:273') || (false !== array_search('beforget-talent', $slugTerms))): ?>
								<div class="embed-container">
										<?php
										$iframe = get_field('video');
										// Use preg_match to find iframe src.
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
										return;
										?>
								</div>

							<?php endif; ?>
								<div class="bfg-restricted">
									<article>
										<p>Para ver el contenido  <a href="<?php echo esc_url( wp_login_url( ) ); ?>">accede a tu perfil</a> o <a href="<? echo site_url('/hazte-miembro/' . get_permalink()); ?>">regístrate en la Comunidad.</a> </p>
									<?php
										return;
									?>
									</article>
								</div>
						
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
		</footer>
	<?php endif; ?>
</article>
