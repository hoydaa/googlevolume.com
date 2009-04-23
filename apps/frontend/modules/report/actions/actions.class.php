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

            if(!$this->getUser()->hasCredential('admin') && !Utils::isUserRecord('ReportPeer', $id, $this->getUser()->getId()))
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

            if(!$this->getUser()->hasCredential('admin') && !Utils::isUserRecord('ReportPeer', $id, $this->getUser()->getId()))
            {
                $this->getUser()->setFlash('error', 'You don\'t have enough credentials to edit this snippet.');
                $this->forward('site', 'message');
            }
        }
    
        $this->form = new NewReportForm($report);
        $temp = $request->getParameter('report');
        if(!$report->getUserId() && $this->getUser()->isAuthenticated())
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

        ReportPeer::retrieveByPK(1);
        $this->report = sfPropelFriendlyUrl::retrieveByFriendlyUrl('Report', $id);

        if(!$this->report->getPublicRecord() && !Utils::isUserRecord('ReportPeer', $this->report->getId(), $this->getUser()->getId()))
        {
            $this->getUser()->setFlash('error', 'You don\'t have enough credentials to edit this snippet.');
            $this->forward('site', 'message');
        }

        $this->forward404Unless($this->report);

        $this->report->incrementCounter();
        $this->report->save();
    }

    public function executeDelete($request)
    {
        $id = $request->getParameter('id');

        $this->forward404Unless($id);

        if(!$this->getUser()->hasCredential('admin') && !Utils::isUserRecord('ReportPeer', $id, $this->getUser()->getId()))
        {
            $this->getUser()->setFlash('error', 'You don\'t have enough credentials to delete this snippet.');
            $this->forward('site', 'message');
        }

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

        if ($this->getUser()->isAuthenticated())
        {
            $this->pager = ReportPeer::search($this->search_form->getValue('query'), $this->getUser()->getGuardUser()->getId(), $this->search_form->getValue('source'), $this->search_form->getValue('page', 1), 10);
        }
        else
        {
            $this->pager = ReportPeer::search($this->search_form->getValue('query'), null, null, $this->search_form->getValue('page', 1), 10);
        }
    }

    public function executeListMyReports($request)
    {
        $this->pager = ReportPeer::findByUser($this->getUser()->getGuardUser()->getId(), $request->getParameter('page', 1), 10);
    }

    public function executeListMyPublicReports($request)
    {
        $this->pager = ReportPeer::findByUserAndPublic($this->getUser()->getGuardUser()->getId(), true, $request->getParameter('page', 1), 10);
    }

    public function executeListMyPrivateReports($request)
    {
        $this->pager = ReportPeer::findByUserAndPublic($this->getUser()->getGuardUser()->getId(), false, $request->getParameter('page', 1), 10);
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

    public function executeShowByDate($request)
    {
        $order = $this->getRequestParameter('order');
        if(!$order)
        {
            $order = 'desc';
        }

        $this->pager = ReportPeer::findNewReports($request->getParameter('page', 1), 10, $order);
        $this->setTemplate('list');
    }

    public function executeShowByPopularity($request)
    {
        $order = $this->getRequestParameter('order');
        if(!$order)
        {
            $order = 'desc';
        }

        $this->pager = ReportPeer::findByPopularity($request->getParameter('page', 1), 10, $order);
        $this->setTemplate('list');
    }

    public function executeShowByStability($request)
    {
        $order = $this->getRequestParameter('order');
        if(!$order)
        {
            $order = 'asc';
        }

        $this->pager = ReportPeer::findByStability($request->getParameter('page', 1), 10, $order);
        $this->setTemplate('list');
    }

    public function executeShowByAmount($request)
    {
        $order = $this->getRequestParameter('order');
        if(!$order)
        {
            $order = 'desc';
        }

        $this->pager = ReportPeer::findByAmount($request->getParameter('page', 1), 10, $order);
        $this->setTemplate('list');
    }

    public function executeShowImage($request)
    {
        $id = $request->getParameter('id');

        ReportPeer::retrieveByPK(1);
        $report = sfPropelFriendlyUrl::retrieveByFriendlyUrl('Report', $id);

        $this->forward404Unless($report->getPublicRecord());

        $decorator = new PermanentChartDecorator();
        $chart = ReportPeer::getReportChartt($report, $decorator);

        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->setContentType('image/png');
        $response->setContent(file_get_contents(sfConfig::get('app_web_images') . '/' . $chart->__toString()));
        $response->send();
    }

    public function executeFeed($request)
    {
        $feed_versions = array('Atom1', 'Rss091', 'Rss10', 'Rss201');
        $type = $request->getParameter('type');
        if(!$type || !in_array($type, $feed_versions))
        {
            $type = 'Atom1';
        }
        $class = 'sf'.$type.'Feed';
        
        $feed = new $class();
        if(!$request->getParameter('username'))
        {
            $pager = ReportPeer::findNewReports(1, 10, 'desc');
            $reports = $pager->getResults();

            $feed->setTitle('Google Volume - New Reports');
            $feed->setLink('http://www.googlevolume.com');
            $feed->setAuthorEmail('info@googlevolume.com');
            $feed->setAuthorName('Info');            
            
            //$feedImage = new sfFeedImage();
            //$feedImage->setFavicon('http://www.googlevolume.com/favicon.ico');
            //$feed->setImage($feedImage);

            self::addToFeed($feed, $reports);
        } else
        {
            $username = $request->getParameter('username');

            $sfGuardUser = myUser::retrieveByUsername($username);

            $profile = $sfGuardUser->getsfGuardUserProfiles();
            $profile = $profile[0];

            $feed->setTitle('Google Volume - '. $profile->getFirstName() . ' ' . $profile->getLastname() .'\'s New Reports');
            $feed->setLink('http://www.googlevolume.com');
            $feed->setAuthorEmail('info@googlevolume.com');
            $feed->setAuthorName('Info');

            $c = new Criteria();
            $c->add(ReportPeer::USER_ID, $sfGuardUser->getId());
            $c->add(ReportPeer::PUBLIC_RECORD, true);
            $c->addDescendingOrderByColumn(ReportPeer::CREATED_AT);
            $c->setLimit(10);

            self::addToFeed($feed, ReportPeer::doSelect($c));
        }

        $this->feed = $feed;
    }

    private static function addToFeed($feed, $reports)
    {
        foreach ($reports as $report)
        {
            $item = new sfFeedItem();
            $item->setTitle($report->getTitle());
            $item->setLink('report/show?id='.$report->getFriendlyUrl());
            if($report->getsfGuardUser())
            {
                $item->setAuthorName($report->getsfGuardUser()->getProfile()->getFirstname() . ' ' . $report->getsfGuardUser()->getProfile()->getLastname());
                $item->setAuthorEmail($report->getsfGuardUser()->getProfile()->getEmail());
            }
            $item->setPubdate($report->getCreatedAt('U'));
            $item->setUniqueId($report->getFriendlyUrl());

            $titles = array();
            foreach($report->getReportQuerys() as $report_query)
            {
                $titles[] = $report_query->getTitle();
            }
            //print_r($titles);
            $item->setDescription(($report->getDescription() ? $report->getDescription() . " " : "") . 'Queries: ' . implode(', ', $titles));

            $feed->addItem($item);
        }
    }

    public static function download($request)
    {
        $frequency = $request->getParameter('frequency');
        $start_date = $request->getParameter('start_date');
        $end_date = $request->getParameter('end_date');
    }

}
