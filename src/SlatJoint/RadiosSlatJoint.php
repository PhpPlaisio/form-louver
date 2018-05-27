<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\RadiosControl;

/**
 * Slat joint for table columns witch table cells with a radios form controls.
 */
class RadiosSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $headerText The header text of this table column.
   */
  public function __construct($headerText)
  {
    parent::__construct('control-radios');

    $this->headerText = $headerText;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a radios form control.
   *
   * @param string $name The local name of the radios form control.
   *
   * @return RadiosControl
   */
  public function createControl($name)
  {
    return new RadiosControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
