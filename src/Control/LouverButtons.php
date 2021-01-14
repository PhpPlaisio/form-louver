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

  /**
   * The CSS module class for the footer elements.
   *
   * @var string
   */
  private string $moduleClass;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getHtml(RenderWalker $walker): string
  {
    $myWalker = new RenderWalker($this->moduleClass, $this->moduleClass);

    $buttonAttributes  = ['class' => $myWalker->getClasses('button')];
    $buttonAttributes2 = ['class' => $myWalker->getClasses('button'), 'colspan' => $this->colspan];

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
  /**
   * sets the CSS module class for the footer elements.
   *
   * @param string $moduleClass The CSS module class for the footer elements.
   *
   * @return LouverButtons
   */
  public function setModuleClass(string $moduleClass): LouverButtons
  {
    $this->moduleClass = $moduleClass;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
