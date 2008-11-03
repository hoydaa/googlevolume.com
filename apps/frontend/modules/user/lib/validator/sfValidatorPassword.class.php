<?php

class sfValidatorPassword extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->setMessage('invalid', 'The password is invalid.');
  }

  protected function doClean($value)
  {
    throw new sfValidatorError($this, 'invalid');
  }
}
