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
    $searchEngine = new Google();
    $databaseManager = new sfDatabaseManager($this->configuration);

    $date = date("Y-m-d");
    $queries = QueryPeer::findUnprocessedQueries($date);

    foreach ($queries as $query)
    {
      $qr = new QueryResult();
      $qr->setQuery($query);
      $qr->setFetchDate($date);
      $qr->setResultSize($searchEngine->search($query->getQuery()));

      // $qr->save();
      echo $searchEngine->search($query->getQuery()) . "\n";
    }
  }
}