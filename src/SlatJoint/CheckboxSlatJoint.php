<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\CheckboxControl;
use Plaisio\Form\Control\Control;
use Plaisio\Helper\Html;
use Plaisio\Helper\RenderWalker;
use Plaisio\Kernel\Nub;

/**
 * Slat joint for table columns with table cells with a (single) checkbox form control.
 */
class CheckboxSlatJoint extends UniSlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string          $name         The name of this slat joint.
   * @param string|int|null $header       The header text of this table column.
   * @param bool            $headerIsHtml Whether the header is HTML code.
   */
  public function __construct(string $name, $header, bool $headerIsHtml = false)
  {
    parent::__construct($name, 'control-checkbox', $header, $headerIsHtml);
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
    $this->header       = Html::htmlNested(['tag'  => 'input',
                                            'attr' => ['type'  => 'checkbox',
                                                       'class' => 'master-checkbox',
                                                       'id'    => $id]]);
    $this->headerIsHtml = true;

    Nub::$nub->assets->jsAdmFunctionCall(__CLASS__, 'addMasterCheckbox', [$id, 'checked' => $checked]);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a checkbox form control.
   *
   * @param string $name The name of the checkbox form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new CheckboxControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function htmlCell(RenderWalker $walker, array $row): string
  {
    $struct = ['tag'  => 'td',
               'attr' => ['class' => $walker->getClasses(['cell', 'control-checkbox'])],
               'html' => $this->htmlInner($row)];

    return Html::htmlNested($struct);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
