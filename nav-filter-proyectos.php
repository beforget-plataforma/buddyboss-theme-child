<div id="bfg-filter-tipo-proyectos" class="bfg-nav-filter bfg-mb-9 nav-filter-proyectos">
      <div class="bfg-ods-filter flex">
        <div class="bfg-block-ods">
          <?
            $terms = get_terms( array(
                'taxonomy' => 'ods',
                'hide_empty' => false,
                'orderby' => 'slug',
                'order' => 'ASC',
            ));
            $chunkTerms = array_chunk ($terms, 9);
            foreach($chunkTerms[0] as $term) {
              ?>
                <div class="bfg-filter-button-ods <? echo $term->slug; ?>">
                  <label class="bfg-container-checkbox">
                      <input  type="checkbox" value="<? echo $term->slug; ?>">
                      <span class="checkmark"><? echo $term->name; ?></span>
                  </label>
                </div>
              <?php
            }
          ?>
        </div>
        <div class="bfg-block-ods">
          <!-- <?
            
            foreach($chunkTerms[1] as $term) {
              ?>
                <div class="bfg-filter-button-ods <? echo $term->slug; ?>">
                  <label class="bfg-container-checkbox">
                      <input type="checkbox" value="<? echo $term->slug; ?>">
                      <span class="checkmark">
                        <? echo $term->name; ?>
                      </span>
                  </label>
                </div>
              <?php
            }
          ?> -->
        </div>
      </div>
    </div>