<?php

class tx_mmlib_view{

  /**
   * This probably maps to TEMPLATE...
   */
  function cObjGetSingleExt($name,$conf,$TSkey,$parent){
    //TODO: implement cObj hook
    $content = sprintf('%s = %s(%s)<br/>',$TSkey,$name,get_class($this));
    return $content;
  }
  
}

?>