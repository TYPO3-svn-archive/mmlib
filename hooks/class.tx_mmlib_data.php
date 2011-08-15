<?php

/**
 *  Load a resource from a remote system.
 *  Usage:
 *   10 = DATA
 *   10.query
 *   10.renderObj
 *   10.renderStatics
 *   10.wrap
 *   10.stdWrap
 */

class tx_mmlib_data{
	
  function cObjGetSingleExt($name,$conf,$TSkey,$parent){
		
    return false;// TODO...
    
    if($conf['manufacturer.'])  $conf['manufacturer']  = $this->cObj->stdWrap( $conf['manufacturer'],  $conf['manufacturer.']  );
    if($conf['category.'])      $conf['category']      = $this->cObj->stdWrap( $conf['category'],      $conf['category.']      );
    
    if(empty($conf['renderObj']))     return '[rendering missing!]';
    if(empty($conf['manufacturer']))   return '[manufacturer missing!]';
    if(empty($conf['category']))       return '[category missing!]';

    $renderStatics = array();
    foreach( $conf['renderStatics.'] as $key => $val ){
      if( is_string($conf['renderStatics.'][$key]) && is_array($conf['renderStatics.'][$key.'.']) ){
        $renderStatics[$key] = $this->cObj->cObjGetSingle($conf['renderStatics.'][$key],$conf['renderStatics.'][$key.'.']);
      }
    }
    
    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      /* SELECT: */
      implode(', ',array(
        '`tx_vidowawi_product`.*',
        '`tx_vidowawi_product_manufacturer`.`name` AS "manufacturer"',
        'GROUP_CONCAT(`tx_vidowawi_product_category_mm`.`uid_foreign`) AS "category"'
      )),
      /* FROM: */
      implode(', ',array(
        '`tx_vidowawi_product`',
        '`tx_vidowawi_product_manufacturer`',
        '`tx_vidowawi_product_category_mm`'
      )),
      /* WHERE */
      implode(' AND ',array(
        '`tx_vidowawi_product_manufacturer`.`uid` = `tx_vidowawi_product`.`manufacturer`',
        '`tx_vidowawi_product_category_mm`.`uid_local` = `tx_vidowawi_product`.`uid`',
        '`tx_vidowawi_product`.`manufacturer` IN( '.$conf['manufacturer'].' )',
        '`tx_vidowawi_product_category_mm`.`uid_foreign` IN( '.$conf['category'].' )'
      )).$this->cObj->enableFields('tx_vidowawi_product'),
      /* GROUP BY */
      implode(', ',array(
        '`tx_vidowawi_product`.`uid`'
      )),
      /* ORDER BY */
      implode(', ',array(
        '`tx_vidowawi_product`.`sorting` ASC'
      )),
      /* LIMIT */
      '',
      /* INDEX */
      'uid'
    );
    
    while( $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res) ){
      $row = array_merge($renderStatics,$row);// extend with static data
      $cObj = t3lib_div::makeInstance('tslib_cObj');// create unique cObject
      $cObj->start($row,'tx_vidowawi_product');// attach data
      $content .= $cObj->cObjGetSingle($conf['renderObj'],$conf['renderObj.']);// render content
      unset($cObj);// release memory
    }
    
    $GLOBALS['TYPO3_DB']->sql_free_result($res);// release memory
    
    if($conf['wrap']) $content = $this->cObj->wrap($content,$conf['wrap']);// apply normal wrap
    if($conf['stdWrap']) $content = $this->cObj->stdWrap($content,$conf['stdWrap.']);// apply stdWrap
    
    return $content;
  }
	
}

?>