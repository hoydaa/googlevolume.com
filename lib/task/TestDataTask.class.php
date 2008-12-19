<?php

class TestDataTask extends sfPropelBaseTask
{

    const RANDOM_PERCENTAGE    = 5;
    private $BASE_OBAMA  = 188000000;
    private $BASE_MCCAIN = 98000000;
    const DIFF_OBAMA           = 19000;
    const DIFF_MCCAIN          = 9000;

    const RANDOM_TEXT          = 'lorem ipsum le scala ';
    private static $TAGS = array('hede', 'hodo', 'pede', 'podo', 'dede', 'dodo', 'modo');

    protected function configure()
    {
        $this->namespace        = 'test';
        $this->name             = 'TestDataTask';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [TestDataTask1|INFO] task does things.
Call it with:

  [php symfony TestDataTask1|INFO]
EOF;
        $this->addArgument('application', sfCommandArgument::REQUIRED, 'The application name');
        // add other arguments here
        $this->addOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev');
        $this->addOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel');
        // add other options here
    }

    private function addReport($options)
    {
        $report = new Report();
        $report->setDescription(self::generateDescription());
        $report->setTitle(implode(', ', array_keys($options['queries'])));
        $report->save();

        foreach($options['queries'] as $key => $value)
        {
            $query = new Query();
            $query->setQuery($key);
            $query->save();

            $report_query = new ReportQuery();
            $report_query->setQuery($query);
            $report_query->setTitle($key);
            $report_query->setReport($report);
            $report_query->save();

            $date_start = strtotime($options['start_date']);
            $date_end = strtotime($options['end_date']);
             
            $start = $value['rand_start'];
            while($date_start < $date_end)
            {
                if(rand(0, 100) > $value['rand'])
                {
                    $query_result = new QueryResult();
                    $query_result->setQuery($query);
                    $start += rand($value['rand_min'], $value['rand_max']) * $value['rand_diff'];
                    $query_result->setResultSize($start);
                    $query_result->setCreatedAt(date('Y-m-d', $date_start));
                    $query_result->save();
                }
                $date_start = strtotime(date('Y-m-d', $date_start) . ' +1 days');
            }
        }

        $tags = self::generateTags();
        foreach($tags as $tag)
        {
            $tag->setReport($report);
            $tag->save();
        }
    }

    protected function execute($arguments = array(), $options = array())
    {
        // Database initialization
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = Propel::getConnection($options['connection'] ? $options['connection'] : '');

        $this->addReport(
        array(
        'queries' => array(
          'Obama' => array(
            'rand' => 5,
            'rand_start' => 1000000,
            'rand_diff' => 500,
            'rand_min' => -5,
            'rand_max' => 15
        ),
          'McCain' => array(
            'rand' => 10,
            'rand_start' => 2000000,
            'rand_diff' => 200,
            'rand_min' => -40,
            'rand_max' => 45
        )),
        'start_date' => '2007-01-01', 
        'end_date' => date('Y-m-d')
        )
        );

        $this->addReport(
        array(
        'queries' => array(
          'Struts 2' => array(
            'rand' => 5,
            'rand_start' => 10000,
            'rand_diff' => 50,
            'rand_min' => -5,
            'rand_max' => 10
        ),
          'Spring MVC' => array(
            'rand' => 10,
            'rand_start' => 8800,
            'rand_diff' => 50,
            'rand_min' => -5,
            'rand_max' => 8
        ),
          'MyFaces' => array(
            'rand' => 10,
            'rand_start' => 15000,
            'rand_diff' => 50,
            'rand_min' => 0,
            'rand_max' => 10
        ),
          'Tapestry' => array(
            'rand' => 10,
            'rand_start' => 7300,
            'rand_diff' => 50,
            'rand_min' => -5,
            'rand_max' => 12
        )),
        'start_date' => '2007-01-01', 
        'end_date' => date('Y-m-d')
        )
        );

        $this->addReport(
        array(
        'queries' => array(
          '"Utku Utkan"' => array(
            'rand' => 10,
            'rand_start' => 10000,
            'rand_diff' => 5,
            'rand_min' => -10,
            'rand_max' => 12
        ),
          '"Umut Utkan"' => array(
            'rand' => 10,
            'rand_start' => 10000,
            'rand_diff' => 5,
            'rand_min' => -10,
            'rand_max' => 12
        )),
        'start_date' => '2007-01-01', 
        'end_date' => date('Y-m-d')
        )
        );

        $this->addReport(
        array(
        'queries' => array(
          'Fusion' => array(
            'rand' => 10,
            'rand_start' => 10000,
            'rand_diff' => 5,
            'rand_min' => -10,
            'rand_max' => 12
        ),
          'Fision' => array(
            'rand' => 10,
            'rand_start' => 10000,
            'rand_diff' => 5,
            'rand_min' => -10,
            'rand_max' => 12
        )),
        'start_date' => '2007-01-01', 
        'end_date' => date('Y-m-d')
        )
        );

        $this->addReport(
        array(
        'queries' => array(
          'Bad' => array(
            'rand' => 10,
            'rand_start' => 10000,
            'rand_diff' => 5,
            'rand_min' => -10,
            'rand_max' => 12
        ),
          'Good' => array(
            'rand' => 10,
            'rand_start' => 10000,
            'rand_diff' => 5,
            'rand_min' => -10,
            'rand_max' => 12
        )),
        'start_date' => '2007-01-01', 
        'end_date' => date('Y-m-d')
        )
        );

        $this->addReport(
        array(
        'queries' => array(
          'Peace' => array(
            'rand' => 10,
            'rand_start' => 10000,
            'rand_diff' => 5,
            'rand_min' => -10,
            'rand_max' => 12
        ),
          'War' => array(
            'rand' => 10,
            'rand_start' => 10000,
            'rand_diff' => 5,
            'rand_min' => -10,
            'rand_max' => 12
        )),
        'start_date' => '2007-01-01', 
        'end_date' => date('Y-m-d')
        )
        );
    }

    private static function generateDescription()
    {
        $rtn = '';
        $count = rand(5, 10);
        for($i = 0; $i < $count; $i++)
        {
            $rtn .= self::RANDOM_TEXT;
        }
        return $rtn;
    }

    private static function generateTags()
    {
        $tags = array();
        $tag_count = rand(1, 5);
        $tag_start = rand(0, sizeof(self::$TAGS) - 1);
        for($i = 0; $i < $tag_count; $i++)
        {
            $tag = new ReportTag();
            $tag->setName(self::$TAGS[$tag_start]);
            $tags[] = $tag;
            $tag_start = $tag_start >= (sizeof(self::$TAGS) - 1) ? 0 : ($tag_start + 1);
        }
        return $tags;
    }
}