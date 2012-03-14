<?php
/***************************************************************
*  Copyright notice
*
*  (c) 1999-2011 Kasper Skårhøj (kasperYYYY@typo3.com)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
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

/**
 *
 *  @see: VERSIONING: http://typo3.org/documentation/document-library/core-documentation/doc_core_api/4.3.0/view/3/2/#id2506707
 *
 **/

function user_getActiveTO($content, $conf, $pid = 0){
  
  //t3lib_div::devLog('sys_page|object_vars','mmlib',0,get_object_vars($GLOBALS['TSFE']->sys_page));
  //t3lib_div::devLog('sys_page|class_methods','mmlib',0,get_class_methods($GLOBALS['TSFE']->sys_page));
  //t3lib_div::devLog('sys_page|versioningPreview = '.$GLOBALS['TSFE']->sys_page->versioningPreview,'mmlib',0);
  
  $row = array_shift($GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
    'uid, pid, tx_templavoila_to, tx_templavoila_next_to',
    'pages',
    'uid='.($pid?$pid:$GLOBALS['TSFE']->id)
  ));

  // overlay if previewing workspace version
  if($GLOBALS['TSFE']->sys_page->versioningPreview){
    //t3lib_div::devLog('sys_page|versioningWorkspaceId = '.$GLOBALS['TSFE']->sys_page->versioningWorkspaceId,'mmlib',0);//DEBUG
    $tmp = array_shift($GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
      implode(',',array_keys($row)),
      'pages',
      implode(' AND ',array(
        't3ver_wsid = '.$GLOBALS['TSFE']->sys_page->versioningWorkspaceId,
        't3ver_oid = '.$row['uid'],
        'pid < 0'
      ))
    ));
    if(is_array($tmp)){
      $tmp['pid'] = $row['pid'];
      $row = $tmp;
    }
  }

  //t3lib_div::devLog(json_encode($row),'mmlib',0);//DEBUG
  
  // if not current page and "tx_templavoila_next_to" is set
  if( $pid && $row['tx_templavoila_next_to'] ) return $row['tx_templavoila_next_to'];
  
  // if "tx_templavoila_to" is set
  if( $row['tx_templavoila_to'] ) return $row['tx_templavoila_to'];
  
  if( $row['pid'] ) return user_getActiveTO($content, $conf, $row['pid']);
  
  // no template found
  return 0;
}

?>