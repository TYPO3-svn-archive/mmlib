<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

/* register cObj hook */
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('XML','EXT:mmlib/hooks/class.tx_mmlib_xml.php:tx_mmlib_xml');
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('REMOTE','EXT:mmlib/hooks/class.tx_mmlib_remote.php:tx_mmlib_remote');
/* experimentals */
//$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('MVC','EXT:mmlib/hooks/class.tx_mmlib_mvc.php:tx_mmlib_mvc');
//$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('MODEL','EXT:mmlib/hooks/class.tx_mmlib_model.php:tx_mmlib_model');
//$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('VIEW','EXT:mmlib/hooks/class.tx_mmlib_view.php:tx_mmlib_view');
//$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('CONTROLLER','EXT:mmlib/hooks/class.tx_mmlib_controller.php:tx_mmlib_controller');

?>