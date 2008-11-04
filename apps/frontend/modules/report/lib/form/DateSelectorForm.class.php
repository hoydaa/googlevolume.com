<?php

class DateSelectorForm extends sfForm
{

  public function configure()
  {
    $this->setWidgets(array(
      'start_date'     => new sfWidgetFormDate(),
      'end_date'       => new sfWidgetFormDate()
    ));
  }

}