<?php

class reportActions extends sfActions
{

  public function executeIndex($request)
  {
    $this->forward('report', 'create');
  }
  
  public function executeCreate($request)
  {
    $this->setTemplate('edit');
  }

}
