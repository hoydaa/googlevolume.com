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
            $sfGuardUserProfile = $this->getGuardUser()->getsfGuardUserProfiles();
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
     
    public static function retrieveByUsername($username)
    {
        $c = new Criteria();
        $c->add(sfGuardUserPeer::USERNAME, $username);
         
        return sfGuardUserPeer::doSelectOne($c);
    }
     
    public static function toHCard($sfGuardUser)
    {
        $sfGuardUserProfile = $sfGuardUser->getsfGuardUserProfiles();
        $sfGuardUserProfile = $sfGuardUserProfile[0];
         
        $rtn = '<span class="vcard">';
        if($sfGuardUserProfile->getWebpage())
        {
            $rtn .= '<a class="fn url" href="'.$sfGuardUserProfile->getWebpage().'">'. $sfGuardUserProfile->getFirstName() . ' ' . $sfGuardUserProfile->getLastName() .'</a>';
        } else
        {
            $rtn .= '<span class="fn">'. $sfGuardUserProfile->getFirstName() . ' ' . $sfGuardUserProfile->getLastName() .'</span>';
        }
		$rtn .= '
		<a class="email" href="mailto:'.$sfGuardUserProfile->getEmail().'">'.$sfGuardUserProfile->getEmail().'</a>';
		$rtn .= '</span>';
		return $rtn;
    }

}
