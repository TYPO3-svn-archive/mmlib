<?php

class tx_mmlib_controller{

  /**
   * This probably maps to USER(_INT) ...
   */
  function cObjGetSingleExt($name,$conf,$TSkey,$parent){
    //TODO: implement cObj hook
    $content = sprintf('%s = %s(%s)<br/>',$TSkey,$name,get_class($this));
    return $content;
  }
  
}

?>