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
		return $content;
	}
  
	function stdWrapPostProcess($content, array $conf, tslib_cObj &$parentObject) {
		return $content;
	}
  
}

?>