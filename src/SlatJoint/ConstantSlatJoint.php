<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\ConstantControl;
use Plaisio\Form\Control\Control;

/**
 * Slat joint for table columns with table cells with a constant form controls.
 */
class ConstantSlatJoint extends NonSlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a constant form control.
   *
   * @param string $name The name of the constant form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new ConstantControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
