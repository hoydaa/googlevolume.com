<?php

class ChangeEmailForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'password' => new sfWidgetFormInputPassword(),
      'email' => new sfWidgetFormInput(),
      'email_again' => new sfWidgetFormInput()
    ));

    $this->widgetSchema->setNameFormat('form[%s]');

    $this->setValidators(array(
      'password' => new sfValidatorPassword(),
      'email' => new sfValidatorEmail(array('required' => true)),
      'email_again' => new sfValidatorString(array('required' => false))
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorSchemaCompare('email', sfValidatorSchemaCompare::EQUAL, 'email_again')
    )));
  }
}