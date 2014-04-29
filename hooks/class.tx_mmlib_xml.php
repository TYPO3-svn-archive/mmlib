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
    tx_mmlib_tools::doWrap($this->cObj,$content,$conf);
    return $content;
  }
  function getData($src){
    $data = t3lib_div::xml2array($xml);
    return $data;
  }
}
?>