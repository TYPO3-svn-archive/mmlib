<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Markus Martens <markus.martens@jobesoft.de>
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
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Typoscript cObject' for the 'mmlib' extension.
 *
 * @author  Markus Martens <markus.martens@jobesoft.de>
 * @package  TYPO3
 * @subpackage  tx_mmlib
 */
class tx_mmlib_pi1 extends tslib_pibase {
  var $prefixId      = 'tx_mmlib_pi1'; // Same as class name
  var $scriptRelPath = 'pi1/class.tx_mmlib_pi1.php';  // Path to this script relative to the extension dir.
  var $extKey        = 'mmlib';  // The extension key.
  
  /**
   * The main method of the PlugIn
   *
   * @param  string    $content: The PlugIn content
   * @param  array    $conf: The PlugIn configuration
   * @return  The content that is displayed on the website
   */
  function main($content,$conf)  {
    $this->conf = $conf;
    $this->pi_setPiVarDefaults();
    $this->pi_loadLL();
    $this->pi_initPIflexForm();
    $tspath = strval($this->cObj->data['pi_flexform']['data']['general']['lDEF']['tspath']['vDEF']);
    $caching = intval($this->cObj->data['pi_flexform']['data']['general']['lDEF']['caching']['vDEF']);
    $this->pi_USER_INT_obj = $caching;  // Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!
    $content = $this->cObj->cObjGetSingle('COA',array( '10' => '< '.$tspath ));
    return $this->pi_wrapInBaseClass($content);
  }

  // converts an php-array into an js-array
  static function array_js($conf,$prefix=''){
    $line = array();
    if(is_numeric(implode('',array_keys($conf)))){// numeric array
      foreach($conf as $key => $value){
        if(is_array($value))
          $line[] = self::array_js($value,$prefix);
        elseif(is_numeric($value))
          $line[] = floatval($value);
        elseif(!strcasecmp($value,'true'))
          $line[] = 'true';
        elseif(!strcasecmp($value,'false'))
          $line[] = 'false';
        else
          $line[] = sprintf( "'%s'", $value );
      }
      return "[".implode(",",$line)."]";
    }else{// assoziative array
      foreach($conf as $key => $value){
        if(is_array($value))
          $line[] = sprintf( $prefix."  %s:%s", rtrim($key,'.'), self::array_js($value,$prefix.'  ') );
        elseif(is_numeric($value))
          $line[] = sprintf( $prefix."  %s:%s", $key, floatval($value) );
        elseif(!strcasecmp($value,'true'))
          $line[] = sprintf( $prefix."  %s:true", $key );
        elseif(!strcasecmp($value,'false'))
          $line[] = sprintf( $prefix."  %s:false", $key );
        else
          $line[] = sprintf( $prefix."  %s:'%s'", $key, $value );
      }
      return "{\n".implode(",\n",$line)."\n".$prefix."}";
    }
  }
  
  /**
   * maps pathinfo() to typoscript
   *
   * @param  string   $content: The PlugIn content
   * @param  array    $conf: The PlugIn configuration
   * @return          renderObj with fields: dirname, basename, extension, filename
   * 
   */
  function pathinfo($content,$conf){
    if($conf['file.']) $conf['file'] = $this->cObj->stdWrap($conf['file'],$conf['file.']);
    $cObj = t3lib_div::makeInstance('tslib_cObj');// create unique cObject
    $cObj->start(pathinfo($conf['file']));
    $content = $cObj->cObjGetSingle($conf['renderObj'],$conf['renderObj.']);// render content
    return $content;
  }
  
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mmlib/pi1/class.tx_mmlib_pi1.php'])  {
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mmlib/pi1/class.tx_mmlib_pi1.php']);
}

?>