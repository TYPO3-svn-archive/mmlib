<?php

/**
 *  @author: Markus Martens <m.martens@digitage.de>
 *  @version: 0.0.1
 *  @see: http://api.typo3.org/typo3v4/current/html/class_8tslib__gifbuilder_8php_source.html
 */

class tx_mmlib_gifbuilder {
  
  function confPreProcess($params,&$Obj){
    t3lib_div::devLog('tx_mmlib_gifbuilder->confPreProcess','mmlib',0,$params);
    return $params;
  }

}

?>