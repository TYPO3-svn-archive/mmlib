<?php

class tx_mmlib_pagerenderer {
  
  /**
   * $params [array]
   * $pObj [t3lib_PageRenderer]
   */
  function renderPreProcess($params,$pObj){
    if($_REQUEST['mmlib']){
      print("<!--\n");
      
      print(passthru('/kunden/305566_22529/.gem/gems/sass-3.1.7/bin/sass --help'));
      
      print_r($params['cssFiles']);
      
      print("-->\n");
    }
  }
    
}

?>