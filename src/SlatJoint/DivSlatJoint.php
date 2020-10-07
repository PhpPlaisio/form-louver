<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\Control;
use Plaisio\Form\Control\DivControl;

/**
 * Slat joint for table columns witch table cells with a div element.
 */
class DivSlatJoint extends SlatJoint
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
    parent::__construct('control-div', $header, $headerIsHtml);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a div form control.
   *
   * @param string $name The local name of the div form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new DivControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
