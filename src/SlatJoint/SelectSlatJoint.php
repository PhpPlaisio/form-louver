<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\SelectControl;

//----------------------------------------------------------------------------------------------------------------------
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
    $this->dataType   = 'control-select';
    $this->headerText = $headerText;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a select form control.
   *
   * @param string $name The local name of the select form control.
   *
   * @return SelectControl
   */
  public function createControl($name)
  {
    return new SelectControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
