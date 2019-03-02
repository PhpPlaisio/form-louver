<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\ButtonControl;
use SetBased\Abc\Form\Control\Control;

/**
 * Slat joint for table columns witch table cells with a button form control.
 */
class ButtonSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $headerText The header text of this table column.
   */
  public function __construct($headerText)
  {
    parent::__construct('control-button', $headerText);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a button form control.
   *
   * @param string $name The local name of the button form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new ButtonControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns HTML code (including opening and closing th tags) for the table filter cell.
   *
   * @return string
   */
  public function getHtmlColumnFilter(): string
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
