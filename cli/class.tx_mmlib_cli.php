<?php

if (!defined('TYPO3_cliMode'))  die('You cannot run this script directly!');

require_once(PATH_t3lib.'class.t3lib_cli.php');

class tx_mmlib_cli extends t3lib_cli {
  
  function __construct () {
    parent::t3lib_cli();
    $this->cli_help['name']         = '[name]';
    $this->cli_help['synopsis']     = '###OPTIONS###';
    $this->cli_help['description']  = '[description]';
    $this->cli_help['examples']     = '[examples]';
    $this->cli_help['author']       = '[author]';
  }
  
  
  function exitWithError($error = 'General Error') {
    $this->cli_echo("ERROR:\t" . $error . chr(10) . chr(10));
    $this->cli_validateArgs();
    $this->cli_help();
    exit;    
  }
  
  function cli_main($argv) {        
    $task = (string)$this->cli_args['_DEFAULT'][1];
    if($task == 'clearcache'){
      $this->clearcache();
    } else {
      $this->exitWithError('unknown task');
    }
  }
  
  function clearcache() {
    // your code here
    $this->cli_echo('done');
  }  
}

// Call the functionality
$cleanerObj = t3lib_div::makeInstance('tx_mmlib_cli');
$cleanerObj->cli_main($_SERVER['argv']);

?>