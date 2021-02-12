<?php
  function lang( $phrase ){
    static $lang = array(
      //navbar
      'ADMIN-HOME'    => 'Home',
      'CATEGORIE'     => 'Categorie',
      'ITEM'          => 'Item',
      'MEMBERS'       => 'Members',
      'STATISTICS'    => 'Statistics',
      'LOGS'          => 'Logs',
      'EDIT-PROFILE'  => 'Edit Profile',
      'COMMENTS'      => 'Comments',
      'SETTING'       => 'Setting',
      'LOGOUT'        => 'Logout',
      'VISIT-SHOP'    => 'Visit Shop'

    );
    return $lang[$phrase];
  }
?>
