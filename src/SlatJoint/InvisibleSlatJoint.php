<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\Control;
use Plaisio\Form\Control\InvisibleControl;

/**
 * Slat joint for table columns with table cells with a (pseudo) invisible form controls.
 */
class InvisibleSlatJoint extends SlatJoint
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
  /**
   * A invisible control must never be shown in a table. Hence it spans 0 columns.
   *
   * @return int Always 0
   */
  public function getColSpan(): int
  {
    return 0;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A invisible control must never be shown in a table. Hence it it has no column.
   *
   * @return string Always empty.
   */
  public function getHtmlColumn(): string
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A invisible control must never be shown in a table. Hence filter must never be shown too.
   *
   * @return string Empty string
   */
  public function getHtmlColumnFilter(): string
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * A invisible control must never be shown in a table. Hence header must never be shown too.
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
