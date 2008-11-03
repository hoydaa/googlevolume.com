<?php

class userActions extends sfActions
{
  public function executeSignUp($request)
  {
    $this->form = new SignUpForm();

    if ($request->isMethod('get'))
    {
      return;
    }

    $this->form->bind($request->getParameter('signUp'));

    if (!$this->form->isValid())
    {
      return;
    }

    $username = $request->getParameter('signUp[username]');
    $password = $request->getParameter('signUp[password]');
    $email = $request->getParameter('signUp[email]');
    $first_name = $request->getParameter('signUp[first_name]');
    $last_name = $request->getParameter('signUp[last_name]');
    $gender = $request->getParameter('signUp[gender]');
    $birthday = $request->getParameter('signUp[birthday]');

    $user = new sfGuardUser();
    $user->setUsername($username);
    $user->setPassword($password);
    $user->setIsActive(false);

    $user->save();

    $profile = new sfGuardUserProfile();
    $profile->setSfGuardUser($user);
    $profile->setEmail($email);
    $profile->setFirstName($first_name);
    $profile->setLastName($last_name);
    $profile->setGender($gender ? $gender : null);

    $profile->save();

    $request->setAttribute('email', $profile->getEmail());
    $request->setAttribute('first_name', $profile->getFirstName());
    $request->setAttribute('activation_key', $profile->getActivationKey());

    //$raw_email = $this->sendEmail('mail', 'signUp');  
    //$this->logMessage($raw_email, 'debug');

    $this->getUser()->setFlash('info', 'A confirmation email has been sent to your email address.');
    $this->forward('site', 'message');
  }

  public function executeActivate($request)
  {
    $key = $request->getParameter('key');

    if ($key)
    {
      $user_profile = sfGuardUserProfilePeer::retrieveByActivationKey($key);

      if ($user_profile)
      {
        $user = sfGuardUserPeer::retrieveByPK($user_profile->getUserId());
        $user->setIsActive(true);
        $user->save();

        $this->getUser()->setFlash('info', 'Your account has been activated.');
        $this->forward('site', 'message');
      }
    }

    $this->getUser()->setFlash('error', 'Activation link is not valid.');
    $this->forward('site', 'message');
  }

  public function executeShowAccountSettings()
  {
    $profile = $this->getUser()->getProfile();

    $this->getRequest()->setParameter('first_name', $profile->getFirstName());
    $this->getRequest()->setParameter('last_name', $profile->getLastName());

    if ($profile->getGender() == 'M')
    {
      $this->getRequest()->setParameter('gender', $this->getContext()->getI18N()->__('Male'));
    }
    else if ($profile->getGender() == 'F')
    {
      $this->getRequest()->setParameter('gender', $this->getContext()->getI18N()->__('Female'));
    }

    $this->getRequest()->setParameter('birthday', $profile->getBirthday());
  }

  public function executeUpdateAccountSettings($request)
  {
    $this->form = new AccountSettingsForm();

    $profile = $this->getUser()->getProfile();

    if ($request->isMethod('get'))
    {
      $this->form->setDefaults(array(
        'first_name' => $profile->getFirstName(),
        'last_name' => $profile->getLastName(),
        'gender' => $profile->getGender()
      ));

      return;
    }

    $this->form->bind($request->getParameter('profile'));

    if (!$this->form->isValid())
    {
      return;
    }

    $profile->setFirstName($request->getParameter('profile[first_name]'));
    $profile->setLastName($request->getParameter('profile[last_name]'));
    $profile->setGender($request->getParameter('profile[gender]') ? $request->getParameter('profile[gender]') : null);

    $profile->save();

    $this->redirect('user/showAccountSettings');
  }

  public function executeChangeEmail($request)
  {
    $this->form = new ChangeEmailForm();

    if ($request->isMethod('get'))
    {
      return;
    }

    $this->form->bind($request->getParameter('form'));

    $password = $request->getParameter('form[password]');
    $email = $request->getParameter('form[email]');
  }

}
