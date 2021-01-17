<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

use Plaisio\Helper\Html;
use Plaisio\Helper\RenderWalker;

/**
 * Form control for buttons of a louver fieldset.
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
  public function getHtml(RenderWalker $walker): string
  {
    $buttonAttributes  = ['class' => $walker->getClasses('button')];
    $buttonAttributes2 = ['class' => $walker->getClasses('button'), 'colspan' => $this->colspan];

    $ret = Html::generateTag('tfoot', $buttonAttributes);
    $ret .= Html::generateTag('tr', $buttonAttributes);
    $ret .= Html::generateTag('td', $buttonAttributes2);
    $ret .= Html::generateTag('div', $buttonAttributes);
    $ret .= parent::getHtml($walker);
    $ret .= '</div>';
    $ret .= '</td>';
    $ret .= '</tr>';
    $ret .= '</tfoot>';

    return $ret;
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
