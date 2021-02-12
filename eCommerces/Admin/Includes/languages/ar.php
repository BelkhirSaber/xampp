<?php
  function lang( $phrase ){
    static $lang = array(
      'admin' => 'saber in arabic',
      'message' => 'welcome in arabic'
    );
    return $lang[$phrase];
  }
?>
