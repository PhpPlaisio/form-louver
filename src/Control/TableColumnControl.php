<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Form\Control;

use SetBased\Abc\Table\TableColumn\TableColumn;

//----------------------------------------------------------------------------------------------------------------------
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
   * {@inheritdoc}
   */
  public function generate()
  {
    return null;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  public function getHtmlTableCell()
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
  public function setTableColumn($tableColumn)
  {
    $this->tableColumn = $tableColumn;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the data for to be used by the table column for generating the table cell.
   *
   * @param array $row
   */
  public function setValue($row)
  {
    $this->row = $row;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  protected function loadSubmittedValuesBase(&$submittedValue, &$whiteListValue, &$changedInputs)
  {
    // Nothing to do.
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @param array $invalidFormControls
   *
   * @return bool
   */
  protected function validateBase(&$invalidFormControls)
  {
    return true;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
