<?php

class sfValidatorPassword extends sfValidatorBase
{
  protected function configure($options = array(), $messages = array())
  {
    $this->addMessage('invalid', 'The password you entered is not valid.');
  }

  protected function doClean($value)
  {
    $clean = (string) $value;

    $user = sfContext::getInstance()->getUser()->getGuardUser();

    if (!$user->checkPassword($clean))
    {
      throw new sfValidatorError($this, 'invalid');
    }

    return $clean;
  }
}
