<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

/**
 * A pseudo form control for generating table rows in a Louver control.
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
   * Returns the all controls of this slat joint.
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
  public function setDeleteControl($control)
  {
    $this->deleteControl = $control;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function validateBase(array &$invalidFormControls): bool
  {
    $valid = true;

    if ($this->deleteControl!==null)
    {
      if (!$this->deleteControl->validateBase($invalidFormControls))
      {
        $this->invalidControls[] = $this->deleteControl;
        $valid                   = false;
      }
      else
      {
        if ($this->deleteControl->getSubmittedValue())
        {
          return $valid;
        }
      }
    }

    // First, validate all child form controls.
    foreach ($this->controls as $control)
    {
      if ($control!==$this->deleteControl)
      {
        if (!$control->validateBase($invalidFormControls))
        {
          $this->invalidControls[] = $control;
          $valid                   = false;
        }
      }
    }

    if ($valid)
    {
      // All the child form controls are valid. Validate this complex form control.
      foreach ($this->validators as $validator)
      {
        $valid = $validator->validate($this);
        if ($valid!==true)
        {
          $invalidFormControls[] = $this;
          break;
        }
      }
    }

    return $valid;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
