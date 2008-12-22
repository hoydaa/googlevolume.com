<?php

class fetchQueryResultsTask extends sfBaseTask
{
    protected function configure()
    {
        $this->namespace        = '';
        $this->name             = 'fetchQueryResults';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [fetchQueryResults|INFO] task does things.
Call it with:

  [php symfony fetchQueryResults|INFO]
EOF;
        // add arguments here, like the following:
        $this->addArgument('application', sfCommandArgument::REQUIRED, 'The application name');
        // add options here, like the following:
        //$this->addOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev');
    }

    protected function execute($arguments = array(), $options = array())
    {
        $searchEngine = new GoogleRegexp();
        $databaseManager = new sfDatabaseManager($this->configuration);
        $queries = QueryPeer::doSelect(new Criteria());

        echo sprintf("There are %s queries to process.\n", sizeof($queries));
        foreach ($queries as $query)
        {
            $today = date('Y-m-d');
            
            $c = new Criteria();
            $c->add(QueryResultPeer::QUERY_ID, $query->getId());
            $c->add(QueryResultPeer::CREATED_AT, $today, Criteria::GREATER_THAN);
            if(QueryResultPeer::doCount($c) > 0)
            {
                echo sprintf("Query '%s' has already a result for date %s.\n", $query->getQuery(), $today);
                continue;
            }
                        
            $qr = new QueryResult();
            $qr->setQuery($query);
            $result_size = $searchEngine->search($query->getQuery());
            $qr->setResultSize($result_size);

            echo sprintf("Found %s results for %s.\n", $result_size, $query->getQuery());
            
            $qr->save();
        }
        echo sprintf("Finished processing.");
    }
}