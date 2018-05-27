<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\HiddenControl;

/**
 * Slat joint for table columns witch table cells with a input:hidden form control.
 */
class HiddenSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a hidden form control.
   *
   * @param string $name The local name of the hidden form control.
   *
   * @return HiddenControl
   */
  public function createControl($name)
  {
    return new HiddenControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A hidden control must never be shown in a table. Hence it spans 0 columns.
   *
   * @return int Always 0
   */
  public function getColSpan()
  {
    return 0;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A hidden control must never be shown in a table. Hence it it has no column.
   *
   * @return string Always empty.
   */
  public function getHtmlColumn()
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A hidden control must never be shown in a table. Hence filter must never be shown too.
   *
   * @return string Empty string
   */
  public function getHtmlColumnFilter()
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A hidden control must never be shown in a table. Hence header must never be shown too.
   *
   * @return string Empty string
   */
  public function getHtmlColumnHeader()
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
