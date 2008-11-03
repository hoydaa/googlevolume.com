<?php

class SignUpForm extends sfForm
{
  protected static $genders = array(null, 'M' => 'Male', 'F' => 'Female');

  public function configure()
  {
    $this->setWidgets(array(
      'username' => new sfWidgetFormInput(),
      'password' => new sfWidgetFormInputPassword(),
      'password_confirmation' => new sfWidgetFormInputPassword(),
      'email' => new sfWidgetFormInput(),
      'email_confirmation' => new sfWidgetFormInput(),
      'first_name' => new sfWidgetFormInput(),
      'last_name' => new sfWidgetFormInput(),
      'gender' => new sfWidgetFormSelect(array('choices' => self::$genders)),
      'birthday' => new sfWidgetFormDate()
    ));

    $this->widgetSchema->setNameFormat('signUp[%s]');

    $this->setValidators(array(
      'username' => new sfValidatorString(array('required' => true)),
      'password' => new sfValidatorString(array('required' => true)),
      'password_confirmation' => new sfValidatorString(array('required' => false)),
      'email' => new sfValidatorEmail(array('required' => true)),
      'email_confirmation' => new sfValidatorString(array('required' => false)),
      'first_name' => new sfValidatorString(array('required' => true)),
      'last_name' => new sfValidatorString(array('required' => true)),
      'gender' => new sfValidatorChoice(array('choices' => array_keys(self::$genders))),
      'birthday' => new sfValidatorDate(array('required' => false))
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_confirmation'),
      new sfValidatorSchemaCompare('email', sfValidatorSchemaCompare::EQUAL, 'email_confirmation')
    )));
  }
}