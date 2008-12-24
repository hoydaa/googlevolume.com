<?php

/**
 * Subclass for representing a row from the 'projecty_query' table.
 *
 * @package lib.model
 * @author Umut Utkan
 */
class Query extends BaseQuery
{

    // save method is overriden in order to get
    // the first query results if there is no.
    public function save($con = null)
    {
        // if the first save
        $going_to_save = (!$this->getId());

        parent::save($con);

        // if it is the first then connect to google
        // for the queries and get the results.
        if($going_to_save)
        {
            $query_result = new QueryResultBulk();
            $query_result->setQuery($this);

            $searchEngine = new GoogleRegexp();
            $count = $searchEngine->search($this->getQuery());

            $query_result->setResultSize($count);
            $query_result->save();
        }
    }

}
