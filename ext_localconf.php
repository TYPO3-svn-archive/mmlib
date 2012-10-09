<?php
if (!defined ('TYPO3_MODE'))   die ('Access denied.');

/* register plugins */
t3lib_extMgm::addPItoST43($_EXTKEY,'pi1/class.tx_mmlib_pi1.php','_pi1','list_type',0);

/* register hooks */
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('XML',    'EXT:mmlib/hooks/class.tx_mmlib_xml.php:tx_mmlib_xml'       );
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('REMOTE', 'EXT:mmlib/hooks/class.tx_mmlib_remote.php:tx_mmlib_remote' );
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('DATA',   'EXT:mmlib/hooks/class.tx_mmlib_data.php:tx_mmlib_data'     );
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array('QUERY',  'EXT:mmlib/hooks/class.tx_mmlib_query.php:tx_mmlib_query'   );
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['stdWrap'][] = 'EXT:mmlib/hooks/class.tx_mmlib_stdwrap.php:&tx_mmlib_stdwrap';
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] =  'EXT:mmlib/hooks/class.tx_mmlib_pagerenderer.php:tx_mmlib_pagerenderer->renderPreProcess';
//$TYPO3_CONF_VARS['SC_OPTIONS']['ext/direct_mail']['res/scripts/class.dmailer.php']['mailMarkersHook'] = array('EXT:mmlib/hooks/class.tx_mmlib_directmail.php:tx_mmlib_directmail->mailMarkersHook');
// => try EXT:directmail_personalization

/* register CLI */
if(TYPO3_MODE=='BE'){
  $TYPO3_CONF_VARS['SC_OPTIONS']['GLOBAL']['cliKeys'][$_EXTKEY] = array('EXT:'.$_EXTKEY.'/cli/class.tx_mmlib_cli.php','_CLI_mmlib');
}

?>