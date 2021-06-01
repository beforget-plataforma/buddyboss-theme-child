<?php
/**
 * Template Name: Sesiones
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
    <?php
        $terms = get_terms( array(
            'taxonomy' => 'tipo-sesion',
             'order' => 'DESC',
        ));
        $termsCategory = get_terms( array(
            'taxonomy' => 'categoria-sesion',
             'order' => 'DESC',
        ));
      ?>
    <div class="bfg-wrapper-filter">
      <div class="bfg-nav-filter ">
          <?
            foreach($termsCategory as $term) {
              ?>
                <div class="bfg-filter-button bfg-content-category <? echo $term->slug; ?>">
                  <label data-type="categoria-sesion">
                      <input type="checkbox" value="<? echo $term->slug; ?>"><span><? echo $term->name; ?></span>
                  </label>
                </div>
              <?php
            }
          ?>
      </div>
      <div id="bfg-filter-tipo-sesiones" class="bfg-nav-filter">
          <?
            foreach($terms as $term) {
              ?>
                <div class="bfg-filter-button <? echo $term->slug; ?>">
                  <label data-type="tipo-sesion">
                      <input type="checkbox" value="<? echo $term->slug; ?>"><span><? echo $term->name; ?></span>
                  </label>
                </div>
              <?php
            }
          ?>
      </div>
      <div class="bfg-total-resultados">
            <p></p>
      </div>
<!--
      <button id="bfg-ver-resultados" class="bfg-button-primary btn-filter-mobile">
            Ver Resultados
      </button>
    </div>
    <div class="bfg-filter-nav-mobile flex bfg-justify-content-center">
        <button id="filter-sesiones-mobile" class="bfg-button-primary wp-block-button__link has-white-color has-text-color has-background">
            Filtros
        </button>
    </div>
-->
    <div class="wrapper-post-list-sesiones flex bfg-flex-grap">
      <?php
          $args = array(
            'posts_per_page' => -1,
            'post_type' => 'sesiones',
            'orderBy' => 'title',
            'order' => 'DESC',
          );
          $query = new WP_Query( $args );
          while($query->have_posts()): $query->the_post();
          $terms = get_the_terms( get_the_ID(), 'tipo-sesion' );
          $termsCategoria = get_the_terms( get_the_ID(), 'categoria-sesion' );
          $users = get_field("ponente");
          $userName = xprofile_get_field_data('1', $users[0]->ID);
          $userLastName = xprofile_get_field_data('2', $users[0]->ID);

      ?>
      <div class="bfg-item-sesiones bfg-<? echo $terms[0]->slug; ?> bfg-<? echo $termsCategoria[0]->slug?>">
        <a class="no-color" href="<?php the_permalink(); ?>">
          <div class="bfg-header-cover-sesiones item-profile flex"
            style="background-color:<?php the_field('brand_color'); ?>">
            <span class="bfg-icon-smile inprofile">
              <img src="<? echo wp_get_attachment_url(171); ?>" alt="">
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
          <span class="line-divisor <? echo $terms[0]->slug; ?>"></span>
          <div class="bfg-content-inprofile">
            <p><? echo wp_trim_words( get_the_excerpt(), 40 ); ?></p>
          </div>
          <div class="line footer-date"></div>
          <div class="flex bfg-footer-item">
            <div class="bfg-icon-date inprofile">
              <img src="<? echo wp_get_attachment_url(247); ?>" alt="">
            </div>
            <div class="bfg-block time-footer">
              <p>
                <?php
                  $unixtimestamp = strtotime( get_field('hora_de_la_sesion') );
                  echo date_i18n( "l d F", $unixtimestamp );
                ?>
              </p>
            </div>
          </div>
        </a>
      </div>
      <?
        endwhile; wp_reset_postdata();
      ?>
    </div>
  </main><!-- #main -->
</div><!-- #primary -->

<?php
do_action('bfg_filter_sesiones_script');
get_footer();