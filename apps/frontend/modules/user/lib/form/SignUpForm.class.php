<?php

class SignUpForm extends sfForm
{
  protected static $genders = array(null, 'M' => 'Male', 'F' => 'Female');

  public function configure()
  {
    $this->setWidgets(array(
      'username' => new sfWidgetFormInput(),
      'password' => new sfWidgetFormInputPassword(),
      'password_again' => new sfWidgetFormInputPassword(),
      'email' => new sfWidgetFormInput(),
      'email_again' => new sfWidgetFormInput(),
      'first_name' => new sfWidgetFormInput(),
      'last_name' => new sfWidgetFormInput(),
      'gender' => new sfWidgetFormSelect(array('choices' => self::$genders)),
      'birthday' => new sfWidgetFormDate(array('years' => Utils::years_array())),
      'captcha' => new sfWidgetFormCaptcha()
    ));

    $this->widgetSchema->setNameFormat('form[%s]');

    $this->setValidators(array(
      'username' => new sfValidatorString(array('required' => true)),
      'password' => new sfValidatorString(array('required' => true)),
      'password_again' => new sfValidatorString(array('required' => false)),
      'email' => new sfValidatorEmail(array('required' => true)),
      'email_again' => new sfValidatorString(array('required' => false)),
      'first_name' => new sfValidatorString(array('required' => true)),
      'last_name' => new sfValidatorString(array('required' => true)),
      'gender' => new sfValidatorChoice(array('choices' => array_keys(self::$genders))),
      'birthday' => new sfValidatorDate(array('required' => false))
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorPropelUnique(array('model' => 'sfGuardUser', 'column' => 'username')),
      new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again'),
      new sfValidatorSchemaCompare('email', sfValidatorSchemaCompare::EQUAL, 'email_again'),
      new sfValidatorPropelUnique(array('model' => 'sfGuardUserProfile', 'column' => 'email')),
      new sfValidatorCallback(array('callback' => array('sfValidatorCaptcha', 'execute')))
    )));
  }
}