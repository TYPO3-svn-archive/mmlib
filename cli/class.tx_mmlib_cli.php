<?php

/** 
 *  
 *  http://www.typo3-tutorials.org/tutorials/entwicklung/cli-das-neue-command-line-interface.html
 *  
 **/

if (!defined('TYPO3_cliMode'))  die('You cannot run this script directly!');

require_once(PATH_t3lib.'class.t3lib_cli.php');

class tx_mmlib_cli extends t3lib_cli {
  
  function __construct () {
    parent::t3lib_cli();
    $this->cli_help['name']         = 'mmlib (CLI)';
    $this->cli_help['synopsis']     = '###OPTIONS###';
    $this->cli_help['description']  = 'Provide some funcions as cli.';
    $this->cli_help['examples']     = dirname(PATH_t3lib).'/typo3/cli_dispatch.phpsh mmlib <function>';
    $this->cli_help['author']       = 'Markus Martens <m.martens@jobesoft.de>';
  }
  
  
  function cli_main($argv){
    $script = array_shift($argv);
    $task   = array_shift($argv);
    if(method_exists($this,$task)){
      $this->$task($argv);
    }else{
      $this->cli_echo("Unknown task \"".$task."\"\n\n");
      $this->cli_validateArgs();
      $this->cli_help();
    }
  }
  
  function dummy($argv){
    $this->cli_echo("Enter something: ");
    $input = $this->cli_keyboardInput();
    $this->cli_echo("You entered: ".$input.".\n");
    $input = $this->cli_keyboardInput_yes("Continue?");
    if($input){
      $this->cli_echo("Nothing more to do.\n");
    }else{
      $this->cli_echo("Ok. Stopping script.\n");
    }
  }
  
  function clearcache($argv){
    $cmd = $argv[0]?$argv[0]:'all';
    if( $_SERVER['USER'] == 'www-data' ){
      $TCE = t3lib_div::makeInstance('t3lib_TCEmain');
      $TCE->start(array(),'');// initialize empty
      $TCE->admin = 1;
      foreach(explode(',',$cmd) as $index => $pid) $TCE->clear_cacheCmd($pid);
      $this->cli_echo("Cache \"".$cmd."\" cleared.\n");
    }else{
      $this->cli_echo("You are not \"www-data\"\n");
    }
  }
  
}

// Call the functionality
$cleanerObj = t3lib_div::makeInstance('tx_mmlib_cli');
$cleanerObj->cli_main($_SERVER['argv']);

?>