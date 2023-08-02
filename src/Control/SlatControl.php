<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

use Plaisio\Form\Walker\LoadWalker;
use Plaisio\Helper\HtmlElement;
use SetBased\Helper\Cast;

/**
 * A pseudo form control for generating slats (rows) in a Louver control.
 */
class SlatControl extends ComplexControl
{
  //--------------------------------------------------------------------------------------------------------------------
  use HtmlElement;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @var Control|null
   */
  private ?Control $deleteControl = null;

  //--------------------------------------------------------------------------------------------------------------------

  /**
   * Returns all controls of this slat joint.
   *
   * @return array
   */
  public function getRow(): array
  {
    $row = [];
    foreach ($this->controls as $control)
    {
      $row[$control->getName()] = $control;
    }

    return $row;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function loadSubmittedValuesBase(LoadWalker $walker): void
  {
    parent::loadSubmittedValuesBase($walker);

    $submitKey = $this->submitKey();
    if (Cast::isOptInt($submitKey) && $submitKey<0)
    {
      $walker->setChanged($this->name);
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the control for deleting a whole slat (row). When a whole slat (row) is being deleted the form controls
   * of the slat (row) will not be validated.
   *
   * @param Control $control The form control for deleting the whole slat (row).
   *
   * @return $this
   */
  public function setDeleteControl(Control $control): self
  {
    $this->deleteControl = $control;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function validateBase(array &$invalidFormControls): bool
  {
    if ($this->deleteControl!==null &&
      $this->deleteControl->validateBase($invalidFormControls) &&
      $this->deleteControl->getSubmittedValue())
    {
      return true;
    }

    return parent::validateBase($invalidFormControls);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
