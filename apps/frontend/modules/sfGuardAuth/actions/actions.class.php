<?php

require_once(sfConfig::get('sf_plugins_dir').'/sfGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

class sfGuardAuthActions extends BasesfGuardAuthActions
{
  public function executePassword()
  {
    $this->form = new RequestPasswordForm();

    if ($this->getRequest()->isMethod('get'))
    {
      return;
    }

    $this->form->bind($this->getRequest()->getParameter('form'));

    if (!$this->form->isValid())
    {
      return;
    }

    $email = $this->form->getValue('email');
    $password = substr(md5(rand(100000, 999999)), 0, 6);

    $sfGuardUserProfile = sfGuardUserProfilePeer::retrieveByEmail($email);

    $sfGuardUser = $sfGuardUserProfile->getSfGuardUser();
    $sfGuardUser->setPassword($password);

    try
    {
      $connection = new Swift_Connection_SMTP('mail.sis-nav.com', 25);
      $connection->setUsername('umut.utkan@sistemas.com.tr');
      $connection->setPassword('gahve123');

      $mailer = new Swift($connection);

      $message = new Swift_Message('Request Password');

      $mailContext = array(
        'email' => $email,
        'password' => $password,
        'username' => $sfGuardUser->getUsername(),
        'full_name' => $sfGuardUserProfile->getFirstName()
      );

      $message->attach(new Swift_Message_Part($this->getPartial('mail/requestPasswordHtmlBody', $mailContext), 'text/html'));
      $message->attach(new Swift_Message_Part($this->getPartial('mail/requestPasswordTextBody', $mailContext), 'text/plain'));

      $mailer->send($message, $email, 'admin@project-y.com');
      $mailer->disconnect();
    }
    catch (Exception $e)
    {
      $mailer->disconnect();
    }

    $sfGuardUser->save();

    $this->getUser()->setFlash('info', 'A new password is sent to your email.');
    $this->forward('site', 'message');
  }
}
