<?php

/**
 *  Direct mapping to exec_SELECTgetRows()
 *  
 *  Usage:
 *   10 = QUERY
 *   10.fields    : 
 *   10.table     : 
 *   10.where     : 
 *   10.groupBy   : 
 *   10.orderBy   : 
 *   10.limit     : 
 *   10.renderObj : 
 *   10.wrap      : 
 *   10.stdWrap   : 
 *   
 */

class tx_mmlib_query{
	
  function cObjGetSingleExt($name,$conf,$TSkey,$parent){
    
    if($conf['fields.'])  $conf['fields']   = $parent->stdWrap($conf['fields'],   $conf['fields.']  );
    if($conf['table.'])   $conf['table']    = $parent->stdWrap($conf['table'],    $conf['table.']   );
    if($conf['where.'])   $conf['where']    = $parent->stdWrap($conf['where'],    $conf['where.']   );
    if($conf['groupBy.']) $conf['groupBy']  = $parent->stdWrap($conf['groupBy'],  $conf['groupBy.'] );
    if($conf['orderBy.']) $conf['orderBy']  = $parent->stdWrap($conf['orderBy'],  $conf['orderBy.'] );
    if($conf['limit.'])   $conf['limit']    = $parent->stdWrap($conf['limit'],    $conf['limit.']   );

    $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
      $conf['fields']?$conf['fields']:'*',
      $conf['table'],
      $conf['where'],
      $conf['groupBy'],
      $conf['orderBy'],
      $conf['limit']
    );
    
    if($conf['renderObj']){// render each as specified
      foreach($rows as $index => $row){
        $cObj = t3lib_div::makeInstance('tslib_cObj');// work on private element
        $cObj->start($row,$conf['table']);
        $content .= $cObj->cObjGetSingle($conf['renderObj'],$conf['renderObj.']);
        unset($cObj);
      }
    }else{// return amount of affected rows
      $content .= count($rows);
    }
    
    if($conf['wrap']) $content = $parent->wrap($content,$conf['wrap']);// enable total wrap
    if($conf['stdWrap.']) $content = $parent->stdWrap($content,$conf['stdWrap.']);// enable total stdWrap
    
    return $content;
  }
	
}

?>