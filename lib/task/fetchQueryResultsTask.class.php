<?php

include('include.php');

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
        $stop_watch = new StopWatch();
        $stop_watch->start();
        logline('Started processing.');
        
        $searchEngine = new GoogleRegexp();
        $databaseManager = new sfDatabaseManager($this->configuration);
        $queries = QueryPeer::doSelect(new Criteria());

        logline(sprintf("There are %s queries to process.", sizeof($queries)));
        foreach ($queries as $query)
        {
            $today = date('Y-m-d');
            
            $c = new Criteria();
            $c->add(QueryResultPeer::QUERY_ID, $query->getId());
            $c->add(QueryResultPeer::CREATED_AT, $today, Criteria::GREATER_THAN);
            if(QueryResultPeer::doCount($c) > 0)
            {
                logline(sprintf("Query '%s' has already a result for date %s.", $query->getQuery(), $today));
                continue;
            }
                        
            $qr = new QueryResult();
            $qr->setQuery($query);
            $result_size = $searchEngine->search($query->getQuery());
            $qr->setResultSize($result_size);

            logline(sprintf("Found %s results for %s.", $result_size, $query->getQuery()));
            
            $qr->save();
        }
        
        logline(sprintf("Finished processing."));
        $stop_watch->end();
        logline(sprintf('Execution time: %s seconds.', $stop_watch->getTime()));
    }
}