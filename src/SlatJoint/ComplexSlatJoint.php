<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\ComplexControl;
use Plaisio\Form\Control\Control;

/**
 * Slat joint for table columns witch table cells with a complex form control.
 */
class ComplexSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $header The header text of this table column.
   * @param bool            $headerIsHtml If and only if true the header is HTML code.
   */
  public function __construct($header, bool $headerIsHtml = false)
  {
    parent::__construct('control-complex', $header, $headerIsHtml);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a complex form control.
   *
   * @param string $name The local name of the complex form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new ComplexControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
