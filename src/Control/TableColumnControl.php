<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

use Plaisio\Form\Walker\LoadWalker;
use Plaisio\Table\TableColumn\TableColumn;

/**
 * Class SpanControl
 *
 * @package SetBased\Form\Form\Control
 */
class TableColumnControl extends Control
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @var array
   */
  protected array $row;

  /**
   * @var TableColumn
   */
  protected TableColumn $tableColumn;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getHtml(): string
  {
    return $this->tableColumn->getHtmlCell($this->row);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getSetValuesBase(array &$values): void
  {
    // Nothing to do.
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns null.
   *
   * @return null
   */
  public function getSubmittedValue()
  {
    return null;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function mergeValuesBase(array $values): void
  {
    // Nothing to do.
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the table column of this form control.
   *
   * @param TableColumn $tableColumn
   */
  public function setTableColumn(TableColumn $tableColumn): void
  {
    $this->tableColumn = $tableColumn;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the data for to be used by the table column for generating the table cell.
   *
   * @param array $row
   */
  public function setValue(array $row): void
  {
    $this->row = $row;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function setValuesBase(?array $values): void
  {
    // Nothing to do.
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  protected function loadSubmittedValuesBase(LoadWalker $walker): void
  {
    // Nothing to do.
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @param array $invalidFormControls
   *
   * @return bool
   */
  protected function validateBase(array &$invalidFormControls): bool
  {
    return true;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
