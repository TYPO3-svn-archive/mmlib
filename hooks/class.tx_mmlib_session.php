<?php
/**
 *  session handling for typoscript
 *
 *  Usage:
 *   10 = LOAD_SESSION
 *   10.name = ...
 *
 */
class tx_mmlib_session{
  function cObjGetSingleExt($name,$conf,$TSkey,$parent){
    // handle stdWraps...
    foreach(array_keys(array_filter($conf,'is_array')) as $key){
      $conf[rtrim($key,'.')] = $parent->stdWrap($conf[rtrim($key,'.')],$conf[$key]); unset($conf[$key]);
    }
    // set session variables...
    foreach($conf as $key => $value)if(!empty($value)){
      $GLOBALS['TSFE']->fe_user->setKey('ses','mmlib_'.$key,$value);
    }
    return null;
  }
}
?>