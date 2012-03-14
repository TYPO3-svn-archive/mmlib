<?php
/***************************************************************
 * Copyright notice
 *
 * Based on t3mootools from Peter Klein <peter@umloud.dk>
 * (c) 2007-2010 Juergen Furrer (juergen.furrer@gmail.com)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

define('MMLIBTOOLS', TRUE);// tools loaded

/**
 * Example:
 *
 * if (t3lib_extMgm::isLoaded('mmlib')) {
 *   require_once(t3lib_extMgm::extPath('mmlib').'class.tx_mmlib_tools.php');
 * }
 *
 * if (MMLIBTOOLS === TRUE) {
 *   $query = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select,$from,$where,$groupby,$orderby,$limit,$index);
 *   $query = tx_mmlib_tools::versioningOL($query);
 *   $query = tx_mmlib_tools::filterHidden($query);
 *   foreach( $query as $index => $row ){ ... }
 *   unset($query);
 * }
 *
 */
class tx_mmlib_tools{
  
  /**
   *  handle versioning
   *
   *  @params   array   $data: array containing rows from query
   *  @return   array   modified query
   *
   **/
  static function versioningOL($data){
    $tmp = self::getWSData($data);// get live data
    if($GLOBALS['TSFE']->sys_page->versioningPreview){// if in versioning preview
      foreach( self::getWSData($data,$GLOBALS['TSFE']->sys_page->versioningWorkspaceId) as $uid => $row ){// cycle throu previews
        $tmp[$row['t3ver_oid']] = $row;// overlay live with preview
        //t3lib_div::devLog('versioningOL','mmlib',0,$tmp[$row['t3ver_oid']]);
      }
    }
    return $tmp;
  }
  
  /**
   *  filter hidden and deleted elements from a query result
   *
   *  @params   array   $data: array containing rows from query
   *  @return   array   reduced query
   *
   **/
  static function filterHidden($data){
    return array_filter($data,function($row){
      return ( $row['deleted'] == 0 ) && ( $row['hidden'] == 0 );
    });
  }
  
  /**
   *  filter rows for given workspace and swap uid <=> t3ver_oid
   *  or return live data if no worspace given
   *
   *  @params   array   $data: array containing rows from query
   *  @param    int     $wsid: uid of workspace or 0 for live data
   *  @return   array   modified query
   *
   **/
  static function getWSData($data,$wsid = 0){
    if($wsid > 0){// workspace data
      array_walk($data,function(&$row,$uid,$wsid){
        if( ($row['pid'] > -1) || ($row['t3ver_wsid'] != $wsid)) $row = false;// flag live data
      },$wsid);
      return array_filter($data);// strip flagged data
    }else{// live data
      return array_filter($data,function($row){
        return $row['pid'] > -1;// live data has pid
      });
    }
  }
  
  /** 
   *  helper for querys
   *
   *  @param    cObj    $cObj: current cObj
   *  @param    string  $content: current content
   *  @param    array   $conf: current configuration
   *  @param    array   $query: array containing query parts
   *  @param    string  $table: current table name
   *  @param    bool    $overlay: apply workspace and hiding (optional)
   *  @return   string  new content
   *
   **/
  static function renderQuery($cObj,$content,$conf,$query,$table,$overlay=true){
    $result = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
      implode(', ',   $query['SELECT']  ),
      implode(', ',   $query['FROM']    ),
      implode(' AND ',$query['WHERE']   ),
      implode(', ',   $query['GROUPBY'] ),
      implode(', ',   $query['ORDERBY'] ),
      $query['LIMIT'],
      'uid'
    );
    if($overlay){// apply versioning & co
      $result = self::versioningOL($result);// handle versioning
      $result = self::filterHidden($result);// handle hidden
    }
    $NUM_ROWS = count($query);
    if(!is_array($conf['renderObj.']))return $NUM_ROWS;// return number of entrys if no rendering given
    $cObj->LOAD_REGISTER(array(strtoupper($table.'_ROWS')=>$NUM_ROWS),'');// load count to register
    $COUNTER = 0;
    foreach( $result as $index => $row ){
      $cObj = t3lib_div::makeInstance('tslib_cObj');// create unique cObject
      $cObj->start($row,$table);// attach data
      $cObj->LOAD_REGISTER(array(
        'COUNTER'   => $COUNTER++
      ),'');
      $content .= $cObj->cObjGetSingle($conf['renderObj'],$conf['renderObj.']);// render content
      unset($cObj);// release memory
    }
    unset($result);// release memory
    return $content;
  }
  
  /** 
   *  apply wrap and stdWrap if present
   *  
   *  @param    cObj    $cObj: current cObj
   *  @param    string  $content: current content
   *  @param    array   $conf: current configuration
   *  @return   string  new content
   *  
   **/
  static function doWrap($cObj,$content,$conf){
    if($conf['wrap']) $content = $cObj->wrap($content,$conf['wrap']);
    if($conf['stdWrap.']) $content = $cObj->stdWrap($content,$conf['stdWrap.']);
    return $content;
  }
  
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3jquery/class.tx_mmlib.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3jquery/class.tx_mmlib.php']);
}
?>