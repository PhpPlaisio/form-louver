<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\Control;
use Plaisio\Form\Control\TextControl;
use Plaisio\Helper\Html;
use Plaisio\Helper\RenderWalker;

/**
 * Slat joint for table columns with table cells with an input:text form control.
 */
class TextSlatJoint extends UniSlatJoint
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
    parent::__construct($name, 'control-text', $header, $headerIsHtml);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a text form control.
   *
   * @param string $name The name of the text form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    return new TextControl($name);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function htmlCell(RenderWalker $walker, array $row): string
  {
    $struct = ['tag'  => 'td',
               'attr' => ['class' => $walker->getClasses(['cell', 'control-text'])],
               'html' => $this->htmlInner($row)];

    return Html::htmlNested($struct);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
