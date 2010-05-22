<?php

/***************************************************************
*  Copyright notice
*  [...]
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(PATH_typo3.'/sysext/cms/tslib/interfaces/interface.tslib_content_stdwraphook.php');

class tx_mmlib_stdwrap implements tslib_content_stdWrapHook {

  private $listNumCount = 0;

	function stdWrapPreProcess($content, array $conf, tslib_cObj &$parentObject) {
    if($conf['listNum.']['stdWrap.']['rand']){
      print(t3lib_div::view_array($conf).htmlspecialchars($content).'<hr>');
      $this->listNumCount = count(explode(',',$content));
    }
		return $content;
	}
  
	function stdWrapOverride($content, array $conf, tslib_cObj &$parentObject) {
    if($conf['listNum.']['stdWrap.']['rand']){
      print(t3lib_div::view_array($conf).htmlspecialchars($content).'<hr>');
      $this->listNumCount = count(explode(',',$content));
    }
		return $content;
	}
  
	function stdWrapProcess($content, array $conf, tslib_cObj &$parentObject) {
		if($conf['rand']){
      print(htmlentities($content).$this->listNumCount);
      list($min,$max) = explode('|',$conf['rand']);
			$content = rand($min,$max);
		}
		return $content;
	}
  
	function stdWrapPostProcess($content, array $conf, tslib_cObj &$parentObject) {
		return $content;
	}
  
}

?>