<?php

class tx_mmlib_mvc{

  /**
   * This class is just a collecting base container for all mvc-parts
   */
  function cObjGetSingleExt($name,$conf,$TSkey,$parent){
    $content = sprintf('%s = %s(%s)<br/>',$TSkey,$name,get_class($this));
    foreach($conf['model.'] as $sub_TSkey => $sub_conf){
      $content .= $parent->cObjGetSingle('MODEL',$sub_conf,$sub_TSkey,$this);
    }
    foreach($conf['view.'] as $sub_TSkey => $sub_conf){
      $content .= $parent->cObjGetSingle('VIEW',$sub_conf,$sub_TSkey,$this);
    }
    foreach($conf['controller.'] as $sub_TSkey => $sub_conf){
      $content .= $parent->cObjGetSingle('CONTROLLER',$sub_conf,$sub_TSkey,$this);
    }
    return $content;
  }
  
}

?>