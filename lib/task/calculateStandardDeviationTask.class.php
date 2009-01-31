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
            $connection = Propel::getConnection();
            
            $sql = "SELECT STD(%s) as standard_deviation FROM %s where %s=%s";
            $sql = sprintf($sql, QueryResultPeer::RESULT_SIZE, QueryResultPeer::TABLE_NAME, QueryResultPeer::QUERY_ID, $query->getId());
            
            $statement = $connection->prepareStatement($sql);
            $resultset = $statement->executeQuery();

            $resultset->next();
            $std = $resultset->getString('standard_deviation');
            
            $sql = "SELECT MEAN(%s) as mean_of_all FROM %s where %s=%s";
            $sql = sprintf($sql, QueryResultPeer::RESULT_SIZE, QueryResultPeer::TABLE_NAME, QueryResultPeer::QUERY_ID, $query->getId());            
            
            $statement = $connection->prepareStatement($sql);
            $resultset = $statement->executeQuery();

            $resultset->next();
            $mean = $resultset->getString('mean_of_all');
            
            $query->setStandardDeviation($std/$mean);
            
            logline(sprintf('Average stdev for query %s is %s.', $query->getQuery(), $query->getStandardDeviation()));
            
            $query->save();
            
            //logLine(sprintf("Standart deviation for %s is %s.", $query->getQuery(), $deviation));
        }
        
        logline(sprintf("Finished processing."));
        $stop_watch->end();
        logline(sprintf('Execution time: %s seconds.', $stop_watch->getTime()));
        logline(sprintf('!!!!!CAN RUN %s TIMES A DAY!!!!!', (24 * 60 * 60 / ($stop_watch->getTime() == 0 ? 1 : $stop_watch->getTime()))));
    }
}