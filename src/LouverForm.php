<?php
declare(strict_types=1);

namespace Plaisio\Form;

use Plaisio\Form\Control\LouverFieldSet;
use Plaisio\Form\Control\SlatControlFactory;
use SetBased\Exception\LogicException;

/**
 * Form with a LouverFieldSet fieldset.
 */
class LouverForm extends Form
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The maximum size of a text control. The maximum text length can be larger.
   *
   * @var int
   */
  public static int $maxTextSize = 80;

  /**
   * The name of the louver form control.
   *
   * @var string
   */
  protected string $bodyName = 'data';

  /**
   * The data set.
   *
   * @var array[]|null
   */
  protected ?array $data = null;

  /**
   * The slat control factory.
   *
   * @var SlatControlFactory|null
   */
  protected ?SlatControlFactory $factory = null;

  /**
   * The fieldset with visible form control.
   *
   * @var LouverFieldSet
   */
  protected LouverFieldSet $louverFieldSet;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|null $name The name of the form.
   */
  public function __construct(?string $name = '')
  {
    parent::__construct($name);

    $this->louverFieldSet = new LouverFieldSet();
    $this->addFieldSet($this->louverFieldSet)
         ->setModuleClass('input-table');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Adds a submit button to this form.
   *
   * @param int|string  $wrdId  Depending on the type:
   *                            <ul>
   *                            <li>int:    The ID of the word of the button text.
   *                            <li>string: The text of the button.
   *                            </ul>
   * @param string      $method The name of method for handling the form submit.
   * @param string      $name   The name of the submit button.
   * @param string|null $class  The class(es) of the submit button.
   *
   * @return self
   */
  public function addSubmitButton($wrdId,
                                  string $method,
                                  string $name = 'submit',
                                  ?string $class = 'btn btn-success'): self
  {
    $control = $this->louverFieldSet->addSubmitButton($wrdId, $name);
    $control->setMethod($method);
    $control->addClass($class);

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the louver fieldset.
   *
   * @return LouverFieldSet
   */
  public function getLouverFieldSet(): LouverFieldSet
  {
    return $this->louverFieldSet;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Populates the form.
   */
  public function populate(): void
  {
    if ($this->factory===null)
    {
      throw new LogicException('Factory is not set');
    }

    if ($this->data===null)
    {
      throw new LogicException('Data set is not set');
    }

    $louver = $this->louverFieldSet->getLouverControl();
    $louver->setBodyName($this->bodyName)
           ->setRowFactory($this->factory)
           ->setData($this->data)
           ->populate();

    if (count($this->data)>=3)
    {
      $this->factory->enableFilter();
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the name of louver form control.
   *
   * @param string $bodyName The name.
   *
   * @return LouverForm
   */
  public function setBodyName(string $bodyName): self
  {
    $this->bodyName = $bodyName;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the data set.
   *
   * @param array[]|null $data The data set.
   *
   * @return LouverForm
   */
  public function setData(?array $data): self
  {
    $this->data = $data;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the slat control factory.
   *
   * @param SlatControlFactory|null $factory The slat control factory.
   *
   * @return LouverForm
   */
  public function setFactory(SlatControlFactory $factory): self
  {
    $this->factory = $factory;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the template data and key of the key for dynamically adding additional rows to form.
   *
   * @param array  $data The data for initializing template row(s).
   * @param string $key  The key of the key in the template row.
   *
   * @return LouverForm
   */
  public function setTemplate(array $data, string $key): self
  {
    $this->louverFieldSet->getLouverControl()->setTemplate($data, $key);

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
