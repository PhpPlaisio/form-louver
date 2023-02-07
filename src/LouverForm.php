<?php
declare(strict_types=1);

namespace Plaisio\Form;

use Plaisio\Form\Control\LouverFieldSet;
use Plaisio\Form\SlatJointFactory\SlatControlFactory;

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
   * The fieldset with the louver control.
   *
   * @var LouverFieldSet
   */
  private LouverFieldSet $louverFieldSet;

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
    $this->addFieldSet($this->louverFieldSet);
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
   * @return $this
   */
  public function addSubmitButton(int|string $wrdId,
                                  string     $method,
                                  string     $name = 'submit',
                                  ?string    $class = 'btn btn-success'): self
  {
    $this->louverFieldSet->addSubmitButton($wrdId, $method, $name, $class);

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
   * Populates this table form control with table row form controls.
   *
   * @param array $rows The data shown in the louver fieldset.
   *
   * @return $this
   */
  public function populate(array $rows): self
  {
    $this->louverFieldSet->getLouverControl()->populate($rows);

    if (count($rows)>3)
    {
      $this->louverFieldSet->getLouverControl()->getTable()->enableFilter();
    }

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the name of louver form control.
   *
   * @param string $name The name.
   *
   * @return $this
   */
  public function setName(string $name): self
  {
    $this->louverFieldSet->getLouverControl()->setName($name);

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the slat control factory.
   *
   * @param SlatControlFactory $factory The slat control factory.
   *
   * @return $this
   */
  public function setRowFactory(SlatControlFactory $factory): self
  {
    $this->louverFieldSet->getLouverControl()->setRowFactory($factory);

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the template data and key of the key for dynamically adding additional rows to form.
   *
   * @param array  $data The data for initializing template row(s).
   * @param string $key  The key of the key in the template row.
   * @param string $id   The ID of the HTML element when clicked a new row must be added to the louver form.
   *
   * @return $this
   */
  public function setTemplate(array $data, string $key, string $id): self
  {
    $this->louverFieldSet->getLouverControl()->setTemplate($data, $key, $id);

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
