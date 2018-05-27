<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\TextControl;

/**
 * Slat joint for table columns with table cells with a input:text form control.
 */
class TextSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $headerText The header text of this table column.
   */
  public function __construct($headerText)
  {
    parent::__construct('control-text');

    $this->headerText = $headerText;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a text form control.
   *
   * @param string $name The local name of the text form control.
   *
   * @return TextControl
   */
  public function createControl($name)
  {
    return new TextControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
