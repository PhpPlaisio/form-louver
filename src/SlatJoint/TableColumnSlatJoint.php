<?php

namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\Control;
use SetBased\Abc\Form\Control\TableColumnControl;
use SetBased\Abc\Table\TableColumn\TableColumn;

class TableColumnSlatJoint extends SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The table column of this slat joint.
   *
   * @var TableColumn
   */
  private $tableColumn;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param TableColumn $tableColumn The table column.
   */
  public function __construct(TableColumn $tableColumn)
  {
    parent::__construct($tableColumn->getDataType(), $tableColumn->getHeaderText());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a button form control.
   *
   * @param string $name The local name of the button form control.
   *
   * @return Control
   */
  public function createControl(string $name): Control
  {
    $control = new TableColumnControl($name);
    $control->setTableColumn($this->tableColumn);

    return $control;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getColSpan(): int
  {
    return $this->tableColumn->getColSpan();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getHtmlCol(): string
  {
    return $this->tableColumn->getHtmlCol();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getHtmlColumnFilter(): string
  {
    return $this->tableColumn->getHtmlColumnFilter();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getHtmlColumnHeader(): string
  {
    return $this->tableColumn->getHtmlColumnHeader();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
