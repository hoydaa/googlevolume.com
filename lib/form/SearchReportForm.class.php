<?php

class SearchReportForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'query' => new sfWidgetFormInput(),
      'page' => new sfWidgetFormInputHidden()
    ));

    $this->widgetSchema->setNameFormat('searchreport[%s]');

    $this->setValidators(array(
      'query' => new sfValidatorString(array('trim' => true)),
      'page' => new sfValidatorString(array('required' => false))
    ));
  }
}