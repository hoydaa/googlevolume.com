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

        $this->form = new NewReportForm($report);
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
         
        $this->form = new NewReportForm($report);
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
            $cacheManager = $this->getContext()->getViewCacheManager();
            $cacheManager->remove('@sf_cache_partial?module=report&action=_miniChart&sf_cache_key='.$report->getId());
            
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
        
        $this->report->incrementCounter();
        $this->report->save();
    }

    public function executeDelete($request)
    {
        $id = $request->getParameter('id');

        $this->forward404Unless($id);
        
        if(!Utils::isUserRecord('ReportPeer', $id, $this->getUser()->getId()))
        {
            $this->getUser()->setFlash('error', 'You don\'t have enough credentials to delete this snippet.');
            $this->forward('site', 'message');
        }
        
        $this->form = new DateSelectorForm();

        $this->report = ReportPeer::retrieveByPK($id);
        
        $this->forward404Unless($this->report);
        
        if($request->getParameter('delete') == 'Yes')
        {
            ReportPeer::doDelete(array($id));
            $this->getUser()->setFlash('info', sprintf('Report %s is deleted.', $this->report->getTitle()));
            $this->forward('site', 'message');
        }
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
        $this->pager = ReportPeer::findByUser($this->getUser()->getGuardUser()->getId(), $request->getParameter('page', 1), 10);
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
