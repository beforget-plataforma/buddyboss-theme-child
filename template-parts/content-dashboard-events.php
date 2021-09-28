<?php
  $argsGetEvents = array(
    'posts_per_page' => -1,
    'start_date'     => 'now',
  );
  $events = tribe_get_events($argsGetEvents);
  ?>
<div class="bfg-shortcode-container bb-block-header dash-bfg-slide">
  <div class="bfg-shortcode-lading-slider active"></div>
  <div class="wrapper-post-profile bfg-slide-event">
    <?php

        foreach($events as $event) {
          $splitString = explode("calendario/", tribe_get_event_taxonomy($event->ID));
          $textCategpryArray = explode('categoria/', $splitString[0]);
          $termSlug = explode('/', $textCategpryArray[1])[0];
      ?>
    <div class="bfg-item-dash ">
      <a class="no-color" href="<?php echo get_the_permalink($event->ID); ?>">
        <div class="bfg-header-cover tribe-events-category-<?php echo $termSlug; ?> <?php echo $termSlug; ?>">
          <div class="top-item-slide icon-cat-sesion <?php echo $termSlug; ?>">
            <?php
              $iconEvent = get_stylesheet_directory_uri() . '/assets/images/'.$termSlug.'-event-icon.png';
            ?>
            <!-- <img src="<?php echo $iconEvent; ?>" alt="Icon BFG"> -->
          </div>
          <hgroup class="container-center">
            <h2>
              <?php echo $event->post_title; ?>
            </h2>
          </hgroup>
          <div class="bfg-footer-cover">
            <div class="bfg-icon">
              <img src="<?php echo wp_get_attachment_url(920); ?>" alt="">
            </div>
            <div class="bfg-content">
                <span>
                  <?php
                    $unixtimestamp = strtotime($event->event_date);
                    // echo date_i18n( "d / m / Y .", $unixtimestamp ); 
                    echo date_i18n( "d F . ", $unixtimestamp ); 
                    echo tribe_get_start_time ($event->ID, 'G:i'); ?> a
                  <?php echo tribe_get_end_time ($event->ID, 'G:i');
                    ?>
                </span>
              </div>
          </div>
        </div>
      </a>
    </div>
    <?php
          }
        ?>
  </div>
</div>