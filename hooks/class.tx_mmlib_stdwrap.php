<?php
/***************************************************************
*  Copyright notice
*  [...]
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
require_once(PATH_tslib.'interfaces/interface.tslib_content_stdwraphook.php');
require_once(PATH_tslib.'interfaces/interface.tslib_content_getdatahook.php');
class tx_mmlib_stdwrap implements tslib_content_stdWrapHook, tslib_content_getDataHook {
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
    /**
     *  provides preg_match() for stdWrap
     *  $content => subject
     *  $conf['regex'] => pattern
     */
    if(!empty($conf['regex'])){
      $content = preg_match($conf['regex'],$content);
    }
    return $content;
  }
  function stdWrapPostProcess($content, array $conf, tslib_cObj &$parentObject) {
    return $content;
  }
  /*  
   *  extend getData
   *  
   */
	public function getDataExtension($getDataString, array $fields, $sectionValue, $returnValue, tslib_cObj &$parentObject){
		if(preg_match('/^session:(.*)$/i',$getDataString,$matches)){
      $returnValue = $GLOBALS['TSFE']->fe_user->getKey('ses','mmlib_'.$matches[1]);
    }
		return $returnValue;
	}
}
?>