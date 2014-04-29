<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2004 Kasper Skaarhoj (kasper@typo3.com)
 *  (c) 2005-2010 Dmitry Dulepov (dmitry@typo3.org)
 *  All rights reserved
 *
 *  This script is part of the Typo3 project. The Typo3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
class tx_mmlib_fe{
  public function checkAlternativeIdMethodsPostProc($params){
    // see RealURL...
  }
  public function contentPostProcAll($params){
    $pObj  = $params['pObj'];
    $query = array();parse_str($_SERVER['QUERY_STRING'],$query);// parse query string
    $URL1 = array_shift(explode('?','http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));// incomming url w/o query
    $URL2 = $pObj->cObj->typoLink('',array(// should be url
      'parameter' => $GLOBALS['TSFE']->id,
      'forceAbsoluteUrl' => 1,
      'returnLast' => 'url',
    ));
    if(strcasecmp($URL1,$URL2)){
      t3lib_div::sysLog('URL MISMATCH DETECTED!','mmlib',0);
      t3lib_div::sysLog('REQUEST_URI: '.$URL1,'mmlib',0);
      t3lib_div::sysLog('  TYPO3_URI: '.$URL2,'mmlib',0);
      //header('Referer: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
      //header('Location: '.$URL2,true,301);
      //exit;
    }
    return true;
  }
}
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mmlib/hooks/class.tx_mmlib_fe.php']) {
  include_once ($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mmlib/hooks/class.tx_mmlib_fe.php']);
}
?>