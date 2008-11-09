<?php

/**
 * Subclass for representing a row from the 'sf_guard_user_profile' table.
 *
 * 
 *
 * @package lib.model
 */ 
class sfGuardUserProfile extends BasesfGuardUserProfile
{
  public function save($conn = null)
  {
    if($this->isNew())
    {
      $this->setActivationKey(md5(rand(100000, 999999) . $this->getEmail()));
    }

    parent::save($conn);
  }

  public function getFullName()
  {
    return $this->getFirstName() . ' ' . $this->getLastName();
  }
}
