<?php

class NewReportForm extends ObjectForm
{
    protected static $frequencies = array('N' => 'Never', 'D' => 'Daily', 'W' => 'Weekly', 'M' => 'Monthly');

    public function configure()
    {
        $is_hidden = !(sfContext::getInstance()->getUser()->isAuthenticated());

        $widgets = array();
        $widgets['id']           = new sfWidgetFormInputHidden();
        $widgets['title']        = new sfWidgetFormInput();
        $widgets['description']  = new sfWidgetFormTextarea();
        $widgets['query_text_1']  = new sfWidgetFormInput();
        $widgets['query_label_1']  = new sfWidgetFormInput();
        $widgets['query_text_2']  = new sfWidgetFormInput();
        $widgets['query_label_2']  = new sfWidgetFormInput();
        $widgets['query_text_3']  = new sfWidgetFormInput();
        $widgets['query_label_3']  = new sfWidgetFormInput();
        $widgets['query_text_4']  = new sfWidgetFormInput();
        $widgets['query_label_4']  = new sfWidgetFormInput();
        $widgets['query_text_5']  = new sfWidgetFormInput();
        $widgets['query_label_5']  = new sfWidgetFormInput();
        $widgets['query_text_6']  = new sfWidgetFormInput();
        $widgets['query_label_6']  = new sfWidgetFormInput();
        $widgets['query_text_7']  = new sfWidgetFormInput();
        $widgets['query_label_7']  = new sfWidgetFormInput();
        $widgets['query_text_8']  = new sfWidgetFormInput();
        $widgets['query_label_8']  = new sfWidgetFormInput();
        $widgets['query_text_9']  = new sfWidgetFormInput();
        $widgets['query_label_9']  = new sfWidgetFormInput();
        $widgets['query_text_10']  = new sfWidgetFormInput();
        $widgets['query_label_10']  = new sfWidgetFormInput();
        $widgets['query_texts']  = new sfWidgetFormTextarea();
        $widgets['query_titles'] = new sfWidgetFormTextarea();

        if (!$is_hidden)
        {
            $widgets['private']   = new sfWidgetFormInputCheckbox();
        }

        $widgets['tags']         = new sfWidgetFormInput(array(), array('autocomplete' => 'off'));

        if (!$is_hidden) 
        {
            $widgets['frequency']= new sfWidgetFormSelect(array('choices' => self::$frequencies));
        }

        $widgets['user_id']      = new sfWidgetFormInputHidden();

        $this->setWidgets($widgets);

        $this->widgetSchema->setLabels(array(
            'title'          => 'Title *',
            'description'    => 'Description',
            'query_texts'    => 'Query Texts *',
            'query_titles'   => 'Query Titles *',
            'private'        => 'Private',
            'frequency'      => 'Send By Mail',
            'tags'           => 'Tags',
            'user_id'        => 'User Id'
        ));

        $this->widgetSchema->setHelps(array(
            'query_texts'    => 'Seperate the queries you want to be searched with newlines.',
            'query_titles'   => 'Seperate the titles of your queries with newlines.',
            'tags'           => 'You can seperate your tags with comma.',
            'frequency'      => 'If you want you can schedule a mail for your report, just select a frequency.'
        ));

        $this->setValidators(array(
            'id'             => new sfValidatorString(array('required' => false)),
            'title'          => new sfValidatorString(array('required' => true), array('required' => 'Title is required.')),
            'description'    => new sfValidatorString(array('required' => false)),
            'query_text_1'   => new sfValidatorString(array('required' => true), array('required' => 'Query text is required.')),
            'query_label_1'  => new sfValidatorString(array('required' => true), array('required' => 'Query label is required.')),
            'query_text_2'   => new sfValidatorString(array('required' => false)),
            'query_label_2'  => new sfValidatorString(array('required' => false)),
            'query_text_3'   => new sfValidatorString(array('required' => false)),
            'query_label_3'  => new sfValidatorString(array('required' => false)),
            'query_text_4'   => new sfValidatorString(array('required' => false)),
            'query_label_4'  => new sfValidatorString(array('required' => false)),
            'query_text_5'   => new sfValidatorString(array('required' => false)),
            'query_label_5'  => new sfValidatorString(array('required' => false)),
            'query_text_6'   => new sfValidatorString(array('required' => false)),
            'query_label_6'  => new sfValidatorString(array('required' => false)),
            'query_text_7'   => new sfValidatorString(array('required' => false)),
            'query_label_7'  => new sfValidatorString(array('required' => false)),
            'query_text_8'   => new sfValidatorString(array('required' => false)),
            'query_label_8'  => new sfValidatorString(array('required' => false)),
            'query_text_9'   => new sfValidatorString(array('required' => false)),
            'query_label_9'  => new sfValidatorString(array('required' => false)),
            'query_text_10'  => new sfValidatorString(array('required' => false)),
            'query_label_10' => new sfValidatorString(array('required' => false)),
            'query_texts'    => new sfValidatorString(array('required' => true), array('required' => 'You have to enter at least one query.')),
            'query_titles'   => new sfValidatorString(array('required' => true), array('required' => 'You have to enter at least one query.')),
            'frequency'      => new sfValidatorString(array('required' => false)),
            'private'        => new sfValidatorString(array('required' => false)),
            'tags'           => new sfValidatorString(array('required' => false)),
            'user_id'        => new sfValidatorString(array('required' => false))
        ));

        $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
            new sfValidatorCallback(
                array(
                    'callback' => array($this, 'checkQuery'),
                    'arguments' => array('i' => 2)
                )
            ),
            new sfValidatorCallback(
                array(
                    'callback' => array($this, 'checkQuery'),
                    'arguments' => array('i' => 3)
                )
            ),
            new sfValidatorCallback(
                array(
                    'callback' => array($this, 'checkQuery'),
                    'arguments' => array('i' => 4)
                )
            ),
            new sfValidatorCallback(
                array(
                    'callback' => array($this, 'checkQuery'),
                    'arguments' => array('i' => 5)
                )
            ),
            new sfValidatorCallback(
                array(
                    'callback' => array($this, 'checkQuery'),
                    'arguments' => array('i' => 6)
                )
            ),
            new sfValidatorCallback(
                array(
                    'callback' => array($this, 'checkQuery'),
                    'arguments' => array('i' => 7)
                )
            ),
            new sfValidatorCallback(
                array(
                    'callback' => array($this, 'checkQuery'),
                    'arguments' => array('i' => 8)
                )
            ),
            new sfValidatorCallback(
                array(
                    'callback' => array($this, 'checkQuery'),
                    'arguments' => array('i' => 9)
                )
            ),
            new sfValidatorCallback(
                array(
                    'callback' => array($this, 'checkQuery'),
                    'arguments' => array('i' => 10)
                )
            )
        )));

        $this->widgetSchema->setNameFormat('report[%s]');
    }

    public function checkQuery($validator, $values, $arguments)
    {
        $i = $arguments['i'];

        if (!isset($values['query_text_' . $i]))
        {
            return $values;
        }

        if ($values['query_text_' . $i] == null && $values['query_label_' . $i] != null)
        {
            $error = new sfValidatorError($validator, 'Query text is required.');
            throw new sfValidatorErrorSchema($validator, array('query_text_' . $i => $error));
        }
        else if ($values['query_text_' . $i] != null && $values['query_label_' . $i] == null)
        {
            $error = new sfValidatorError($validator, 'Query label is required.');
            throw new sfValidatorErrorSchema($validator, array('query_label_' . $i => $error));
        }

        return $values;
    }

    protected function updateDefaultsFromObject()
    {
        if (!$this->object)
        {
            return;
        }

        $defaults = array();
        $defaults['id']          = $this->object->getId();
        $defaults['title']       = $this->object->getTitle();
        $defaults['description'] = $this->object->getDescription();
        $defaults['tags']        = $this->object->getTag();
        $defaults['private']     = !$this->object->getPublicRecord();
        $defaults['frequency']   = $this->object->getMailFrequency() ? $this->object->getMailFrequency() : 'N';

        $query_texts = array();
        $query_titles = array();

        foreach ($this->object->getReportQuerys() as $report_query)
        {
            $query_texts[] = $report_query->getQuery()->getQuery();
            $query_titles[] = $report_query->getTitle();
        }

        $defaults['query_texts'] = implode("\n", $query_texts);
        $defaults['query_titles'] = implode("\n", $query_titles);

        $this->setDefaults($defaults);
    }

    protected function updateObjectFromForm()
    {
        if ($this->object->getId())
        {
            foreach ($this->object->getReportQuerys() as $report_query)
            {
                $report_query->delete();
            }

            foreach ($this->object->getReportTags() as $tag)
            {
                $tag->delete();
            }
        }

        $this->object->setTitle($this->getValue('title'));
        $this->object->setDescription($this->getValue('description'));
        $this->object->setMailFrequency($this->getValue('frequency')); 

        if ($this->getValue('private') == 'on')
        {
            $this->object->setPublicRecord(false);
        }
        else
        {
            $this->object->setPublicRecord(true);
        }

        $tag_names = explode(',', $this->getValue('tags'));

        foreach ($tag_names as $tag_name)
        {
            if (!($tag_name = strtolower(trim($tag_name))))
            {
                continue;
            }

            $tag = new ReportTag();
            $tag->setName($tag_name);

            $this->object->addReportTag($tag);
        }

        $query_texts = explode("\n", str_replace("\r", "", $this->getValue('query_texts')));
        $query_titles = explode("\n", str_replace("\r", "", $this->getValue('query_titles')));

        for ($i = 0; $i < sizeof($query_texts); $i++)
        {
            $query_text = $query_texts[$i];
            $query_title = $query_titles[$i];

            if ($query_text)
            {
                $query = QueryPeer::retrieveByQUERY($query_text);

                if (!$query)
                {
                    $query = new Query();
                    $query->setQuery($query_text);
                }

                $report_query = new ReportQuery();
                $report_query->setQuery($query);
                $report_query->setTitle($query_title);

                $this->object->addReportQuery($report_query);
            }
        }

        if ($this->getValue('user_id'))
        {
            $this->object->setUserId($this->getValue('user_id'));
        }
    }

    public function getModelName()
    {
        return 'Report';
    }
}