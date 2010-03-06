<?php

class tx_mmlib_model{

  /**
   * This probably maps to CONTENT...
   */
  function cObjGetSingleExt($name,$conf,$TSkey,$parent){
    //TODO: implement cObj hook
    $content = sprintf('%s = %s(%s)<br/>',$TSkey,$name,get_class($this));
    return $content;
  }
  
}

?>