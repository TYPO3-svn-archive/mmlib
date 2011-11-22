<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2004-2005 Kasper Skaarhoj (kasperYYYY@typo3.com)
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
/**
 * Module extension (addition to function menu) 'Site mmlib' for the 'mmlib' extension.
 *
 * @author	Kasper Skaarhoj <kasperYYYY@typo3.com>
 */

require_once(PATH_t3lib.'class.t3lib_pagetree.php');
require_once(PATH_t3lib.'class.t3lib_extobjbase.php');

class tx_mmlib_modfunc1 extends t3lib_extobjbase {

	/**
	 * Holds the configuration from ext_conf_template loaded by loadExtensionSettings()
	 *
	 * @var array
	 */
	protected $extensionSettings = array();

	/**
	 * Load extension settings
	 *
	 * @param void
	 * @return void
	 */
	protected function loadExtensionSettings() {
		$this->extensionSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mmlib']);
	}

	/**
	 * Main function
	 *
	 * @return	string		HTML output
	 */
	function main()	{
		global $LANG, $BACK_PATH;
		$this->incLocalLang();
		$this->loadExtensionSettings();
		if (empty($this->pObj->MOD_SETTINGS['processListMode'])) {
			$this->pObj->MOD_SETTINGS['processListMode'] = 'simple';
		}
		$output  = $this->pObj->doc->spacer(5);
		$output .= $this->pObj->doc->section($LANG->getLL('title'), $this->sectionMain(), 0, 1);
		return $output;
	}

  function sectionMain(){
    return t3lib_div::view_array($this->query(
      $this->pObj->pageinfo['pid'],
      $this->pObj->pageinfo['uid']
    ));
  }

  function query($pid, $uid = 0){
    $select     = array('`uid`,`tx_templavoila_to`,`tx_templavoila_next_to`');
    $from       = array('`pages`');
    $where      = array('`pages`.`pid` = '.intval($pid));
    if($uid) $where[] = '`pages`.`uid` = '.intval($uid);
    $groupby    = array();
    $orderby    = array('`pages`.`sorting` ASC');
    $limit      = '';
    $index      = 'uid';
    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      implode(', ',$select),
      implode(', ',$from),
      implode(' AND ',$where),
      implode(', ',$groupby),
      implode(', ',$orderby),
      $limit,
      $index
    );
    $tmp = array();
    while( $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res) ) $tmp[] = $row;
    $GLOBALS['TYPO3_DB']->sql_free_result($res);
    return $tmp;
  }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mmlib/modfunc1/class.tx_mmlib_modfunc1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mmlib/modfunc1/class.tx_mmlib_modfunc1.php']);
}

?>
