<?php

/**
 * Subclass for representing a row from the 'projecty_report_query' table.
 *
 *
 *
 * @package lib.model
 */
class ReportQuery extends BaseReportQuery
{

    // set title same as the query if it is not set
    public function save($con = null)
    {
        if(!$this->getTitle()) {
            if($this->getQuery()) {
                $this->setTitle($this->getQuery()->getQuery());
            }
        }

        parent::save($con);
    }

}
