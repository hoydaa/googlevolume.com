<?php

class clearChartCacheTask extends sfBaseTask
{
    /**
     * One day of duration.
     */
    const TIME_TO_LIVE = 86400;

    protected function configure()
    {
        $this->namespace        = '';
        $this->name             = 'clearChartCache';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [clearChartCache|INFO] task clears chart cache.
Call it with:

  [php symfony clearChartCache|INFO]
EOF;
        // add arguments here, like the following:
        $this->addArgument('application', sfCommandArgument::REQUIRED, 'The application name');
        // add options here, like the following:
        //$this->addOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev');
    }

    protected function execute($arguments = array(), $options = array())
    {
        $now = time();
        $chart_cache_dir = sfConfig::get('app_web_images_charts');
        $count = 0;
        foreach(new DirectoryIterator($chart_cache_dir) as $file => $info)
        {
            if(!$info->isDot())
            {
                if($now - $info->getCTime() > self::TIME_TO_LIVE)
                {
                    if(file_exists($info->getPathname()))
                    {
                        unlink($info->getPathname());
                        $count++;
                    }
                }
            }
        }
        echo "$count chart files are deleted.\n";
    }
}