<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\Control;
use Plaisio\Table\TableColumn\TableColumn;

/**
 * Abstract parent class for slat joints.
 */
interface SlatJoint extends TableColumn
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates a control for a table cell.
   *
   * @param string $name The name of the form control in the table cell.
   *
   * @return Control
   */
  public function createControl(string $name): Control;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the name of this slat joint.
   *
   * @return string
   */
  public function getName(): string;

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
