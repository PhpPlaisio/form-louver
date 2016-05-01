<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\CheckboxControl;

//----------------------------------------------------------------------------------------------------------------------
/**
 * Slat joint for table columns witch table cells with a (single) checkbox form control.
 */
class CheckboxSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $headerText The header text of this table column.
   */
  public function __construct($headerText)
  {
    $this->dataType   = 'control-checkbox';
    $this->headerText = $headerText;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a checkbox form control.
   *
   * @param string $name The local name of the checkbox form control.
   *
   * @return CheckboxControl
   */
  public function createControl($name)
  {
    return new CheckboxControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
