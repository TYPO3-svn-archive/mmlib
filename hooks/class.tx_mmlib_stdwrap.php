<?php
/***************************************************************
*  Copyright notice
*  [...]
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
require_once(PATH_typo3.'/sysext/cms/tslib/interfaces/interface.tslib_content_stdwraphook.php');
class tx_mmlib_stdwrap implements tslib_content_stdWrapHook {
  private $listNumCount = null;
  function stdWrapPreProcess($content, array $conf, tslib_cObj &$parentObject) {
    if($conf['listNum.']['stdWrap.']['rand']){
      $this->listNumCount = count(explode(',',$content));
    }
    return $content;
  }
  function stdWrapOverride($content, array $conf, tslib_cObj &$parentObject) {
    return $content;
  }
  function stdWrapProcess($content, array $conf, tslib_cObj &$parentObject) {
    if($conf['rand']){
      list($min,$max) = explode('|',$conf['rand']);
      if($max=='max') $max = ($this->listNumCount-1);
      $content = rand($min,$max);
    }
    if($conf['flexform']){
      $pi_flexform = t3lib_div::xml2array($content);
      $field   = $conf['flexform'];
      if($conf['flexform.']['stdWrap.']) $field = $parentObject->stdWrap($field,$conf['flexform.']['stdWrap.']);
      $sheet = $conf['flexform.']['sheet']?$conf['flexform.']['sheet']:'sDEF';
      if(is_array($conf['flexform.']['sheet.'])) $sheet = $parentObject->stdWrap($sheet,$conf['flexform.']['sheet.']);
      $lang = $conf['flexform.']['lang']?$conf['flexform.']['lang']:'lDEF';
      if(is_array($conf['flexform.']['lang.'])) $lang = $parentObject->stdWrap($lang,$conf['flexform.']['lang.']);
      $value = $conf['flexform.']['value']?$conf['flexform.']['value']:'vDEF';
      if(is_array($conf['flexform.']['value.'])) $value = $parentObject->stdWrap($value,$conf['flexform.']['value.']);
      $content = $pi_flexform['data'][$sheet][$lang][$field][$value];
    }
    /**
     *  provides pathinfo() for stdWrap
     *  $content => filepath
     *  $conf['pathinfo'] => getText
     */
    if($conf['pathinfo']){
      $cObj = t3lib_div::makeInstance('tslib_cObj');
      $cObj->start(pathinfo($content));
      $content = $cObj->TEXT(array(
        'value' => $conf['pathinfo'],
        'insertData' => 1
      ));
      unset($cObj);
    }
    /**
     *  provides sprintf() for stdWrap
     *  $content => format
     *  $conf['sprintf'] => args
     */
    if($conf['sprintf.']){
      foreach($conf['sprintf.'] as $key => $value)if(is_array($conf['sprintf.'][$key.'.'])){
        $conf['sprintf.'][$key] = $parentObject->cObjGetSingle($conf['sprintf.'][$key],$conf['sprintf.'][$key.'.']);
        unset($conf['sprintf.'][$key.'.']);
      }
      $content = vsprintf($content,$conf['sprintf.']);
    }
    return $content;
  }
  function stdWrapPostProcess($content, array $conf, tslib_cObj &$parentObject) {
    return $content;
  }
}
?>