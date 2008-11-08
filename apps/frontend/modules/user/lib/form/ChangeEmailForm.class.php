<?php

class ChangeEmailForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'email' => new sfWidgetFormInput(),
      'email_again' => new sfWidgetFormInput()
    ));

    $this->widgetSchema->setNameFormat('form[%s]');

    $this->setValidators(array(
      'email' => new sfValidatorEmail(array('required' => true)),
      'email_again' => new sfValidatorString(array('required' => false))
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorSchemaCompare('email', sfValidatorSchemaCompare::EQUAL, 'email_again'),
      new sfValidatorPropelUnique(array('model' => 'sfGuardUserProfile', 'column' => 'email'))
    )));
  }
}