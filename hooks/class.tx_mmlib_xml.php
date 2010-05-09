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
    //$content = sprintf('%s = %s(%s)<br/>',$TSkey,$name,get_class($this));
    
    //$src = $parent->cObjGetSingle($conf['src'],$conf['src.'],'src');
    if($conf['src.']) $conf['src'] = $parent->stdWrap($conf['src'],$conf['src.']);
    
    $xml = simplexml_load_string($conf['src']);
    $data = array();
    foreach($xml->children() as $key => $value) $data[$key][] = $value->asXML();
    foreach($data as $key => $value) $data[$key] = implode(chr(0),$value);
    
    var_dump($data);
    
    $parent->data = $data;
    
    $content = $parent->cObjGetSingle($conf['renderObj'],$conf['renderObj.'],'renderObj');
    
    if ($conf['stdWrap.']) $content = $parent->stdWrap($content,$conf['stdWrap.']);// apply total stdWrap
    
    return $content;
  }
  
  /* PRIVATES: */
  
}

?>