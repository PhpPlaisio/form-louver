<?php
declare(strict_types=1);

namespace Plaisio\Form\Table;

use Plaisio\Form\Control\LouverButtons;
use Plaisio\Form\Control\LouverControl;
use Plaisio\Form\Control\SlatControl;
use Plaisio\Helper\RenderWalker;
use Plaisio\Table\OverviewTable;

/**
 * Class for louver tables. A louver table is an overview table where the rows are slats.
 */
class LouverTable extends OverviewTable
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The complex form control holding the buttons of the louver fieldset.
   *
   * @var LouverButtons|null
   */
  private ?LouverButtons $buttonsControl = null;

  /**
   * The object for walking the form control tree.
   *
   * @var RenderWalker|null
   */
  private ?RenderWalker $walker = null;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the footer with buttons.
   *
   * @return string
   */
  public function htmlFooter(): string
  {
    if ($this->buttonsControl===null)
    {
      return '';
    }

    $this->buttonsControl->setColspan($this->getNumberOfColumns());

    return $this->buttonsControl->htmlControl($this->walker);
  }

  //--------------------------------------------------------------------------------------------------------------------
  public function htmlTemplateRow(SlatControl $slatControl, array $row): string
  {
    $row[LouverControl::$louverKey] = ['row'    => $slatControl->getRow(),
                                       'attr'   => $slatControl->getAttributes(),
                                       'walker' => $this->renderWalker,
                                       'slat'   => $slatControl];

    return $this->htmlRow(0, $row);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the button form control.
   *
   * @param LouverButtons|null $buttonsControl The form control with buttons.
   *
   * @return $this
   */
  public function setButtons(?LouverButtons $buttonsControl): self
  {
    $this->buttonsControl = $buttonsControl;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the object for walking the form control tree.
   *
   * @param RenderWalker|null $walker The object for walking the form control tree.
   */
  public function setWalker(?RenderWalker $walker): void
  {
    $this->walker = $walker;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
