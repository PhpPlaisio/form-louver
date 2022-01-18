<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

use Plaisio\Form\SlatJointFactory\SlatControlFactory;
use Plaisio\Helper\Html;
use Plaisio\Helper\RenderWalker;
use Plaisio\Kernel\Nub;

/**
 * Fieldset with a LouverControl and submit buttons.
 */
class LouverFieldSet extends FieldSet
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The complex form control holding the buttons of this fieldset.
   *
   * @var ComplexControl|null
   */
  private ?ComplexControl $louverButtons = null;

  /**
   * The louver control.
   *
   * @var LouverControl
   */
  private LouverControl $louverControl;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|null $name The name of this form control.
   */
  public function __construct(?string $name = '')
  {
    parent::__construct($name);

    $this->louverControl = new LouverControl();
    $this->addFormControl($this->louverControl);
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
  public function addSubmitButton($wrdId,
                                  string $method,
                                  string $name = 'submit',
                                  ?string $class = 'btn btn-success'): self
  {
    if ($this->louverButtons===null)
    {
      $this->louverButtons = new LouverButtons();
      $this->addFormControl($this->louverButtons);

      $this->louverControl->getTable()->setButtons($this->louverButtons);
    }

    $input = new SubmitControl($name);
    $input->setValue((is_int($wrdId)) ? Nub::$nub->babel->getWord($wrdId) : $wrdId)
          ->setMethod($method)
          ->addClass($class);
    $this->louverButtons->addFormControl($input);

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the louver control of this louver fieldset.
   *
   * @return LouverControl
   */
  public function getLouverControl(): LouverControl
  {
    return $this->louverControl;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function htmlControl(RenderWalker $walker): string
  {
    $struct = ['tag'   => 'fieldset',
               'attr'  => $this->attributes,
               'inner' => [['html' => $this->htmlLegend($walker)],
                           ['html' => $this->louverControl->htmlControl($walker)]]];

    return Html::htmlNested($struct);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Populates the louver control with data.
   *
   * @param array $rows The data shown in the louver control.
   */
  public function populate(array $rows): void
  {
    $this->louverControl->populate($rows);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the name the louver control.
   *
   * @param string $bodyName The name of the louver control.
   *
   * @return self
   */
  public function setBodyName(string $bodyName): self
  {
    $this->louverControl->setBodyName($bodyName);

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the row factory of the louver control.
   *
   * @param SlatControlFactory $rowFactory
   *
   * @return self
   */
  public function setRowFactory(SlatControlFactory $rowFactory): self
  {
    $this->louverControl->setRowFactory($rowFactory);

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the template data and key of the key for dynamically adding additional rows to form.
   *
   * @param array  $data The data for initializing template row(s).
   * @param string $key  The key of the key in the template row.
   *
   * @return self
   */
  public function setTemplate(array $data, string $key): self
  {
    $this->louverControl->setTemplate($data, $key);

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
