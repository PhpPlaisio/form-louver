<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\Control;
use Plaisio\Form\Control\HiddenControl;

/**
 * Slat joint for table columns with table cells with a input:hidden form control.
 */
class HiddenSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   */
  public function __construct()
  {
    parent::__construct('none', null);
  }

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
  /**
   * A hidden control must never be shown in a table. Hence it spans 0 columns.
   *
   * @return int Always 0
   */
  public function getColSpan(): int
  {
    return 0;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A hidden control must never be shown in a table. Hence it it has no column.
   *
   * @return string Always empty.
   */
  public function getHtmlColumn(): string
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A hidden control must never be shown in a table. Hence filter must never be shown too.
   *
   * @return string Empty string
   */
  public function getHtmlColumnFilter(): string
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A hidden control must never be shown in a table. Hence header must never be shown too.
   *
   * @return string Empty string
   */
  public function getHtmlColumnHeader(): string
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
