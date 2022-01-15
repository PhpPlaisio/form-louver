<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

use Plaisio\Helper\Html;
use Plaisio\Helper\RenderWalker;

/**
 * The form control for buttons of a louver fieldset.
 */
class LouverButtons extends ComplexControl
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The number of columns in the louver table.
   *
   * @var int
   */
  private int $colspan = 1;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function htmlControl(RenderWalker $walker): string
  {
    $struct = ['tag'   => 'tfoot',
               'attr'  => ['class' => $walker->getClasses('button-foot')],
               'inner' => ['tag'   => 'tr',
                           'attr'  => ['class' => $walker->getClasses('button-row')],
                           'inner' => ['tag'   => 'td',
                                       'attr'  => ['class'   => $walker->getClasses('button-cell'),
                                                   'colspan' => $this->colspan],
                                       'inner' => ['tag'  => 'div',
                                                   'attr' => ['class' => $walker->getClasses('button-cell-wrapper')],
                                                   'html' => parent::htmlControl($walker)]]]];

    return Html::htmlNested($struct);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the number of columns in the louver table.
   *
   * @param int $colspan The number of columns in the louver table.
   *
   * @return $this
   */
  public function setColspan(int $colspan): self
  {
    $this->colspan = $colspan;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
