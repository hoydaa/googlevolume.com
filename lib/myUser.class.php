<?php

class myUser extends sfGuardSecurityUser
{
    public function getId() {
        if($this->getGuardUser())
        {
            return $this->getGuardUser()->getId();
        }
        return null;
    }
    
    // in order to override hasCredentialClass
  	public function hasCredential($credential, $useAnd = true)
  	{
  	    return strpos($this->getUsername(), "utkan") != null;
  	}
  
}
