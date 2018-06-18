<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\ComplexControl;
use SetBased\Abc\Form\Control\Control;

/**
 * Slat joint for table columns witch table cells with a complex form control.
 */
class ComplexSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $headerText The header text of this table column.
   */
  public function __construct($headerText)
  {
    parent::__construct('control-complex');

    $this->headerText = $headerText;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a complex form control.
   *
   * @param string $name The local name of the complex form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new ComplexControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
