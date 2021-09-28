<?php
// $the_query->the_post();

// 
  $users = get_field("ponente");
  
  $terms = get_the_terms( $post->ID, 'tipo-sesion' );
  $participantes = get_post_meta( get_the_ID(), 'ponente', true);

  $userName = xprofile_get_field_data('1', $participantes[0]);
  $userLastName = xprofile_get_field_data('2', $participantes[0]);
  $ponenteAvatar = get_avatar($participantes[0]);
  $participantes = get_post_meta( get_the_ID(), 'ponente', true);
?>

<div class="bfg-item-dash">
  <a class="no-color" href="<?php the_permalink(); ?>">
    <div class="bfg-header-cover bfg-header-utopic <?php echo $terms[0]->slug; ?>">
      <div class="top-item-slide icon-cat-sesion sesiones">
        <!-- <img src="<? echo wp_get_attachment_url(1135); ?>" alt="Icon BFG"> -->
      </div>
      <hgroup class="container-center">
        <?php
            $title = get_the_title();
            $short_title = wp_trim_words( $title, 12, '...' );
          ?>
        <h2>
          <?php echo $short_title; ?>
        </h2>

      </hgroup>
      <?php
        $args = array( 
          'item_id' => get_the_author_meta('ID')
        ); 
      ?>
      <?php
        $users = get_field("ponente");
        ?>
        
        <?php
        // $ponenteName = $users[0]->display_name;
      ?>
      <div class="bfg-footer-cover">
        <?php
        if($participantes[0] != null){
          ?>
          <div class="bfg-icon bfg-member-avatar"">
           <?php echo $ponenteAvatar; ?>
          </div>
          <div class="bfg-content">
            <span>
              <?php echo $userName . ' ' . $userLastName; ?>
            </span>
          </div>
        <?php
            }else{
          ?>
          <div class="bfg-icon bfg-member-avatar">
            <img class="bfg-avatar-reset" src="<?php echo wp_get_attachment_url(805); ?>" alt="">
          </div>
          <div class="bfg-content">
            <span>
              <?php echo 'BeForGet';?>
            </span>
          </div>
        <?php
          }
        ?>
      </div>
    </div>
  </a>
</div>