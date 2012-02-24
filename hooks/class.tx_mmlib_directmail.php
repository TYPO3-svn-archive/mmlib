<?php
class tx_mmlib_directmail {
  
  function mailMarkersHook($params){
    if($params['row']['gender'] == 'm') {
      $params['markers']['###USER_salutation###'] = 'Sehr geehrter Herr';
    }else{
      $params['markers']['###USER_salutation###'] = 'Sehr geehrte Frau';
    }
    return $params;
  }
 
}
?>