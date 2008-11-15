<?php

class reportActions extends sfActions
{

  public function executeIndex($request)
  {
    $this->forward('report', 'edit');
  }
  
  public function executeEdit($request)
  {
    if($this->getUser()->isAuthenticated())
    {
      echo "armut";
    }
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
	  return $this->redirect("report/show?id=" . $report->getId()); 
	}
  }
  
  public function executeShow($request)
  {
    $id = $request->getParameter('id');
    
    $this->forward404Unless($id);
   
    $this->form = new DateSelectorForm();
    //$this->form->bind($request->getParameter('date_selector'));
    
    $this->report = ReportPeer::retrieveByPK($id);
    
    $this->forward404Unless($this->report);
  }
  
  public function executeChart($request)
  {
    $this->form = new DateSelectorForm();
    $this->form->bind($request->getParameter('date_selector'));
  
    $id = $request->getParameter('id');
    
    $this->forward404Unless($id);
    
    $this->report = ReportPeer::retrieveByPK($id);
    
    $this->forward404Unless($this->report);
  }

  public function executeSearch($request)
  {
    $this->form = new SearchReportForm();

    if ($request->isMethod('get'))
    {
      return;
    }

    $this->form->bind($request->getParameter('searchreport'));

    if (!$this->form->isValid())
    {
      return;
    }

    $this->pager = ReportPeer::search($this->form->getValue('query'), $this->form->getValue('page'), 1);
  }

  public function executeListMyReports($request)
  {
    $this->pager = ReportPeer::findByUser($this->getUser()->getGuardUser()->getId(), $request->getParameter('page', 1), 1);
  }
}
