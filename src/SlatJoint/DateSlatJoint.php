<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\Control;
use SetBased\Abc\Form\Control\DateControl;

/**
 * Slat joint for table columns with table cells with a input:text form control for dates.
 */
class DateSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $headerText The header text of this table column.
   */
  public function __construct($headerText)
  {
    parent::__construct('control-text', $headerText);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a date form control.
   *
   * @param string $name The local name of the date form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new DateControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
