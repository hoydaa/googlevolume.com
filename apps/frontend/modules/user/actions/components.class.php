<?php

class userComponents extends sfComponents
{
    public function executeUser()
    {
        $user_id = $this->getUser()->getGuardUser()->getId();

        $this->all = ReportPeer::countUserReports($user_id);
        $this->public = ReportPeer::countPublicUserReports($user_id);
        $this->private = $this->all - $this->public;
    }
}