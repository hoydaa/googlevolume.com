<?php

class AccountSettingsForm extends sfForm
{
  protected static $genders = array(null, 'M' => 'Male', 'F' => 'Female');

  public function configure()
  {
    $this->setWidgets(array(
      'first_name' => new sfWidgetFormInput(),
      'last_name' => new sfWidgetFormInput(),
      'gender' => new sfWidgetFormSelect(array('choices' => self::$genders)),
      'birthday' => new sfWidgetFormDate(array('years' => Utils::years_array()))
    ));

    $this->widgetSchema->setNameFormat('profile[%s]');

    $this->setValidators(array(
      'first_name' => new sfValidatorString(array('required' => true)),
      'last_name' => new sfValidatorString(array('required' => true)),
      'gender' => new sfValidatorChoice(array('choices' => array_keys(self::$genders))),
      'birthday' => new sfValidatorDate(array('required' => false))
    ));
  }
}