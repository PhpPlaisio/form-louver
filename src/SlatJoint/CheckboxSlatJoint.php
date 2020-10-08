<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\CheckboxControl;
use Plaisio\Form\Control\Control;
use Plaisio\Helper\Html;
use Plaisio\Kernel\Nub;
use Plaisio\Table\OverviewTable;

/**
 * Slat joint for table columns witch table cells with a (single) checkbox form control.
 */
class CheckboxSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|int|null $header       The header text of this table column.
   * @param bool            $headerIsHtml If and only if true the header is HTML code.
   */
  public function __construct($header, bool $headerIsHtml = false)
  {
    parent::__construct('control-checkbox', $header, $headerIsHtml);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Adds a master checkbox to the column header for checking and unchecking all checkboxes in this table column.
   *
   * @param bool $checked If and only if true the master checkbox is initially checked.
   */
  public function addMasterCheckbox(bool $checked): void
  {
    $id                 = Html::getAutoId();
    $this->header       = Html::generateVoidElement('input',
                                                    ['type'  => 'checkbox',
                                                     'class' => [OverviewTable::$class, 'master-checkbox', 'no-sort'],
                                                     'id'    => $id]);
    $this->headerIsHtml = true;

    Nub::$nub->assets->jsAdmFunctionCall(__CLASS__, 'addMasterCheckbox', [$id, 'checked' => $checked]);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a checkbox form control.
   *
   * @param string $name The local name of the checkbox form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new CheckboxControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
