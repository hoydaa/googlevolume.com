<?php

class reportActions extends sfActions
{

  public function executeIndex($request)
  {
    $this->forward('report', 'edit');
  }
  
  public function executeEdit($request)
  {
    $id = $request->getParameter('id');
    
    $report = null;
    if($id)
    {
      $report = ReportPeer::retrieveByPK($id);
      $this->forward404Unless($report);
    }
    
    $this->form = new ReportForm($report);
  }
  
  public function executeUpdate($request)
  {
  	$id = $request->getParameter('report[id]');
  	
  	if(!$id) {
      $report = new Report();
  	} else {
  	  $report = ReportPeer::retrieveByPK($id);
  	  
  	  $this->forward404Unless($report);
  	  
  	  $report = ReportPeer::retrieveByPK($id);
  	}
  	
  	$this->form = new ReportForm($report);
    $successful = $this->form->bindAndSave($request->getParameter('report'));
	if(!$successful) 
	{
      $this->setTemplate('edit');
	} else 
	{
	  return $this->redirect("report/show?id=$id"); 
	}
  }
  
  public function executeShow($request)
  {
    $this->form = new DateSelectorForm();
    $this->form->bind($request->getParameter('date_selector'));
  
    $id = $request->getParameter('id');
    
    $this->forward404Unless($id);
    
    $this->report = ReportPeer::retrieveByPK($id);
    
    $this->forward404Unless($this->report);
  }
  
  public function executeChart($request)
  {
    $this->form = new DateSelectorForm();
    $this->form->bind($request->getParameter('date_selector'));
  
    $this->getLogger()->log('UMUTUTKAN: ' . $this->form->getValue('start_date'));
  
    $id = $request->getParameter('id');
    
    $this->forward404Unless($id);
    
    $this->report = ReportPeer::retrieveByPK($id);
    
    $this->forward404Unless($this->report);
  }

}
