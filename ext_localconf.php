<?php
if (!defined ('TYPO3_MODE'))   die ('Access denied.');
/* register plugins */
t3lib_extMgm::addPItoST43($_EXTKEY,'pi1/class.tx_mmlib_pi1.php','_pi1','list_type',0);
/* register hooks */
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('XML',    'EXT:mmlib/hooks/class.tx_mmlib_xml.php:tx_mmlib_xml'       );
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('REMOTE', 'EXT:mmlib/hooks/class.tx_mmlib_remote.php:tx_mmlib_remote' );
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('DATA',   'EXT:mmlib/hooks/class.tx_mmlib_data.php:tx_mmlib_data'     );
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['stdWrap'][] = 'EXT:mmlib/hooks/class.tx_mmlib_stdwrap.php:&tx_mmlib_stdwrap';
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] =  'EXT:mmlib/hooks/class.tx_mmlib_pagerenderer.php:tx_mmlib_pagerenderer->renderPreProcess';
//$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_gifbuilder.php']['gifbuilder-ConfPreProcess'][] =  'EXT:mmlib/hooks/class.tx_mmlib_gifbuilder.php:tx_mmlib_gifbuilder->confPreProcess';
?>