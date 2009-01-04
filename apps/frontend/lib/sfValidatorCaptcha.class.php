<?php

require_once ('recaptchalib.php');

class sfValidatorCaptcha
{ 
    public static function execute($validator, $values)
    {
        $response = recaptcha_check_answer (
            sfConfig::get('app_recaptcha_privatekey'),
            $_SERVER["REMOTE_ADDR"],
            $_POST['recaptcha_challenge_field'],
            $_POST['recaptcha_response_field']
        );

        if (!$response->is_valid)
        {
            $error = new sfValidatorError($validator, 'Incorrect. Try again.');
            throw new sfValidatorErrorSchema($validator, array('captcha' => $error));
        }

        return $values;
    }
}
