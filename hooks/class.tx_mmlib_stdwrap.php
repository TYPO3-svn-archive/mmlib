<?php

/***************************************************************
*  Copyright notice
*  [...]
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(PATH_typo3.'/sysext/cms/tslib/interfaces/interface.tslib_content_stdwraphook.php');

class tx_mmlib_stdwrap implements tslib_content_stdWrapHook {

	function stdWrapPreProcess($content, array $configuration, tslib_cObj &$parentObject) {
		return $content;
	}
  
	function stdWrapOverride($content, array $configuration, tslib_cObj &$parentObject) {
		return $content;
	}
  
	function stdWrapProcess($content, array $conf, tslib_cObj &$parentObject) {
		if($conf['rand']){
      list($min,$max) = explode('|',$conf['rand']);
			$content = rand($min,$max);
		}
		return $content;
	}
  
	function stdWrapPostProcess($content, array $configuration, tslib_cObj &$parentObject) {
		return $content;
	}
  
}

?>