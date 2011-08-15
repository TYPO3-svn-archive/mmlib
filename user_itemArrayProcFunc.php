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
 * also see: typo3/sysext/cms/tslib/media/scripts/example_itemArrayProcFunc.php
 */

/**
 * reverse menu elements
 *
 * @param	array		The $menuArr array which simply is a num-array of page records which goes into the menu.
 * @param	array		TypoScript configuration for the function. Notice that the property "parentObj" is a reference to the parent (calling) object (the tslib_Xmenu class instantiated)
 * @return	array		The modified $menuArr array
 */
function user_itemArrayProcFuncReverse($menuArr,$conf){
  return array_reverse($menuArr);
}

/**
 * shuffle menu elements
 *
 * @param	array		The $menuArr array which simply is a num-array of page records which goes into the menu.
 * @param	array		TypoScript configuration for the function. Notice that the property "parentObj" is a reference to the parent (calling) object (the tslib_Xmenu class instantiated)
 * @return	array		The modified $menuArr array
 */
function user_itemArrayProcFuncShuffle($menuArr,$conf){
  shuffle($menuArr);
  return $menuArr;
}

?>