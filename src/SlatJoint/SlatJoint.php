<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\CheckboxesControl;
use SetBased\Abc\Form\Control\ComplexControl;
use SetBased\Abc\Form\Control\RadiosControl;
use SetBased\Abc\Form\Control\SelectControl;
use SetBased\Abc\Form\Control\SimpleControl;
use SetBased\Abc\Table\TableColumn\BaseTableColumn;

/**
 * Abstract parent class for slat joints.
 */
abstract class SlatJoint extends BaseTableColumn
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @param string $name The name of the form control in the table cell.
   *
   * @return ComplexControl|SimpleControl|SelectControl|CheckboxesControl|RadiosControl
   */
  abstract public function createControl($name);

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
