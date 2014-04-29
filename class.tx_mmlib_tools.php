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
  /**
   *  apply wrap and stdWrap if present
   *
   *  @param    array   $fields   list of fields to stdWrap
   *  @param    $conf   $conf     current configuration
   *
   **/
  static function applyStdWrap(&$cObj,$fields,&$conf){
    foreach( $fields as $param ){
      if($conf[$param.'.']){
        $conf[$param] = $cObj->stdWrap($conf[$param],$conf[$param.'.']);
      }
    }
  }
  /**
   *  append where clause
   *
   **/
  static function appendWhere(&$conf,$name,$field,$mask){
    if(preg_match($mask,$conf[$name]) === 1){
      if(!empty($conf['where'])) $conf['where'] .= ' AND ';
      $conf['where'] .= '`'.$field.'` IN ('.trim($conf[$name]).')';
    }
  }
  /**
   *  get extension configurations
   *
   *  @param  string   $key  extension key
   *
   **/
  static function getExtConf($key){
    return unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$key]);
  }
  /**
   *  control dev-log via this extension
   *
   **/
  static function isDevLog(){
    $conf = self::getExtConf('mmlib');
    return $conf['devlog'];
  }
  
  /* * * * * * * * * * * * * * * * * * * * * * DATABASE HANDLERS * * * * * * * * * * * * * * * * * * * * * * * * * * * */
  
  /**
   *  apply filtering non-visible to where clause
   *
   *  @param  array   $where  original where-clause
   *  @param  string  $table  table to work on
   *
   **/
  static function enableFields(&$where,$table){
    if(!empty($where)) $where .= ' AND ';// prefix if needed
    $where .= '('.implode(' OR ',array(
      '`'.$table.'`.`sys_language_uid` IN (-1,0)',
      '('.implode(' AND ',array(
        '`'.$table.'`.`sys_language_uid` = '.$GLOBALS['TSFE']->sys_language_uid,
        '`'.$table.'`.`l18n_parent` = 0'
      )).')'
    )).')';
    $where .= $GLOBALS['TSFE']->sys_page->enableFields($table);// add hidden = 0, deleted = 0, group and date statements
  }
  /**
   * check for language overlay if:
   * - row is valid
   * - row language is different from currently needed language
   * - sys_language_contentOL is set
   *
   *  @param  string  $table  table to work on
   *  @param  array   $row    data row to overlay
   *  @return array   translated data row if possible
   *
   *  @attention: includes versionOL!
   *
   **/
  static function getRecordOverlay(&$data,$table){
    array_walk($data,function(&$row,$uid,$table){
      if(is_array($row) && $row['sys_language_uid'] != $GLOBALS['TSFE']->sys_language_content && $GLOBALS['TSFE']->sys_language_contentOL){
        $row = $GLOBALS['TSFE']->sys_page->getRecordOverlay($table,$row,$GLOBALS['TSFE']->sys_language_content,$GLOBALS['TSFE']->sys_language_contentOL);
      }
    },$table);
  }
  /**
   *  sort data
   *
   *  @param  array   $data
   *  @param  string  $field
   *
   **/
  static function orderBy(&$data,$field){
    uasort($data,function($a,$b) use ($field){
      return strnatcasecmp($a[$field],$b[$field]);
    });
  }
  /**
   *  reduce to given field
   *
   **/
  static function reduceTo($data,$field,$unique=false){
    $data = array_map(function($row) use ($field) {return $row[$field];},$data);
    if($unique) $data = array_unique($data);
    return $data;
  }
  /**
   *  query entries from database as array of rows
   *
   *  @param  string  $table  table to work on
   *  @param  array   $where  original where-clause
   *
   **/
  static function queryTable($table,$where='',$groupBy='',$orderBy='',$limit=''){
    self::enableFields($where,$table);// apply default conditions
    $data = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*',$table,$where,$groupBy,'',$limit,'uid');
    self::getRecordOverlay($data,$table);// apply translations and workspaces
    if($orderBy)self::orderBy($data,$orderBy);// sort data
    $data = array_filter($data);// remove empty rows
    return $data;
  }
  /**
   *  query entries from database as array of rows
   *
   **/
  static function queryTableMM($table,$foreigns){
    $data = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid_local',$table,'uid_foreign IN ('.$foreigns.')','uid_local');
    $data = self::reduceTo($data,'uid_local',true);
    return $data;
  }
  /**
   *  query entries from database as array of rows
   *
   **/
  static function queryTableMMrev($table,$locals){
    $data = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid_foreign',$table,'uid_local IN ('.$locals.')','uid_foreign');
    $data = self::reduceTo($data,'uid_foreign',true);
    return $data;
  }
  /**
   *  expand mm-data-fields with list of uids
   *
   **/
  static function expandMM(&$data,$field,$table){
    array_walk($data,function(&$row,$uid,$udata){
      list($field,$table) = $udata;
      $row[$field] = implode(',',tx_mmlib_tools::queryTableMMrev($table,$uid));// get list of uid
    },array($field,$table));
  }  
  /**
   *  filter data by comma seperated list of values
   *
   **/
  static function filterDataByValues(&$data,$field,$values){
    $data = array_filter($data,function($row) use ($values,$field){
      return count(array_intersect(
        array_map('trim',explode(',',$row[$field])),
        array_map('trim',explode(',',$values))
      ));
    });
  }
  /**
   *  render array of rows by given typoscript
   *
   **/
  static function renderData($cObj,$content,$conf,$table,$data){
    $NUM_ROWS = count($data);
    if( !is_array($conf['renderObj.']) && !preg_match('|^\s*<|',$conf['renderObj']) )return $NUM_ROWS;// return number of entrys if no rendering given
    $cObj->LOAD_REGISTER(array(strtoupper($table.'_ROWS')=>$NUM_ROWS),'');// load count to register
    $COUNTER = 0;
    foreach( $data as $index => $row ){// for each row
      $cObj = t3lib_div::makeInstance('tslib_cObj');// create unique cObject
      $cObj->start($row,$table);// attach data
      $cObj->LOAD_REGISTER(array(
        'COUNTER' => $COUNTER++
      ),'');
      $content .= $cObj->cObjGetSingle($conf['renderObj'],$conf['renderObj.']);// append to content
      unset($cObj);// release memory
    }
    return $content;
  }
  /* * * * * * * * * * * * * * * * * * * * * * * * * DEPRECATED * * * * * * * * * * * * * * * * * * * * * * * * * * * */
  /**
   * filter rows where given field is empty
   *
   *  @param  array   $data   rows to filter
   *  @param  string  $field  fieldname to test
   *
   **/
  static function filterEmpty(&$data,$field){
    $data = array_filter($data,function($row){return !empty($row[$field]);});
  }
  /**
   * filter rows where given field is empty
   *
   *  @param  array   $data   rows to filter
   *  @param  string  $field  fieldname to test
   *
   **/
  static function filterTable(&$data,$field,$value=null){
    if($value==null){
      $data = array_filter($data,function($row){return !empty($row[$field]);});
    }else{
      $data = array_filter($data,function($row) use ($value){return !strcmp($row[$field],$value);});
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
    if(self::isDevLog())$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = TRUE;
    $result = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
      implode(', ',   $query['SELECT']  ),
      implode(', ',   $query['FROM']    ),
      implode(' AND ',$query['WHERE']   ),
      implode(', ',   $query['GROUPBY'] ),
      implode(', ',   $query['ORDERBY'] ),
      $query['LIMIT'],
      'uid'
    );
    if(self::isDevLog()){
      t3lib_div::devLog('->renderQuery','mmlib',0,array($GLOBALS['TYPO3_DB']->debug_lastBuiltQuery));//DEBUG
      $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = FALSE;
    }
    if($overlay){// apply versioning & co
      $result = self::versioningOL($result);// handle versioning
      $result = self::filterHidden($result);// handle hidden
    }
    $content = self::renderData($cObj,$content,$conf,$table,$result);
    unset($result);// release memory
    return $content;
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
        if(self::isDevLog())t3lib_div::devLog('->versioningOL','mmlib',0,$tmp[$row['t3ver_oid']]);//DEBUG
      }
    }
    return $tmp;
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
}
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3jquery/class.tx_mmlib.php']) {
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3jquery/class.tx_mmlib.php']);
}
?>