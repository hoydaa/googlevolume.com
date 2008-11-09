<?php

class sfGuardUserPeer extends PluginsfGuardUserPeer
{
  public static function retrieveByEmail($key)
  {
    $c = new Criteria();
    $c->add(sfGuardUserProfilePeer::ACTIVATION_KEY, $key);

    return sfGuardUserProfilePeer::doSelectOne($c);
  }
}
