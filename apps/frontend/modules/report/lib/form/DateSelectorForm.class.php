<?php

class DateSelectorForm extends sfForm
{

  public function configure()
  {
    $this->setWidgets(array(
      'start_date'     => new sfWidgetFormDate(),
      'end_date'       => new sfWidgetFormDate(),
      'frequency'      => new sfWidgetFormInputHidden()
    ));
    
    $this->setValidators(array(
      'start_date'     => new sfValidatorString(array('required' => false)),
      'end_date'       => new sfValidatorString(array('required' => false)),
      'frequency'      => new sfValidatorString(array('required' => false))
    ));
    
    $this->widgetSchema->setNameFormat('date_selector[%s]');
  }

}