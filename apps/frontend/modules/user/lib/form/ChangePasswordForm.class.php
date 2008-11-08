<?php

class ChangePasswordForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'password' => new sfWidgetFormInputPassword(),
      'password_again' => new sfWidgetFormInputPassword()
    ));

    $this->widgetSchema->setNameFormat('form[%s]');

    $this->setValidators(array(
      'password' => new sfValidatorString(array('required' => true)),
      'password_again' => new sfValidatorString(array('required' => true))
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again')
    )));
  }
}