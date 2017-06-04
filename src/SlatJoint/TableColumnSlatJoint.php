<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Form\SlatJoint;

use SetBased\Abc\Form\Control\TableColumnControl;
use SetBased\Abc\Table\TableColumn\TableColumn;

//----------------------------------------------------------------------------------------------------------------------
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
   * @param TableColumn $tableColumn
   */
  public function __construct($tableColumn)
  {
    parent::__construct($tableColumn->getDataType());

    $this->tableColumn = $tableColumn;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates and returns a button form control.
   *
   * @param string $name The local name of the button form control.
   *
   * @return TableColumnControl
   */
  public function createControl($name)
  {
    $control = new TableColumnControl($name);
    $control->setTableColumn($this->tableColumn);

    return $control;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  public function getColSpan()
  {
    return $this->tableColumn->getColSpan();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  public function getHtmlCol()
  {
    return $this->tableColumn->getHtmlCol();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  public function getHtmlColumnFilter()
  {
    return $this->tableColumn->getHtmlColumnFilter();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  public function getHtmlColumnHeader()
  {
    return $this->tableColumn->getHtmlColumnHeader();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
