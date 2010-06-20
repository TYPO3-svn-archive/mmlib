<?php

/**
 *  Handle xml data.
 */

define('SPLITCHAR',"\0");

class tx_mmlib_xml{

  private $cObj = null;

  function __construct(){
    $this->cObj = t3lib_div::makeInstance('tslib_cObj');
  }
  
  function cObjGetSingleExt($name,$conf,$TSkey,$parent){
    $src = $parent->cObjGetSingle($conf['src'],$conf['src.'],$TSkey.'.src');
    $this->cObj->start($this->getData($src));
    $content = $this->cObj->cObjGetSingle($conf['renderObj'],$conf['renderObj.'],$TSkey.'.renderObj');
    if($conf['stdWrap.'])$content = $this->cObj->stdWrap($content,$conf['stdWrap.']);// apply total stdWrap
    return $content;
  }
  
  function getData($src){
    $xml = simplexml_load_string($src);
    if(!$xml)return null;
    $data = array();
    foreach( $xml->children() as $key => $child) $data['child:'.$key][] = $child->asXML();
    foreach( $data as $key => $child ) $data[$key] = implode(SPLITCHAR,$child);
    foreach( $xml->attributes() as $key => $attribute) $data[$key] = strval($attribute);
    //$data['this:data'] = t3lib_div::view_array($data);
    //$data['this:src'] = $src;
    $data['this:name'] = $xml->getName();
    return $data;
  }
  
}

?>