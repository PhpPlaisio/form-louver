<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\FileControl;

//----------------------------------------------------------------------------------------------------------------------
/**
 * Slat joint for table columns witch table cells with a input:file form control.
 */
class FileSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $headerText The header text of this table column.
   */
  public function __construct($headerText)
  {
    $this->dataType   = 'control-file';
    $this->headerText = $headerText;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a file form control.
   *
   * @param string $name The local name of the file form control.
   *
   * @return FileControl
   */
  public function createControl($name)
  {
    return new FileControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
