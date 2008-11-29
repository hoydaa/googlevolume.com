<?php

class ReportForm extends ObjectForm
{

  public function configure()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'title'          => new sfWidgetFormInput(),
      'description'    => new sfWidgetFormTextarea(),
      'query_text_1'   => new sfWidgetFormInput(),
      'query_title_1'  => new sfWidgetFormInput(),
      'query_text_2'   => new sfWidgetFormInput(),
      'query_title_2'  => new sfWidgetFormInput(),
      'query_text_3'   => new sfWidgetFormInput(),
      'query_title_3'  => new sfWidgetFormInput(),
      'query_text_4'   => new sfWidgetFormInput(),
      'query_title_4'  => new sfWidgetFormInput(),
      'query_text_5'   => new sfWidgetFormInput(),
      'query_title_5'  => new sfWidgetFormInput(),
      'public'         => new sfWidgetFormInputCheckbox(),
      'tags'           => new sfWidgetFormInput(array(), array('autocomplete' => 'off')),
      'user_id'        => new sfWidgetFormInputHidden()
    ));
    
    $this->widgetSchema->setLabels(array(
      'title'          => 'Title',
      'description'    => 'Description',
      'query_text_1'   => 'Query Text 1',
      'query_title_1'  => 'Query Title 1',
      'query_text_2'   => 'Query Text 2',
      'query_title_2'  => 'Query Title 2',
      'query_text_3'   => 'Query Text 3',
      'query_title_3'  => 'Query Title 3',
      'query_text_4'   => 'Query Text 4',
      'query_title_4'  => 'Query Title 4',
      'query_text_5'   => 'Query Text 5',
      'query_title_5'  => 'Query Title 5',
      'public'         => 'Public',
      'tags'           => 'Tags',
      'user_id'        => 'User Id'
    ));
    
    $this->setValidators(array(
      'id'             => new sfValidatorString(array('required' => false)),
      'title'          => new sfValidatorString(array('required' => true), array('required' => 'Title is required.')),
      'description'    => new sfValidatorString(array('required' => false)),
      'query_text_1'   => new sfValidatorString(array('required' => true), array('required' => 'You have to enter at least one query.')),
      'query_title_1'  => new sfValidatorString(array('required' => false)),
      'query_text_2'   => new sfValidatorString(array('required' => false)),
      'query_title_2'  => new sfValidatorString(array('required' => false)),
      'query_text_3'   => new sfValidatorString(array('required' => false)),
      'query_title_3'  => new sfValidatorString(array('required' => false)),
      'query_text_4'   => new sfValidatorString(array('required' => false)),
      'query_title_4'  => new sfValidatorString(array('required' => false)),
      'query_text_5'   => new sfValidatorString(array('required' => false)),
      'query_title_5'  => new sfValidatorString(array('required' => false)),
      'public'         => new sfValidatorString(array('required' => false)),
      'tags'           => new sfValidatorString(array('required' => false)),
      'user_id'        => new sfValidatorString(array('required' => false))
    ));
    
    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'checkQueries')))
    );
    
    $this->widgetSchema->setNameFormat('report[%s]');
  }
  
  public function checkQueries($validator, $values) {
    for($i = 1; $i < 6; $i++)
    {
      if($values["query_text_$i"] && !$values["query_title_$i"])
      {
        $error = new sfValidatorError($validator, 'You have to enter a title for the query.');
        throw new sfValidatorErrorSchema($validator, array("query_title_$i" => $error));
        //throw new sfValidatorError($validator, 'Tepede cikacak.');
      }
    }
    return $values;
  }
  
  protected function updateDefaultsFromObject()
  {
    if(!$this->object)
    {
      return;
    }
   
    $defaults = array();
    
    $defaults['id']          = $this->object->getId();
    $defaults['title']       = $this->object->getTitle();
    $defaults['description'] = $this->object->getDescription();
    $defaults['tags']        = $this->object->getTag();
    $defaults['public']      = $this->object->getPublicRecord();
    
    $counter = 1;
    foreach($this->object->getReportQuerys() as $report_query)
    {
      $defaults["query_text_$counter"]  = $report_query->getQuery()->getQuery();
      $defaults["query_title_$counter"] = $report_query->getTitle(); 
      $counter++;
    }
    
    $this->setDefaults($defaults);
  }
  
  protected function updateObjectFromForm()
  {
    if($this->object->getId())
    {
      foreach($this->object->getReportQuerys() as $report_query)
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
  	if($this->getValue('public') == 'on')
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

	for($i = 1; $i < 6; $i++)
	{
      $query_text = $this->getValue("query_text_$i");
	  $query_title = $this->getValue("query_title_$i");
	  if($query_text)
	  {
	    $query = QueryPeer::retrieveByQUERY($query_text);
        if(!$query)
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
	if($this->getValue('user_id'))
	{
	    $this->object->setUserId($this->getValue('user_id'));
	}
  }
  
  public function getModelName()
  {
    return 'Report';  
  }

}