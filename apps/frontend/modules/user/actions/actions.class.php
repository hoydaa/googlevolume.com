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

        $this->form->bind($request->getParameter('form'));

        if (!$this->form->isValid())
        {
            return;
        }

        $sfGuardUser = new sfGuardUser();
        $sfGuardUser->setUsername($this->form->getValue('username'));
        $sfGuardUser->setPassword($this->form->getValue('password'));
        $sfGuardUser->setIsActive(false);

        $sfGuardUser->save();

        $sfGuardUserProfile = new sfGuardUserProfile();
        $sfGuardUserProfile->setSfGuardUser($sfGuardUser);
        $sfGuardUserProfile->setEmail($this->form->getValue('email'));
        $sfGuardUserProfile->setFirstName($this->form->getValue('first_name'));
        $sfGuardUserProfile->setLastName($this->form->getValue('last_name'));
        $sfGuardUserProfile->setGender($this->form->getValue('gender'));
        $sfGuardUserProfile->setBirthday($this->form->getValue('birthday'));
        $sfGuardUserProfile->setWebpage($this->form->getValue('webpage'));

        $sfGuardUserProfile->save();

        try
        {
            $connection = new Swift_Connection_SMTP('mail.sis-nav.com', 25);
            $connection->setUsername('umut.utkan@sistemas.com.tr');
            $connection->setPassword('gahve123');

            $mailer = new Swift($connection);

            $message = new Swift_Message('Account Confirmation');

            $mailContext = array(
        		'email' => $sfGuardUserProfile->getEmail(),
        		'full_name' => $sfGuardUserProfile->getFullName(),
        		'activation_key' => $sfGuardUserProfile->getActivationKey()
            );

            $message->attach(new Swift_Message_Part($this->getPartial('mail/signUpHtmlBody', $mailContext), 'text/html'));
            $message->attach(new Swift_Message_Part($this->getPartial('mail/signUpTextBody', $mailContext), 'text/plain'));

            $mailer->send($message, $sfGuardUserProfile->getEmail(), 'admin@project-y.com');
            $mailer->disconnect();
        }
        catch (Exception $e)
        {
            $mailer->disconnect();
        }

        $this->getUser()->setFlash('info', 'A confirmation email has been sent to your email address.');
        $this->forward('site', 'message');
    }

    public function executeConfirmation($request)
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
        $this->getRequest()->setParameter('webpage', $profile->getWebpage());
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
        'gender' => $profile->getGender(),
        'birthday' => $profile->getBirthday(),
        'webpage' => $profile->getWebpage()
            ));

            return;
        }

        $this->form->bind($request->getParameter('profile'));

        if (!$this->form->isValid())
        {
            return;
        }

        $profile->setFirstName($this->form->getValue('first_name'));
        $profile->setLastName($this->form->getValue('last_name'));
        $profile->setGender($this->form->getValue('gender'));
        $profile->setBirthday($this->form->getValue('birthday'));
        $profile->setWebpage($this->form->getValue('webpage'));

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

        if (!$this->form->isValid())
        {
            return;
        }

        $profile = $this->getUser()->getProfile();
        $profile->setEmail($this->form->getValue('email'));
        $profile->save();

        $this->getUser()->setFlash('error', 'Your email address has been changed.');
        $this->forward('site', 'message');
    }

    public function executeChangePassword($request)
    {
        $this->form = new ChangePasswordForm();

        if ($request->isMethod('get'))
        {
            return;
        }

        $this->form->bind($request->getParameter('form'));

        if (!$this->form->isValid())
        {
            return;
        }

        $this->getUser()->getGuardUser()->setPassword($this->form->getValue('new_password'));
        $this->getUser()->getGuardUser()->save();

        $this->getUser()->setFlash('error', 'Your password has been changed.');
        $this->forward('site', 'message');
    }

}
