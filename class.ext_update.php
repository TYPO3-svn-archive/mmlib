<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2005-2008 René Fritz (r.fritz@colorcube.de)
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
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Class for updating the db
 *
 * $Id: class.ext_update.php 9462 2008-07-15 16:05:14Z franzholz $
 *
 * @author   René Fritz <r.fritz@colorcube.de>
 */
class ext_update  {
  /**
   * Main function, returning the HTML content of the module
   *
   * @return  string    HTML
   */
  function main()  {
    $content = '<p>'.__FILE__.'</p>';
    return $content;
  }
  /**
   * access is always allowed
   *
   * @return  boolean    Always returns true
   */
  function access() {
    return true;
  }
}
// Include extension?
if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mmlib/class.ext_update.php'])  {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mmlib/class.ext_update.php']);
}
?>