<?php

class DateSelectorForm extends sfForm
{
    const LIMIT_DAY       = 30;

    const LIMIT_WEEK      = 30;

    const LIMIT_MONTH     = 30;

    protected static $frequencies = array(
    QueryResultPeer::FREQUENCY_DAY => 'Daily',
    QueryResultPeer::FREQUENCY_WEEK => 'Weekly',
    QueryResultPeer::FREQUENCY_MONTH => 'Monthly');

    public function configure()
    {
        $this->setWidgets(array(
      		'start_date'     => new sfWidgetFormDate(),
      		'end_date'       => new sfWidgetFormDate(),
      		'frequency'      => new sfWidgetFormSelect(array('choices' => self::$frequencies))));

        $this->setValidators(array(
      		'start_date'     => new sfValidatorDate(array('required' => false)),
      		'end_date'       => new sfValidatorDate(array('required' => false)),
      		'frequency'      => new sfValidatorChoice(array('required' => false, 'choices' => array_keys(self::$frequencies)))));

        $defaults = array();
        $defaults['frequency']  = QueryResultPeer::FREQUENCY_DAY;
        $defaults['start_date'] = date('Y-m-d', strtotime(date('Ymd') . ' -1 months'));
        $defaults['end_date']   = date('Y-m-d');
        $this->setDefaults($defaults);

        $this->bind($defaults);

        $this->widgetSchema->setNameFormat('date_selector[%s]');

        $this->validatorSchema->setPostValidator(
        new sfValidatorCallback(array('callback' => array($this, 'checkDates')))
        );
    }

    public function checkDates($validator, $values) {
        $start_date = strtotime($values['start_date']);
        $end_date   = strtotime($values['end_date']);
        if($values['frequency'] == QueryResultPeer::FREQUENCY_MONTH)
        {
            $months = (date('Y', $end_date) - date('Y', $start_date)) * 12 + date('m', $end_date) - date('m', $start_date);
            if($months > DateSelectorForm::LIMIT_MONTH)
            {
                $error = new sfValidatorError($validator, 'Too much data.');
                throw new sfValidatorErrorSchema($validator, array('start_date' => $error));
            }
        } else if($values['frequency'] == QueryResultPeer::FREQUENCY_WEEK)
        {
            $weeks = (date('y', $end_date) - date('y', $start_date)) * 52 + date('W', $end_date) - date('W', $start_date);
            if($weeks > DateSelectorForm::LIMIT_WEEK)
            {
                $error = new sfValidatorError($validator, 'Too much data.');
                throw new sfValidatorErrorSchema($validator, array('start_date' => $error));
            }
        } else
        {
            $days = ($end_date - $start_date) / 60 / 60 / 24;
            if($days > DateSelectorForm::LIMIT_DAY)
            {
                $error = new sfValidatorError($validator, 'Too much data.');
                throw new sfValidatorErrorSchema($validator, array('start_date' => $error));
            }
        }
        return $values;
    }
}
