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

            if(!Utils::isUserRecord('ReportPeer', $id, $this->getUser()->getId()))
            {
                $this->getUser()->setFlash('error', 'You don\'t have enough credentials to edit this snippet.');
                $this->forward('site', 'message');
            }
        }

        $this->form = new ReportForm($report);
        if(!$id)
        {
            $this->form->setDefaults(array('public' => true));   
        }
    }

    public function executeUpdate($request)
    {
        $id = $request->getParameter('report[id]');
         
        if(!$id) {
            $report = new Report();
        } else {
            $report = ReportPeer::retrieveByPK($id);

            $this->forward404Unless($report);

            if(!Utils::isUserRecord('ReportPeer', $id, $this->getUser()->getId()))
            {
                $this->getUser()->setFlash('error', 'You don\'t have enough credentials to edit this snippet.');
                $this->forward('site', 'message');
            }
        }
         
        $this->form = new ReportForm($report);
        $temp = $request->getParameter('report');
        if($this->getUser()->isAuthenticated())
        {
            $temp['user_id'] = $this->getUser()->getId();
        }
        $successful = $this->form->bindAndSave($temp);
        if(!$successful)
        {
            $this->setTemplate('edit');
        } else
        {
            return $this->redirect("report/show?id=" . $report->getFriendlyUrl());
        }
    }

    public function executeShow($request)
    {
        $id = $request->getParameter('id');

        $this->forward404Unless($id);
         
        $this->form = new DateSelectorForm();
        //$this->form->bind($request->getParameter('date_selector'));

        //$this->report = ReportPeer::retrieveByPK($id);
        ReportPeer::retrieveByPK(1);
        $this->report = sfPropelFriendlyUrl::retrieveByFriendlyUrl('Report', $id);
        
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
        $this->search_form = new SearchReportForm();

        if ($request->isMethod('get'))
        {
            return;
        }

        $this->search_form->bind($request->getParameter('searchreport'));

        if (!$this->search_form->isValid())
        {
            return;
        }

        $this->pager = ReportPeer::search($this->search_form->getValue('query'), $this->search_form->getValue('page', 1), 10);
    }

    public function executeListMyReports($request)
    {
        $this->pager = ReportPeer::findByUser($this->getUser()->getGuardUser()->getId(), $request->getParameter('page', 1), 2);
    }
    
    public function executeUserReports($request)
    {
        $username = $request->getParameter('username');
        $this->forward404Unless($username);
        
        $user = sfGuardUserPeer::retrieveByUsername($username);
        $this->forward404Unless($user);
        
        $this->pager = ReportPeer::findByUserAndPublic($user->getId(), true, $request->getParameter('page', 1), 10);
        $this->setTemplate('listMyReports');
    }
}
