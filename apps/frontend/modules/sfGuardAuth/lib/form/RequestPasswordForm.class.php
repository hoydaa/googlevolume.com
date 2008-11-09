<?php

class RequestPasswordForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'email' => new sfWidgetFormInput()
    ));

    $this->widgetSchema->setNameFormat('form[%s]');

    $this->setValidators(array(
      'email' => new sfValidatorPropelChoice(array('required' => true, 'model' => 'sfGuardUserProfile', 'column' => 'email'))
    ));
  }
}