<?php

/**
 *  Handle xml data.
 *  Usage:
 *    10 = XML
 *    10.src = FILE
 *    10.src.file = fileadmin/...
 */

class tx_mmlib_xml{

  /* PUBLICS: */
  
  function cObjGetSingleExt($name,$conf,$TSkey,$parent){
    $content = sprintf('%s = %s(%s)<br/>',$TSkey,$name,get_class($this));
    return $content;
  }
  
  /* PRIVATES: */
  
}

?>