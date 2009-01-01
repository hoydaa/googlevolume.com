<?php

class userComponents extends sfComponents
{
    public function executeUser()
    {
        $user_id = $this->getUser()->getGuardUser()->getId();

        $this->count = ReportPeer::countUserReports($user_id);
    }
}