<?php

/**
 *  Handle xml data.
 */

define('SPLITCHAR',"\0");

class tx_mmlib_xml{

  function cObjGetSingleExt($name,$conf,$TSkey,$parent){
    if($conf['src.']){
      $conf['src'] = $parent->cObjGetSingle($conf['src'],$conf['src.'],'src');
      unset($conf['src.']);
    }
    print(t3lib_div::view_array($conf).'<hr>');
    if(empty($conf['src']))return 'no src';
    $content = '';
    $parent->data = $this->getData($conf['src']);
    $content .= $parent->cObjGetSingle($conf['renderObj'],$conf['renderObj.'],'renderObj');
    if($conf['stdWrap.'])$content = $parent->stdWrap($content,$conf['stdWrap.']);// apply total stdWrap
    return $content;
  }
  
  function getData($src){
    $xml = simplexml_load_string($src);
    if(!$xml)return null;
    $data = array();
    foreach( $xml->children() as $key => $child){
      $data['child:'.$key][] = $child->asXML();
    }
    foreach( $data as $key => $child ){
      $data[$key] = implode(SPLITCHAR,$child);
    }
    foreach( $xml->attributes() as $key => $attribute){
      $data[$key] = strval($attribute);
    }
    $data['this:name'] = $xml->getName();
    return $data;
  }
  
}

?>