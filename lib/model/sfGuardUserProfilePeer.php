<?php

/**
 * Subclass for performing query and update operations on the 'sf_guard_user_profile' table.
 *
 * 
 *
 * @package lib.model
 */ 
class sfGuardUserProfilePeer extends BasesfGuardUserProfilePeer
{
  public static function retrieveByActivationKey($key)
  {
    $c = new Criteria();
    $c->add(sfGuardUserProfilePeer::ACTIVATION_KEY, $key);
    return sfGuardUserProfilePeer::doSelectOne($c);
  }
}
