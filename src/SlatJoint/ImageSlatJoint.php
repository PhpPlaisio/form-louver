<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\Control;
use SetBased\Abc\Form\Control\ImageControl;

/**
 * Slat joint for table columns witch table cells with a input:image form control.
 */
class ImageSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $headerText The header text of this table column.
   */
  public function __construct($headerText)
  {
    parent::__construct('control-image', $headerText);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a image form control.
   *
   * @param string $name The local name of the image form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new ImageControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns HTML code (including opening and closing th tags) for the table filter cell.
   *
   * @return string
   */
  public function getHtmlColumnFilter(): string
  {
    return '<td></td>';
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
