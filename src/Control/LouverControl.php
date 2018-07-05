<?php

namespace SetBased\Abc\Form\Control;

use SetBased\Abc\Helper\Html;

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
   * @var control|null
   */
  protected $footerControl;

  /**
   * Object for creating table row form controls.
   *
   * @var SlatControlFactory
   */
  protected $rowFactory;

  /**
   * The data for initializing teh template row(s).
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

    $ret .= Html::generateTag('div', $this->attributes);
    $ret .= '<table>';

    // Generate HTML code for the column classes.
    $ret .= '<colgroup>';
    $ret .= $this->rowFactory->getColumnGroup();
    $ret .= '</colgroup>';

    $ret .= '<thead>';
    $ret .= $this->getHtmlHeader();
    $ret .= '</thead>';

    if ($this->footerControl)
    {
      $ret .= '<tfoot>';
      $ret .= '<tr>';
      $ret .= Html::generateTag('td', ['colspan' => $this->rowFactory->getNumberOfColumns()]);
      $ret .= $this->footerControl->getHtml();
      $ret .= '</td>';
      $ret .= '<td class="error"></td>';
      $ret .= '</tr>';
      $ret .= '</tfoot>';
    }

    $ret .= '<tbody>';
    $ret .= $this->getHtmlBody();
    $ret .= '</tbody>';

    $ret .= '</table>';
    $ret .= '</div>';

    $ret .= $this->postfix;

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
    $submitName = ($this->obfuscator) ? $this->obfuscator->encode($this->name) : $this->name;

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
        // Add class for zebra theme.
        $control->addClass(($i % 2==0) ? 'even' : 'odd');

        // Generate the table row.
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
}

//----------------------------------------------------------------------------------------------------------------------
