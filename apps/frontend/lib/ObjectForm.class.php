<?php

abstract class ObjectForm extends sfForm
{
  protected
    $isNew    = true,
    $cultures = array(),
    $object   = null;

  /**
   * Constructor.
   *
   * @param BaseObject $object      A Propel object used to initialize default values
   * @param array      $options     An array of options
   * @param string     $CSRFSecret  A CSRF secret (false to disable CSRF protection, null to use the global CSRF secret)
   *
   * @see sfForm
   */
  public function __construct(BaseObject $object = null, $options = array(), $CSRFSecret = null)
  {
    $class = $this->getModelName();
    if (is_null($object))
    {
      $this->object = new $class();
    }
    else
    {
      if (!$object instanceof $class)
      {
        throw new sfException(sprintf('The "%s" form only accepts a "%s" object.', get_class($this), $class));
      }

      $this->object = $object;
      $this->isNew = false;
    }

    parent::__construct(array(), $options, $CSRFSecret);

    $this->updateDefaultsFromObject();
  }

  /**
   * Returns the default connection for the current model.
   *
   * @return Connection A database connection
   */
  public function getConnection()
  {
    return Propel::getConnection(constant(sprintf('%s::DATABASE_NAME', get_class($this->object->getPeer()))));
  }

  /**
   * Returns the current model name.
   */
  abstract public function getModelName();

  /**
   * Returns true if the current form embeds a new object.
   *
   * @return Boolean true if the current form embeds a new object, false otherwise
   */
  public function isNew()
  {
    return $this->isNew;
  }

  /**
   * Returns the current object for this form.
   *
   * @return BaseObject The current object.
   */
  public function getObject()
  {
    return $this->object;
  }

  /**
   * Binds the current form and save the to the database in one step.
   *
   * @param  array      $taintedValues    An array of tainted values to use to bind the form
   * @param  array      $taintedFiles     An array of uploaded files (in the $_FILES or $_GET format)
   * @param  Connection $con              An optional Propel Connection object
   *
   * @return Boolean    true if the form is valid, false otherwise
   */
  public function bindAndSave($taintedValues, $taintedFiles = null, $con = null)
  {
    $this->bind($taintedValues, $taintedFiles);
    if ($this->isValid())
    {
      $this->save($con);

      return true;
    }

    return false;
  }

  /**
   * Saves the current object to the database.
   *
   * The object saving is done in a transaction and handled by the doSave() method.
   *
   * If the form is not valid, it throws an sfValidatorError.
   *
   * @param Connection $con An optional Connection object
   *
   * @return BaseObject The current saved object
   *
   * @see doSave()
   */
  public function save($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    try
    {
      $con->begin();

      $this->doSave($con);

      $con->commit();
    }
    catch (Exception $e)
    {
      $con->rollback();

      throw $e;
    }

    return $this->object;
  }

  /**
   * Updates the values of the object with the cleaned up values.
   *
   * @return BaseObject The current updated object
   */
  public function updateObject()
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

	$this->updateObjectFromForm();

    return $this->object;
  }

  /**
   * Updates and saves the current object.
   *
   * If you want to add some logic before saving or save other associated objects,
   * this is the method to override.
   *
   * @param Connection $con An optional Connection object
   */
  protected function doSave($con = null)
  {
    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $this->updateObject();

    $this->object->save($con);
  }

  /**
   * Updates the default values of the form with the current values of the current object.
   */
  abstract protected function updateDefaultsFromObject();
  
  abstract protected function updateObjectFromForm();
}
