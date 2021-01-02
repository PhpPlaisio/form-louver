<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\Control;
use Plaisio\Form\Control\InvisibleControl;

/**
 * Slat joint for table columns with table cells with a (pseudo) invisible form controls.
 */
class InvisibleSlatJoint extends NonSlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a invisible form control.
   *
   * @param string $name The name of the invisible form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new InvisibleControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
