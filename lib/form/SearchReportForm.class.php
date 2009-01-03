<?php

class SearchReportForm extends sfForm
{
    protected static $sources = array('A' => 'All Reports', 'U' => 'My Reports');

    public function configure()
    {
        $authenticated = sfContext::getInstance()->getUser()->isAuthenticated();

        $widgets = array();
        $validators = array();

        $widgets['query'] = new sfWidgetFormInput();
        $validators['query'] = new sfValidatorString(array('trim' => true));

        $widgets['page'] = new sfWidgetFormInputHidden();
        $validators['page'] = new sfValidatorString(array('required' => false));

        if ($authenticated)
        {
            $widgets['source'] = new sfWidgetFormSelectRadio(array('choices' => self::$sources));
            $validators['source'] = new sfValidatorChoice(array('required' => false, 'choices' => array_keys(self::$sources)));
        }

        $this->setWidgets($widgets);
        $this->setValidators($validators);

        $this->widgetSchema->setNameFormat('searchreport[%s]');
    }
}