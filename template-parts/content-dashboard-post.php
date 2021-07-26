<?
// $the_query->the_post();

// 
  $users = get_field("ponente");
  
  $terms = get_the_terms( $post->ID, 'tipo-sesion' );
  $participantes = get_post_meta( get_the_ID(), 'ponente', true);

  $author_id = get_post_field ('post_author', $post->ID);
  $display_name = get_the_author_meta( 'display_name' , $author_id );


  $ponenteName = $author_id->display_name;
  $ponenteAvatar = get_avatar($participantes[0]);
  $userName = xprofile_get_field_data('1', $author_id);
  $userLastName = xprofile_get_field_data('2', $author_id);
  $ponenteAvatar = get_avatar($author_id);
  $thumbID = get_post_thumbnail_id( $post->ID );
  $imgDestacada = wp_get_attachment_image_src( $thumbID, 'medium' )[0];

?>

<div class="bfg-item-dash">
  <a class="no-color" href="<?php the_permalink(); ?>">
    <div class="bfg-header-cover bfg-image-bg">
      <div class="bfg-cover-image" style="background-image:url(<?php echo $imgDestacada; ?>)"></div>  
      <hgroup class="container-center">
      <?php
            $title = get_the_title();
            $short_title = wp_trim_words( $title, 12, '...' );
            ?>
          <h2 class="title-post"><? echo $short_title; ?></h2>
          
      </hgroup>
      <div class="bfg-footer-cover">
      <div class="bfg-icon bfg-member-avatar">
            <?
              echo $ponenteAvatar;
            ?>
        </div>
        <div class="bfg-content avatarName">
          <span><? echo $userName . ' ' . $userLastName; ?></span>
        </div>
      </div>
    </div>
  </a>
</div>
  