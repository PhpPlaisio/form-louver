<?php

namespace SetBased\Abc\Form\Control;

use SetBased\Abc\Table\TableColumn\TableColumn;

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
  protected $row;

  /**
   * @var TableColumn
   */
  protected $tableColumn;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getHtml(): string
  {
    return '';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getHtmlTableCell(): string
  {
    return $this->tableColumn->getHtmlCell($this->row);
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
  protected function loadSubmittedValuesBase(array $submittedValues,
                                             array &$whiteListValues,
                                             array &$changedInputs): void
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
