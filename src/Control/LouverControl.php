<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

use Plaisio\Form\Walker\LoadWalker;
use Plaisio\Helper\Html;
use Plaisio\Table\OverviewTable;

/**
 * A pseudo form control for generating (pseudo) form controls in a table format.
 */
class LouverControl extends ComplexControl
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Form control for the body of the table.
   *
   * @var ComplexControl
   */
  private ComplexControl $bodyControl;

  /**
   * The name of the form control for the body of the table.
   *
   * @var string
   */
  private string $bodyName = '';

  /**
   * The data on which the table row form controls must be created.
   *
   * @var array[]
   */
  private array $data = [];

  /**
   * Form control for the footer of the table.
   *
   * @var Control|null
   */
  private ?Control $footerControl = null;

  /**
   * Object for creating table row form controls.
   *
   * @var SlatControlFactory
   */
  private SlatControlFactory $rowFactory;

  /**
   * The data for initializing the template row(s).
   *
   * @var array|null
   */
  private ?array $templateData = null;

  /**
   * The key of the key in the template row.
   *
   * @var string|null
   */
  private ?string $templateKey = null;

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
      $this->setAttrData('slat-name', $this->bodyControl->submitName);

      // If required add template row to this louver control. This row will be used by JS for adding dynamically
      // additional rows to the louver control.
      $this->templateData[$this->templateKey] = 0;
      $row                                    = $this->rowFactory->createRow($this->templateData);
      $row->addClass('slat_template');
      $row->setAttrStyle('visibility: collapse');
      $row->prepare($this->bodyControl->submitName);
      $this->bodyControl->addFormControl($row);
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

    $ret .= Html::generateTag('tbody', ['class' => OverviewTable::$class]);
    $ret .= $this->getHtmlBody();
    $ret .= '</tbody>';

    if ($this->footerControl!==null)
    {
      $ret .= Html::generateTag('tfoot', ['class' => [OverviewTable::$class, 'button-group']]);
      $ret .= '<tr>';
      $ret .= Html::generateTag('td', ['colspan' => $this->rowFactory->getNumberOfColumns(),
                                       'class'   => 'button-group']);
      $ret .= '<div class="button-group">';
      $ret .= $this->footerControl->getHtml();
      $ret .= '</div>';
      $ret .= '</td>';
      $ret .= '<td class="error"></td>';
      $ret .= '</tr>';
      $ret .= '</tfoot>';
    }

    $ret .= '</table>';

    $ret .= $this->postfix;

    $this->rowFactory->generateResponsiveCss($this->getAttribute('id'));

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function loadSubmittedValuesBase(LoadWalker $walker): void
  {
    if (!empty($this->templateData))
    {
      $tmp = $walker->getSubmittedValue($this->bodyControl->name);

      $children       = $this->controls;
      $this->controls = [];
      foreach ($tmp as $key => $row)
      {
        if (is_numeric($key) && $key<0)
        {
          $this->templateData[$this->templateKey] = $key;
          $row                                    = $this->rowFactory->createRow($this->templateData);
          $row->prepare($this->bodyControl->name);
          $this->bodyControl->addFormControl($row);
        }
      }

      $this->controls = array_merge($this->controls, $children);
    }

    parent::loadSubmittedValuesBase($walker);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Populates this table form control with table row form controls (based on the data set with setData).
   */
  public function populate(): void
  {
    $this->bodyControl = new ComplexControl($this->bodyName);
    $this->addFormControl($this->bodyControl);

    foreach ($this->data as $data)
    {
      $this->bodyControl->addFormControl($this->rowFactory->createRow($data));
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the name of the form control for the body of the table.
   *
   * @param string $bodyName The name of the form control for the body of the table.
   *
   * @return self
   */
  public function setBodyName(string $bodyName): self
  {
    $this->bodyName = $bodyName;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the data for which this table form control must be generated.
   *
   * @param array[] $data
   *
   * @return self
   */
  public function setData(array $data): self
  {
    $this->data = $data;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the footer form control of this table form control.
   *
   * @param Control $control
   *
   * @return self
   */
  public function setFooterControl(Control $control): self
  {
    $this->footerControl = $control;
    $this->addFormControl($control);

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the row factory for this table form control.
   *
   * @param SlatControlFactory $rowFactory
   *
   * @return self
   */
  public function setRowFactory(SlatControlFactory $rowFactory): self
  {
    $this->rowFactory = $rowFactory;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the template data and key of the key for dynamically adding additional rows to form.
   *
   * @param array  $data The data for initializing template row(s).
   * @param string $key  The key of the key in the template row.
   *
   * @return self
   */
  public function setTemplate(array $data, string $key): self
  {
    $this->templateData = $data;
    $this->templateKey  = $key;

    return $this;
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
    foreach ($this->bodyControl->controls as $control)
    {
      $control->addClass(OverviewTable::$class);
      $control->addClass(($i % 2==0) ? 'even' : 'odd');

      $ret .= $control->getHtml();

      $i++;
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
