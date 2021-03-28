<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

/**
 * A pseudo form control for generating slats (rows) in a Louver control.
 */
class SlatControl extends ComplexControl
{
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
