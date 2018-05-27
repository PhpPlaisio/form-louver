<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\InvisibleControl;

/**
 * Slat joint for table columns witch table cells with a (pseudo) invisible form controls.
 */
class InvisibleSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a invisible form control.
   *
   * @param string $name The local name of the invisible form control.
   *
   * @return InvisibleControl
   */
  public function createControl($name)
  {
    return new InvisibleControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A invisible control must never be shown in a table. Hence it spans 0 columns.
   *
   * @return int Always 0
   */
  public function getColSpan()
  {
    return 0;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A invisible control must never be shown in a table. Hence it it has no column.
   *
   * @return string Always empty.
   */
  public function getHtmlColumn()
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A invisible control must never be shown in a table. Hence filter must never be shown too.
   *
   * @return string Empty string
   */
  public function getHtmlColumnFilter()
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A invisible control must never be shown in a table. Hence header must never be shown too.
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
