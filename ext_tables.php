<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

/* INFO MODULE */
if (TYPO3_MODE=='BE') {
  t3lib_extMgm::insertModuleFunction(
    'web_info',
    'tx_mmlib_modfunc1',
    t3lib_extMgm::extPath($_EXTKEY).'modfunc1/class.tx_mmlib_modfunc1.php',
    'LLL:EXT:mmlib/modfunc1/locallang.xml:title'
  );
}

/* STATICS */
t3lib_extMgm::addStaticFile($_EXTKEY,'static/','mmlib examples');// add static typoscript

/* PI1 */
t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages';// hide ?,?,startingpoint
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';// you add pi_flexform to be renderd when your plugin is shown
t3lib_extMgm::addPlugin(array('LLL:EXT:'.$_EXTKEY.'/pi1/locallang.xml:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');
t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/pi1/flexform.xml');// add flexform description file
if (TYPO3_MODE=="BE")  $TBE_MODULES_EXT["xMOD_db_new_content_el"]["addElClasses"]["tx_mmlib_pi1_wizicon"] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_mmlib_pi1_wizicon.php';
?>