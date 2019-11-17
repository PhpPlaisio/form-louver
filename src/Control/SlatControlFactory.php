<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

use Plaisio\Form\SlatJoint\SlatJoint;
use Plaisio\Helper\Css;
use Plaisio\Helper\Html;
use Plaisio\Kernel\Nub;
use Plaisio\Table\OverviewTable;
use SetBased\Exception\LogicException;

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
  public function addSlatJoint(string $slatJointName, SlatJoint $slatJoint): SlatJoint
  {
    $this->slatJoints[$slatJointName] = $slatJoint;

    $this->numberOfColumns += $slatJoint->getColSpan();

    return $slatJoint;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates a form control using a slat joint and returns the created form control.
   *
   * @param ComplexControl $parentControl The parent form control for the created form control.
   * @param string         $slatJointName The name of the slat joint.
   * @param string|null    $controlName   The name of the created form control. If null the form control will have
   *                                      the same name as the slat joint. Use '' for an empty name (should only be
   *                                      used if the created form control is a complex form control).
   *
   * @return Control
   */
  public function createFormControl(ComplexControl $parentControl,
                                    string $slatJointName,
                                    ?string $controlName = null): Control
  {
    $control = $this->slatJoints[$slatJointName]->createControl($controlName ?? $slatJointName);
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
  abstract public function createRow(LouverControl $louverControl, array $data): SlatControl;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Disables filtering.
   */
  public function disableFilter(): void
  {
    $this->filter = false;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Enables filtering.
   */
  public function enableFilter(): void
  {
    $this->filter = true;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Generates CSS for responsive tables.
   *
   * @param string $id The ID of the table.
   */
  public function generateResponsiveCss(string $id): void
  {
    if (OverviewTable::$responsiveMediaQuery===null) return;

    Nub::$assets->cssAppendLine(OverviewTable::$responsiveMediaQuery);
    Nub::$assets->cssAppendLine('{');
    $format = '#%s tr.%s > td:nth-of-type(%d):before {content: %s;}';
    $index  = 1;
    foreach ($this->slatJoints as $factory)
    {
      $text = $factory->getHeaderText();
      for ($i = 0; $i<$factory->getColSpan(); $i++)
      {
        Nub::$assets->cssAppendLine(sprintf($format, $id, OverviewTable::$class, $index, Css::txt2CssString($text)));
        $index++;
      }
    }

    Nub::$assets->cssAppendLine(sprintf($format, $id, OverviewTable::$class, $index, Css::txt2CssString('error')));

    Nub::$assets->cssAppendLine('}');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the inner HTML code of the colgroup element of the table form control.
   *
   * @return string
   */
  public function getHtmlColumnGroup(): string
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
  public function getHtmlHeader(): string
  {
    $ret = Html::generateTag('tr', ['class' => [OverviewTable::$class, 'header']]);
    foreach ($this->slatJoints as $factory)
    {
      $ret .= $factory->getHtmlColumnHeader();
    }
    $ret .= '<th class="error"></th>';
    $ret .= '</tr>';

    if ($this->filter)
    {
      $ret .= Html::generateTag('tr', ['class' => [OverviewTable::$class, 'filter']]);
      foreach ($this->slatJoints as $factory)
      {
        $ret .= $factory->getHtmlColumnFilter();
      }
      $ret .= '<th class="error"></th>';
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
  public function getNumberOfColumns(): int
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
   *
   * @throws LogicException
   */
  public function getOrdinal(string $slatJointName): int
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
