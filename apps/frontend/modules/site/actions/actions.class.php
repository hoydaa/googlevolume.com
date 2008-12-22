<?php

/**
 * site actions.
 *
 * @package    project-y
 * @subpackage site
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class siteActions extends sfActions
{
    public function executeIndex($request)
    {
        $this->pager = ReportPeer::findByPopularity($request->getParameter('page', 1), 10);
    }

    public function executeMessage()
    {
    }
}
