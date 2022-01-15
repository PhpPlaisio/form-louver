<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\Control;
use Plaisio\Form\Control\RadiosControl;
use Plaisio\Helper\Html;
use Plaisio\Helper\RenderWalker;

/**
 * Slat joint for table columns with table cells with a radios form controls.
 */
class RadiosSlatJoint extends UniSlatJoint
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
    parent::__construct($name, 'control-radios', $header, $headerIsHtml);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a radios form control.
   *
   * @param string $name The name of the radios form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new RadiosControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function htmlCell(RenderWalker $walker, array $row): string
  {
    $struct = ['tag'  => 'td',
               'attr' => ['class' => $walker->getClasses(['cell', 'control-radios'])],
               'html' => $this->htmlInner($row)];

    return Html::htmlNested($struct);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
