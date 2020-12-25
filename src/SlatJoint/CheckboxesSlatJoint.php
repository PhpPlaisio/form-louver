<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\CheckboxesControl;
use Plaisio\Form\Control\Control;

/**
 * Slat joint for table columns with table cells with a checkboxes form control.
 */
class CheckboxesSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $header       The header text of this table column.
   * @param bool            $headerIsHtml Whether the header is HTML code.
   */
  public function __construct($header, bool $headerIsHtml = false)
  {
    parent::__construct('control-checkboxes', $header, $headerIsHtml);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a checkboxes form control.
   *
   * @param string $name The name of the checkboxes form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new CheckboxesControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
