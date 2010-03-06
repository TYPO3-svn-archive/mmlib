<?php

/**
 *  Load a resource from a remote system.
 *  Usage:
 *   10 = REMOTE
 *   10.url = http://armory.wow-europe.com/character-sheet.xml
 *   10.url.wrap = |?r=Blackhand&n=Jobe
 *   10.timeout = 5
 *   10.return = (content|header)
 *   10.stdWrap.wrap = <pre>|</pre>
 *   10.stdWrap.htmlSpecialChars = 1
 */

class tx_mmlib_remote{

  /* PUBLICS: */
  
  function cObjGetSingleExt($name,$conf,$TSkey,$parent){
  
    // apply stdWraps to properties
    if($conf['url.']) $conf['url'] = $parent->stdWrap($conf['url'],$conf['url.']);
    
    // check for required properties
    if(empty($conf['url']))return '';// url required!
    if(empty($conf['timeout']))$conf['timeout'] = 60;
    if(empty($conf['return']))$conf['return'] = 'content';
    
    // get data
    $query = $this->query($conf['url'],$conf['timeout']);
    
    // choose return value
    $content = $query[$conf['return']];
    
    // apply total stdWrap
    if ($conf['stdWrap.']) $content = $parent->stdWrap($content,$conf['stdWrap.']);
    
    return $content;
  }
  
  /* PRIVATES: */

  // try to load remote file
  private function query($url,$timeout=60){
    $options = array( 'http' => array(
      'user_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en; rv:1.9.1.8) Gecko/20100202 Firefox/3.5.8',
      'max_redirects' => 10,
      'timeout' => $timeout,
			'header' => array(
        'Accept-Language: en',
      ),
    ));
    $page = @file_get_contents($url,false,stream_context_create($options));
    //print('<pre>');print_r($http_response_header);print(htmlspecialchars($page));die('</pre>');/*DEBUG*/
    return array('content'=>$page,'header'=>implode("\n",$http_response_header));
  }

  // create a unique hash from url
  private function getHash($url){
    return $url;
  }
  
}

?>