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
  	
  	public function getProfile()
  	{
        if($this->getGuardUser())
        {
            $sfGuardUserProfile = $this->getGuardUser()->getsfGuardUserProfile();
            $sfGuardUserProfile = $sfGuardUserProfile[0];
            return $sfGuardUserProfile;
        }
        return null;
  	}
  	
  	public function getFullname() 
  	{
  	    $profile = $this->getProfile();
  	    if($profile == null)
  	    {
  	        return null;
  	    }
  	    return $profile->getFirstname() . ' ' . $profile->getLastname();
  	}
  
}
