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
    }

    protected function execute($arguments = array(), $options = array())
    {
        $stop_watch = new StopWatch();
        $stop_watch->start();
        logline('Started processing.');
        
        $searchEngine = new GoogleHitFetcher();
        $databaseManager = new sfDatabaseManager($this->configuration);
        $queries = QueryPeer::doSelect(new Criteria());

        logline(sprintf("There are %s queries to process.", sizeof($queries)));
        foreach ($queries as $query)
        {
                        
            $qr = new QueryResultBulk();
            $qr->setQuery($query);
            $result_size = $searchEngine->fetch($query->getQuery());
            $qr->setResultSize($result_size);

            logline(sprintf("Found %s results for %s.", $result_size, $query->getQuery()));
            
            $qr->save();
        }
        
        logline(sprintf("Finished processing."));
        $stop_watch->end();
        logline(sprintf('Execution time: %s seconds.', $stop_watch->getTime()));
        logline(sprintf('!!!!!CAN RUN %s TIMES A DAY!!!!!', (24 * 60 * 60 / $stop_watch->getTime())));
    }
}