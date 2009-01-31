<?php

//include('include.php');

class calculateStandardDeviationTask extends sfBaseTask
{
    protected function configure()
    {
        $this->namespace        = '';
        $this->name             = 'calculateStandardDeviation';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [calculateStandardDeviation|INFO] task does things.
Call it with:

  [php symfony calculateStandardDeviation|INFO]
EOF;
        // add arguments here, like the following:
        $this->addArgument('application', sfCommandArgument::REQUIRED, 'The application name');
    }

    protected function execute($arguments = array(), $options = array())
    {
        $stop_watch = new StopWatch();
        $stop_watch->start();
        logline('Started processing.');
        
        $databaseManager = new sfDatabaseManager($this->configuration);
        $queries = QueryPeer::doSelect(new Criteria());

        logline(sprintf("There are %s queries to process.", sizeof($queries)));
        foreach ($queries as $query)
        {
            $deviation = 0.0;
            
            $sql = "SELECT STD(%s) as result_size_mean FROM %s where %s=%s";
            $sql = sprintf($sql, QueryResultPeer::RESULT_SIZE, QueryResultPeer::TABLE_NAME, QueryResultPeer::QUERY_ID, $query->getId());
            
            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($sql);
            $resultset = $statement->executeQuery();

            $resultset->next();
            $mean = $resultset->getString('result_size_mean');
            
            $query->setStandardDeviation($mean);
            
            logline(sprintf('Average stdev for query %s is %s.', $query->getQuery(), ($deviation/$mean)));
            
            $query->save();
            
            //logLine(sprintf("Standart deviation for %s is %s.", $query->getQuery(), $deviation));
        }
        
        logline(sprintf("Finished processing."));
        $stop_watch->end();
        logline(sprintf('Execution time: %s seconds.', $stop_watch->getTime()));
        logline(sprintf('!!!!!CAN RUN %s TIMES A DAY!!!!!', (24 * 60 * 60 / ($stop_watch->getTime() == 0 ? 1 : $stop_watch->getTime()))));
    }
}