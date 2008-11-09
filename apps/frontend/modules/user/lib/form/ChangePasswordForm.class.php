<?php

class ChangePasswordForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'password' => new sfWidgetFormInputPassword(),
      'new_password' => new sfWidgetFormInputPassword(),
      'new_password_again' => new sfWidgetFormInputPassword()
    ));

    $this->widgetSchema->setNameFormat('form[%s]');

    $this->setValidators(array(
      'password' => new sfValidatorPassword(array('required' => true)),
      'new_password' => new sfValidatorString(array('required' => true)),
      'new_password_again' => new sfValidatorString(array('required' => true))
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorSchemaCompare('new_password', sfValidatorSchemaCompare::EQUAL, 'new_password_again')
    )));
  }
}