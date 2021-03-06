<?php
    /*$
  argsGetEvents = array(
      'eventDisplay'   => 'custom',
      'start_date'   => 'last month',
      'end_date'     => 'next month',
      'posts_per_page' => 10,
      'order' => 'DESC',
      'hide_upcoming' => false,
    );
  */
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
          $textCategpryArray = explode('categoria/', $splitString[1]);
          $termSlug = explode('/', $textCategpryArray[1])[0];
      ?>
    <div class="bfg-item-dash">
      <a class="no-color" href="<?php echo get_the_permalink($event->ID); ?>">
        <div class="bfg-header-cover tribe-events-category-<? echo $termSlug; ?>">
          <div class="top-item-slide icon-cat-sesion <? echo $termSlug; ?>">
            <?php
              $iconEvent = get_stylesheet_directory_uri() . '/assets/images/'.$termSlug.'-event-icon.png';
            ?>
            <img src="<?php echo $iconEvent; ?>"
              alt="Icon BFG">
          </div>
          <hgroup class="container-center">
            <?php
                $title = get_the_title();
                $short_title = wp_trim_words( $title, 12, '...' );
              ?>
            <h2>
              <? echo $event->post_title; ?>
            </h2>
          </hgroup>
          <div class="bfg-footer-cover">
            <div class="bfg-icon">
              <img src="<? echo wp_get_attachment_url(247); ?>" alt="">
            </div>
            <div class="bfg-content">
                <span>
                  <? 
                    $unixtimestamp = strtotime($event->event_date);
                    // echo date_i18n( "d / m / Y .", $unixtimestamp ); 
                    echo date_i18n( "d F . ", $unixtimestamp ); 
                    echo tribe_get_start_time ($event->ID, 'G:i'); ?> a
                  <? echo tribe_get_end_time ($event->ID, 'G:i');
                    ?>
                </span>
              </div>
          </div>
        </div>
      </a>
    </div>
    <?
          }
        ?>
  </div>
</div>