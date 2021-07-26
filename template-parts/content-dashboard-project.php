<?php
  global $post;
  $thumbID = get_post_thumbnail_id( $post->ID );
  $imgDestacada = wp_get_attachment_url( $thumbID );
  $terms = get_the_terms( $post->ID, 'ods' );
  $authorID = get_the_author_meta('ID');
  $userName = xprofile_get_field_data('1', $authorID);
  $userLastName = xprofile_get_field_data('2', $authorID);
?>
<div class="bfg-item-dash">
  <a class="no-color" href="<?php the_permalink(); ?>">
    <div class="bfg-header-cover bfg-image-bg overlay" style="background-image:url(<?php echo $imgDestacada; ?>)">
    </div>
    <div class="container-center title-item-dash">
      <h2 class="title-big"><? the_title() ?></h2>
    </div>
  </a>
</div>