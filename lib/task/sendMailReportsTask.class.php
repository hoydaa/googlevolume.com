<?php

//include('include.php');

class sendMailReportsTask extends sfBaseTask
{
    protected function configure()
    {
        $this->namespace        = '';
        $this->name             = 'sendMailReports';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [sendMailReports|INFO] task does things.
Call it with:

  [php symfony sendMailReports|INFO]
EOF;
        // add arguments here, like the following:
        $this->addArgument('application', sfCommandArgument::REQUIRED, 'The application name');
        $this->addArgument('frequency', sfCommandArgument::REQUIRED, 'Frequency of the mails.[D|W|M]');
    }

    protected function execute($arguments = array(), $options = array())
    {
        $frequencies = array('D' => 'Daily', 'W' => 'Weekly', 'M' => 'Monthly');
        $frequency = $arguments['frequency'];
        if(!array_key_exists($frequency, $frequencies))
        {
            logline(sprintf('Invalid frequency %s use [D|W|M]', $frequency));
            exit;
        }

        sfLoader::loadHelpers('Partial', 'My');
        $context = sfContext::createInstance($this->configuration);

        $stop_watch = new StopWatch();
        $stop_watch->start();
        logline(sprintf('Started processing %s mails.', $frequencies[$frequency]));

        $databaseManager = new sfDatabaseManager($this->configuration);

        $c1 = new Criteria();
        $c1->addJoin(sfGuardUserPeer::ID, ReportPeer::USER_ID);
        $c1->add(ReportPeer::MAIL_FREQUENCY, $frequency);
        $c1->setDistinct();
        $users = sfGuardUserPeer::doSelect($c1);

        foreach($users as $user)
        {
            $c = new Criteria();
            $c->add(ReportPeer::USER_ID, $user->getId());
            $c->add(ReportPeer::MAIL_FREQUENCY, $frequency);
            $reports = ReportPeer::doSelect($c);

            logline(sprintf("There are %s reports to process.", sizeof($reports)));

            $sfGuardUserProfile = $user->getsfGuardUserProfiles();
            $sfGuardUserProfile = $sfGuardUserProfile[0];

            $connection = new Swift_Connection_SMTP('mail.sis-nav.com', 25);
            $connection->setUsername('umut.utkan@sistemas.com.tr');
            $connection->setPassword('gahve123');

            $mailer = new Swift($connection);

            $message = new Swift_Message(sprintf("Goole Volume - %s notifications.", $frequencies[$frequency]));

            $images = array();
            foreach ($reports as $report)
            {
                $rtn = ReportPeer::_getReportChart(
                $report, date('Y-m-d', strtotime(date('Ymd') . ' -1 months')),
                date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')),
                QueryResultPeer::FREQUENCY_DAY, new MailChartDecorator());
                $data = $rtn['values'];
                $line_chart = $rtn['chart'];
                $image_path = $local_url = sfConfig::get('app_web_images') . '/' . $line_chart->__toString();

                $images[$report->getTitle()] = new Swift_Message_Image(new Swift_File($image_path));

                $imageReferences = array();
                foreach ($images as $name => $image)
                {
                    $imageReferences[$name] = $message->attach($image);
                }

                $mailContext = array(
        			'data' => $data,
                    'full_name' => $sfGuardUserProfile->getFullName(),
                    'report' => $report,
                    'images' => $imageReferences
                );
            }

            try
            {
                $message->attach(new Swift_Message_Part(get_partial('mail/mailReportHtmlBody', $mailContext), 'text/html'));
                $message->attach(new Swift_Message_Part(get_partial('mail/mailReportTextBody', $mailContext), 'text/plain'));

                $mailer->send($message, $sfGuardUserProfile->getEmail(), 'info@googlevolume.com');
                $mailer->disconnect();
            }
            catch (Exception $e)
            {
                logline(sprintf('Exception while sending email to %s about %s. %s', $sfGuardUserProfile->getEmail(), $report->getTitle(), $e));
                $mailer->disconnect();
            }

            logline(sprintf('Sent mail to %s.', $sfGuardUserProfile->getEmail()));

        }

        logline(sprintf("Finished processing."));
        $stop_watch->end();
        logline(sprintf('Execution time: %s seconds.', $stop_watch->getTime()));
        logline(sprintf('!!!!!CAN RUN %s TIMES A DAY!!!!!', (24 * 60 * 60 / ($stop_watch->getTime() == 0 ? 1 : $stop_watch->getTime()))));
    }
}