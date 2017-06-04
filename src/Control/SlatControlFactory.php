<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Form\Control;

use SetBased\Abc\Form\SlatJoint\SlatJoint;
use SetBased\Exception\LogicException;

//----------------------------------------------------------------------------------------------------------------------
/**
 * Abstract parent class for factories for creating slat controls.
 */
abstract class SlatControlFactory
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * If set to true the header will contain a row for filtering.
   *
   * @var bool
   */
  protected $filter = false;

  /**
   * The slat joints for the louver control of this slat control factory.
   *
   * @var SlatJoint[]
   */
  protected $slatJoints;

  /**
   * The number of columns in the under lying table of the slat form control.
   *
   * @var int
   */
  private $numberOfColumns = 0;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Adds a slat joint (i.e. a column to the form) to this slat control factory and returns this slat joint.
   *
   * @param string    $slatJointName The name of the slat joint.
   * @param SlatJoint $slatJoint     The slat joint.
   *
   * @return SlatJoint
   */
  public function addSlatJoint($slatJointName, $slatJoint)
  {
    $this->slatJoints[$slatJointName] = $slatJoint;

    $this->numberOfColumns += $slatJoint->getColSpan();

    return $slatJoint;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates a form control using a slat joint and returns the created form control.
   *
   * @param ComplexControl $parentControl    The parent form control for the created form control.
   * @param string         $slatJointName    The name of the slat joint.
   * @param string|null    $controlName      The name of the created form control. If null the form control will have
   *                                         the same name as the slat joint. Use '' for an empty name (should only be
   *                                         used if the created form control is a complex form control).
   *
   * @return ComplexControl|SimpleControl|SelectControl|CheckboxesControl|RadiosControl
   */
  public function createFormControl($parentControl, $slatJointName, $controlName = null)
  {
    $control = $this->slatJoints[$slatJointName]->createControl(isset($controlName) ? $controlName : $slatJointName);
    $parentControl->addFormControl($control);

    return $control;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates the form controls of a slat in a louver control.
   *
   * @param LouverControl $louverControl The louver control.
   * @param array         $data          An array from the nested arrays as set in LouverControl::setData.
   *
   * @return SlatControl
   */
  abstract public function createRow($louverControl, $data);

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Disables filtering.
   */
  public function disableFilter()
  {
    $this->filter = false;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Enables filtering.
   */
  public function enableFilter()
  {
    $this->filter = true;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the inner HTML code of the colgroup element of the table form control.
   *
   * @return string
   */
  public function getColumnGroup()
  {
    $ret = '';
    foreach ($this->slatJoints as $factory)
    {
      $ret .= $factory->getHtmlCol();
    }

    $ret .= '<col/>';

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the inner HTML code of the thead element of the table form control.
   *
   * @return string
   */
  public function getHtmlHeader()
  {
    $ret = '<tr class="header">';
    foreach ($this->slatJoints as $factory)
    {
      $ret .= $factory->getHtmlColumnHeader();
    }
    $ret .= '<td class="error"></td>';
    $ret .= '</tr>';

    if ($this->filter)
    {
      $ret .= '<tr class="filter">';
      foreach ($this->slatJoints as $factory)
      {
        $ret .= $factory->getHtmlColumnFilter();
      }
      $ret .= '<td class="error"></td>';
      $ret .= '</tr>';
    }

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the number of columns in the underlying table of the louver form control.
   *
   * @return int
   */
  public function getNumberOfColumns()
  {
    return $this->numberOfColumns;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the 0-indexed ordinal of a slat joint in the underlying table of the louver form control.
   *
   * @param string $slatJointName The name of the slat joint.
   *
   * @return int
   * @throws LogicException
   */
  public function getOrdinal($slatJointName)
  {
    $ordinal = 0;
    $key     = null;
    foreach ($this->slatJoints as $key => $slat_joint)
    {
      if ($key==$slatJointName) break;

      $ordinal += $slat_joint->getColSpan();
    }

    if ($key!=$slatJointName)
    {
      throw new LogicException("SlatJoint '%s' not found.", $slatJointName);
    }

    return $ordinal;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
