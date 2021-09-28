<?php
  $argsGetMembers = array(
    'type' => 'active',
    'per_page' => 20,
    'populate_extras' => true,
	);
  $avarMembers = [];
	$members = bp_core_get_users($argsGetMembers);
  foreach($members["users"] as $member) {
    $objMember = (object) [
      'avatar' => get_avatar($member->ID),
      'id' => $member->ID,
    ];
    array_push($avarMembers, $objMember);
  }
?>
   <div class="wrapper-post-profile bfg-slide-member dash-bfg-slide">
     <?php
           foreach($avarMembers as $key => $value) {
             ?>
               <div class="bfg-item-dash">
                <div class="bfg-member-avatar">
                  <a href="<?php echo bp_core_get_user_domain($value->id); ?>">
                    <?php echo $value->avatar;?>
                  </a>
                </div>
              </div>
             <?php
           }
         ?>
   </div>
  <div class="bfg-shortcode-lading-slider active"></div>
