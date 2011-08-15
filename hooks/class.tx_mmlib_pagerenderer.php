<?php

class tx_mmlib_pagerenderer {
  
  /**
   *  parse if file is a sass
   */
  private function parseSASS($filename){
    $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mmlib']);
    if(!strcasecmp(substr($filename,-5),'.scss')){
      if(file_exists($filename)){
        $target = sprintf('typo3temp/sass/%s.css',basename($filename,'.scss'));
        exec(sprintf('%s %s %s',$extConf['sass'],$filename,$target));
        if(file_exists($target)){
          return $target;
        }
      }
    }
    return $filename;
  }
  
  /**
   * $params [array]
   * $pObj [t3lib_PageRenderer]
   */
  function renderPreProcess($params,$pObj){
    $tmp = array();
    foreach( $params['cssFiles'] as $key => $value ){
      $tmp[$this->parseSASS($key)] = $value;
    }
    $params['cssFiles'] = $tmp;
  }
    
}

?>