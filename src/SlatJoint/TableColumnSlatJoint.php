<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\Control;
use Plaisio\Form\Control\TableColumnControl;
use Plaisio\Table\TableColumn\TableColumn;

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
    parent::__construct($tableColumn->getDataType(), $tableColumn->getHeader());

    $this->tableColumn = $tableColumn;
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
