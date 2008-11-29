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
        $this->pager = ReportPeer::findByUser($this->getUser()->getGuardUser()->getId(), $request->getParameter('page', 1), 10);
    }
}
