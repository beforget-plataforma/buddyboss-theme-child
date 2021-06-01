<?
// $the_query->the_post();

// 
  $users = get_field("ponente");
  $userName = xprofile_get_field_data('1', $users[0]->ID);
  $userLastName = xprofile_get_field_data('2', $users[0]->ID);
  $terms = get_the_terms( $post->ID, 'tipo-sesion' );
?>

<div class="bfg-item-sesiones">
  <a class="no-color" href="<?php the_permalink(); ?>">
    <div class="bfg-header-cover-sesiones item-profile flex" style="background-color:<?php the_field('brand_color'); ?>">
        <span class="bfg-icon-smile inprofile">
            <img src="<? echo wp_get_attachment_url(171); ?>" alt="">
        </span>
        <hgroup>
          <div class="bfg-container-title item-profile ">
            <?php
              $title = get_the_title();
              $short_title = wp_trim_words( $title, 12, '...' );
            ?>
            <h1><? echo $title; ?></h1>
          </div>
            <?
              $args = array( 
                'item_id' => get_the_author_meta('ID'), 
                'object' => '', 
                'type' => '' 
              ); 
            ?>
            <?php
            $users = get_field("ponente");
            $ponenteName = $users[0]->display_name;
            $ponenteAvatar = get_avatar($users[0]->ID);

            ?>
            <div class="bfg-profile-author bfg-icon-small">
            <?
              echo $ponenteAvatar;
            ?>
            <span><? echo $userName . ' ' . $userLastName; ?></span>
          </div>
        </hgroup>
    </div>
    <span class="line-divisor <? echo $terms[0]->slug; ?>"></span>
    <div class="bfg-content-inprofile">
        <?php
          the_excerpt();
        ?>
    </div>
    <div class="line footer-date"></div>
    <div class="flex bfg-footer-item">
      <div class="bfg-icon-date inprofile">
          <img src="<? echo get_stylesheet_directory_uri() . '/assets/images/bfg-icon-date.png'; ?>" alt="">
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
  