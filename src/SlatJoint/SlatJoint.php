<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\Control;
use Plaisio\Table\TableColumn\BaseTableColumn;

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
