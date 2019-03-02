<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\Control;
use SetBased\Abc\Form\Control\SelectControl;

/**
 * Slat joint for table columns witch table cells with a select form control.
 */
class SelectSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $headerText The header text of this table column.
   */
  public function __construct($headerText)
  {
    parent::__construct('control-select', $headerText);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a select form control.
   *
   * @param string $name The local name of the select form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new SelectControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
