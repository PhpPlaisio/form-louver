<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\ConstantControl;
use SetBased\Abc\Form\Control\Control;

/**
 * Slat joint for table columns witch table cells with a constant form controls.
 */
class ConstantSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a constant form control.
   *
   * @param string $name The local name of the constant form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new ConstantControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A constant control must never be shown in a table. Hence it spans 0 columns.
   *
   * @return int Always 0
   */
  public function getColSpan(): int
  {
    return 0;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A constant control must never be shown in a table. Hence it it has no column.
   *
   * @return string Always empty.
   */
  public function getHtmlColumn(): string
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A constant control must never be shown in a table. Hence filter must never be shown too.
   *
   * @return string Empty string
   */
  public function getHtmlColumnFilter(): string
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A constant control must never be shown in a table. Hence header must never be shown too.
   *
   * @return string Empty string
   */
  public function getHtmlColumnHeader(): string
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
