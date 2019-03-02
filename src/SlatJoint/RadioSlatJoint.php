<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\Control;
use SetBased\Abc\Form\Control\RadioControl;

/**
 * Slat joint for table columns witch table cells with a input:radio form control.
 */
class RadioSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $headerText The header text of this table column.
   */
  public function __construct($headerText)
  {
    parent::__construct('control-radio', $headerText);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a radio form control.
   *
   * @param string $name The local name of the radio form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new RadioControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
