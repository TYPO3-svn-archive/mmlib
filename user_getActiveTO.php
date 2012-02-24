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

function user_getActiveTO($content, $conf, $pid = 0){
  
  $row = array_shift($GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
    'pid, tx_templavoila_to, tx_templavoila_next_to',
    'pages',
    'uid='.($pid?$pid:$GLOBALS['TSFE']->id)
  ));

  t3lib_div::devLog('user_getActiveTO','mmlib',0,array(
    'page' => $GLOBALS['TSFE']->id,
    'row' => $row,
    'pid' => $pid
  ));
  
  // if not current page and "tx_templavoila_next_to" is set
  if( $pid && $row['tx_templavoila_next_to'] ) return $row['tx_templavoila_next_to'];
  
  // if "tx_templavoila_to" is set
  if( $row['tx_templavoila_to'] ) return $row['tx_templavoila_to'];
  
  if( $row['pid'] ) return user_getActiveTO($content, $conf, $row['pid']);
  
  // no template found
  return 0;
}

?>