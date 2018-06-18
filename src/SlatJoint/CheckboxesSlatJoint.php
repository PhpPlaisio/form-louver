<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\CheckboxesControl;
use SetBased\Abc\Form\Control\Control;

/**
 * Slat joint for table columns witch table cells with a checkboxes form control.
 */
class CheckboxesSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $headerText The header text of this table column.
   */
  public function __construct($headerText)
  {
    parent::__construct('control-checkboxes');

    $this->headerText = $headerText;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a checkboxes form control.
   *
   * @param string $name The local name of the checkboxes form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new CheckboxesControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
