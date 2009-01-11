<?php

/**
 * tag actions.
 *
 * @package    project-y
 * @subpackage tag
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class queryActions extends sfActions
{
    public function executeList()
    {
        $this->queries = QueryPeer::getPopularTags(100);
    }

    public function executeShow($request)
    {
        $this->pager = ReportPeer::findByQuery($request->getParameter('query'), $request->getParameter('page', 1), 10);
    }


}
