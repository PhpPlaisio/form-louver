<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\Control;
use SetBased\Abc\Table\TableColumn\BaseTableColumn;

/**
 * Abstract parent class for slat joints.
 */
abstract class SlatJoint extends BaseTableColumn
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates a control for a table cell.
   *
   * @param string $name The name of the form control in the table cell.
   *
   * @return Control
   */
  abstract public function createControl(string $name): Control;

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
