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
class user_setHeader{
  function main($content,$conf){
    $content = t3lib_div::view_array($conf);
    $content = $this->cObj->stdWrap($content,$conf['stdWrap.']);// enable total stdWrap
    return $content;
  }
  /** 
   *  
   *  set header location (redirect) and return synthax for meta-refresh
   *
   *  includeLibs.setHeader = EXT:mmlib/user_setHeader.php
   *  page.meta.refresh.postUserFunc = user_setHeader->location
   *  page.meta.refresh.typolink{
   *    parameter = http://www.google.de/
   *    returnLast = url
   *  }
   *  
   */
  function location($content,$conf){
    if(empty($content))return false;
    $http_response_code = 301;
    if(intval($conf['code'])) $http_response_code = intval($conf['code']);// set custom response code
    header('Referer: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    header('Location: '.$content,true,$http_response_code);
    if($conf['exit']) exit($http_response_code);
    return '0;URL='.$content;
  }
  /** 
   *  
   *  exit with pageNotFound (404)
   *
   *  includeLibs.setHeader = EXT:mmlib/user_setHeader.php
   *  page.10 = TEXT
   *  page.10.postUserFunc = user_setHeader->pageNotFound
   *  page.10.value = put message to display here...
   *  
   */
  function pageNotFound($content,$conf){
    if(empty($content))return false;
    $GLOBALS['TSFE']->pageNotFoundAndExit($content);
    return $content;
  }
}
?>