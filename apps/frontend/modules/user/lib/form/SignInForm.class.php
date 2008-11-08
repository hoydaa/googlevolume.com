<?php

class SignUpForm extends sfForm
{
  protected static $genders = array(null, 'M' => 'Male', 'F' => 'Female');

  public function configure()
  {
    $this->setWidgets(array(
      'username' => new sfWidgetFormInput(),
      'password' => new sfWidgetFormInputPassword(),
      'remember' => new sfWidgetFormInputCheckbox()
    ));

    $this->widgetSchema->setNameFormat('signIn[%s]');

    $this->setValidators(array(
      'username' => new sfValidatorString(array('required' => true)),
      'password' => new sfValidatorString(array('required' => true))
    ));
  }
}