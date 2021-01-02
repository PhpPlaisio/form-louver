<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\Control;
use Plaisio\Form\Control\HiddenControl;
use Plaisio\Table\TableColumn\NonTableColumn;

/**
 * Slat joint for table columns with table cells with a input:hidden form control.
 */
class HiddenSlatJoint extends NonTableColumn
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a hidden form control.
   *
   * @param string $name The name of the hidden form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new HiddenControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
