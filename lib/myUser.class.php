<?php

class myUser extends sfGuardSecurityUser
{
    public function getId() {
        return $this->getGuardUser()->getId();
    }
    
    // in order to override hasCredentialClass
  	public function hasCredential($credential, $useAnd = true)
  	{
  	    return strpos($this->getUsername(), "utkan") != null;
  	}
  
}
