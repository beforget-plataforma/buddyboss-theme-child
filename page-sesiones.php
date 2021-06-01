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
    </div>
    <div class="bfg-count-resultados"></div>
    <div class="wrapper-post-list-sesiones flex bfg-flex-grap">
    </div>
  </main><!-- #main -->
  <div class="wrapper-button-pagination">
    <button class="ver-mas-sesiones bfg-button-primary wp-block-button__link has-white-color has-text-color has-background">Ver más sesiones</button>
  </div>
</div><!-- #primary -->

<?php
do_action('bfg_filter_sesiones_script');
get_footer();