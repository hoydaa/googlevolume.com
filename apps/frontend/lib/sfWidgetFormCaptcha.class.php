<?php

require_once ('recaptchalib.php');

class sfWidgetFormCaptcha extends sfWidgetForm
{
    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        return recaptcha_get_html(sfConfig::get('app_recaptcha_publickey'));
    }
}
