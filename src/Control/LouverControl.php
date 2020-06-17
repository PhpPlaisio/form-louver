<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

use Plaisio\Helper\Html;
use Plaisio\Table\OverviewTable;
use SetBased\Helper\Cast;

/**
 * A pseudo form control for generating (pseudo) form controls in a table format.
 */
class LouverControl extends ComplexControl
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The data on which the table row form controls must be created.
   *
   * @var array[]
   */
  protected $data = [];

  /**
   * Form control for the footer of the table.
   *
   * @var Control|null
   */
  protected $footerControl;

  /**
   * Object for creating table row form controls.
   *
   * @var SlatControlFactory
   */
  protected $rowFactory;

  /**
   * The data for initializing the template row(s).
   *
   * @var array|null
   */
  private $templateData;

  /**
   * The key of the key in the template row.
   *
   * @var string|null
   */
  private $templateKey;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Gets the data for which this table form control must be generated.
   *
   * @return array[]
   */
  public function getData(): array
  {
    return $this->data;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the HTML code of displaying the form controls of this complex form control in a table.
   *
   * @return string
   */
  public function getHtml(): string
  {
    $this->prepareOverviewTable();

    if (!empty($this->templateData))
    {
      $this->setAttrData('slat-name', $this->submitName);

      // If required add template row to this louver control. This row will be used by JS for adding dynamically
      // additional rows to the louver control.
      $this->templateData[$this->templateKey] = 0;
      $row                                    = $this->rowFactory->createRow($this, $this->templateData);
      $row->addClass('slat_template');
      $row->setAttrStyle('visibility: collapse');
      $row->prepare($this->submitName);
    }

    $ret = $this->prefix;

    $ret .= Html::generateTag('table', $this->attributes);

    // Generate HTML code for the column classes.
    $ret .= '<colgroup>';
    $ret .= $this->rowFactory->getHtmlColumnGroup();
    $ret .= '</colgroup>';

    $ret .= Html::generateTag('thead', ['class' => OverviewTable::$class]);
    $ret .= $this->getHtmlHeader();
    $ret .= '</thead>';

    if ($this->footerControl)
    {
      $ret .= Html::generateTag('tfoot', ['class' => OverviewTable::$class]);
      $ret .= '<tr>';
      $ret .= Html::generateTag('td', ['colspan' => $this->rowFactory->getNumberOfColumns()]);
      $ret .= $this->footerControl->getHtml();
      $ret .= '</td>';
      $ret .= '<td class="error"></td>';
      $ret .= '</tr>';
      $ret .= '</tfoot>';
    }

    $ret .= Html::generateTag('tbody', ['class' => OverviewTable::$class]);
    $ret .= $this->getHtmlBody();
    $ret .= '</tbody>';

    $ret .= '</table>';

    $ret .= $this->postfix;

    $this->rowFactory->generateResponsiveCss($this->getAttribute('id'));

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function loadSubmittedValuesBase(array $submittedValues,
                                          array &$whiteListValues,
                                          array &$changedInputs): void
  {
    $submitName = ($this->obfuscator) ? $this->obfuscator->encode(Cast::toOptInt($this->name)) : $this->name;

    if (!empty($this->templateData))
    {
      $children       = $this->controls;
      $this->controls = [];
      foreach ($submittedValues[$submitName] as $key => $row)
      {
        if (is_numeric($key) && $key<0)
        {
          $this->templateData[$this->templateKey] = $key;
          $row                                    = $this->rowFactory->createRow($this, $this->templateData);
          $row->prepare($this->submitName);
        }
      }

      $this->controls = array_merge($this->controls, $children);
    }

    parent::loadSubmittedValuesBase($submittedValues, $whiteListValues, $changedInputs);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Populates this table form control with table row form controls (based on the data set with setData).
   */
  public function populate(): void
  {
    foreach ($this->data as $data)
    {
      $this->rowFactory->createRow($this, $data);
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the data for which this table form control must be generated.
   *
   * @param array[] $data
   */
  public function setData(array $data): void
  {
    $this->data = $data;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the footer form control of this table form control.
   *
   * @param Control $control
   */
  public function setFooterControl(Control $control): void
  {
    $this->footerControl = $control;
    $this->addFormControl($control);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the row factory for this table form control.
   *
   * @param SlatControlFactory $rowFactory
   */
  public function setRowFactory(SlatControlFactory $rowFactory): void
  {
    $this->rowFactory = $rowFactory;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the template data and key of the key for dynamically adding additional rows to form.
   *
   * @param array  $data The data for initializing template row(s).
   * @param string $key  The key of the key in the template row.
   */
  public function setTemplate(array $data, string $key): void
  {
    $this->templateData = $data;
    $this->templateKey  = $key;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the inner HTML code of the tbody element of this table form control.
   *
   * @return string
   */
  protected function getHtmlBody(): string
  {
    $ret = '';
    $i   = 0;
    foreach ($this->controls as $control)
    {
      if ($control!==$this->footerControl)
      {
        $control->addClass(OverviewTable::$class);
        $control->addClass(($i % 2==0) ? 'even' : 'odd');

        $ret .= $control->getHtml();

        $i++;
      }
    }

    return $ret;
  }
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the inner HTML code of the thead element (e.g. column headers and filters) of this table form control.
   *
   * @return string
   */
  protected function getHtmlHeader(): string
  {
    return $this->rowFactory->getHtmlHeader();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Prepares the Overview table part for generation HTML code.
   */
  private function prepareOverviewTable(): void
  {
    $this->addClass(OverviewTable::$class);

    if (OverviewTable::$responsiveMediaQuery!==null && $this->getAttribute('id')===null)
    {
      $this->setAttrId(Html::getAutoId());
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
