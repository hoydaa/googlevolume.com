<?php

/**
 * Subclass for representing a row from the 'projecty_query' table.
 *
 *
 *
 * @package lib.model
 */
class Query extends BaseQuery
{
    
    // save method is overriden in order to get 
    // the first query results if there is no.
    public function save($con = null)
    {
        $going_to_save = (!$this->getId());
        
        parent::save($con);
        
        if($going_to_save)
        {
            $query_result = new QueryResult();
            $query_result->setQuery($this);
            
            $searchEngine = new Google();
            $count = $searchEngine->search($this->getQuery());
            
            $query_result->setResultSize($count);
            $query_result->save();
        }
    }

}
