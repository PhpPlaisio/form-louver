<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

use Plaisio\Form\SlatJointFactory\SlatControlFactory;
use Plaisio\Form\Table\ErrorTableColumn;
use Plaisio\Form\Table\LouverTable;
use Plaisio\Form\Walker\LoadWalker;
use Plaisio\Form\Walker\PrepareWalker;
use Plaisio\Helper\Html;
use Plaisio\Helper\RenderWalker;
use Plaisio\Table\OverviewTable;

/**
 * Complex control for louver controls.
 *
 * @property-read RenderWalker $renderWalker The render walker for the form controls (not for table elements).
 */
class LouverControl extends ComplexControl
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The key for extending the data rows with data for louver table columns.
   *
   * @var string
   */
  public static string $louverKey = '__louver';

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
  private string $bodyName = 'data';

  /**
   * Object for creating table row form controls.
   *
   * @var SlatControlFactory
   */
  private SlatControlFactory $rowFactory;

  /**
   * The enhanced data shown in the louver control.
   *
   * @var array
   */
  private array $rows;

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
   * Object constructor.
   *
   * @param string|null $name The name of this form control.
   */
  public function __construct(?string $name = '')
  {
    parent::__construct($name);

    $this->renderWalker = new RenderWalker('frm');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getHtml(RenderWalker $walker): string
  {
    $html = $this->prefix;
    $html .= $this->getHtmlLouverTable($walker);
    $html .= $this->postfix;

    return $html;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the HTML code displaying the form controls of this complex form control in a table.
   *
   * @param RenderWalker $walker The object for walking the form control tree.
   *
   * @return string
   */
  public function getHtmlLouverTable(RenderWalker $walker): string
  {
    $this->prepareOverviewTable();

    if (!empty($this->templateData))
    {
      $myWalker = new PrepareWalker($this->submitName);

      // If required add template row to this louver control. This row will be used by JS for adding dynamically
      // additional rows to the louver control.
      $this->templateData[$this->templateKey] = 0;
      $row                                    = $this->rowFactory->createRow($this->templateData);
      $row->prepare($myWalker);
      $this->bodyControl->addFormControl($row);

      $this->rowFactory->getTable()->setAttrData('slat-name', $this->bodyControl->submitName);
    }

    return $this->getHtmlTable($walker);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the underlying overview table.
   *
   * @return LouverTable
   */
  public function getTable(): LouverTable
  {
    return $this->rowFactory->getTable();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function loadSubmittedValuesBase(LoadWalker $walker): void
  {
    if (!empty($this->templateData))
    {
      $prepareWalker = new PrepareWalker($this->submitName);

      $rows = $walker->getSubmittedValue($this->bodyControl->name);
      if (is_array($rows))
      {
        $children       = $this->controls;
        $this->controls = [];
        foreach ($rows as $key => $row)
        {
          if (is_numeric($key) && $key<0)
          {
            $this->templateData[$this->templateKey] = $key;
            $row                                    = $this->rowFactory->createRow($this->templateData);
            $row->prepare($prepareWalker);
            $this->bodyControl->addFormControl($row);
          }
        }

        $this->controls = array_merge($this->controls, $children);
      }
    }

    parent::loadSubmittedValuesBase($walker);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Populates this table form control with table row form controls (based on the data set with setData).
   *
   * @param array $rows The data shown in the louver fieldset.
   */
  public function populate(array $rows): void
  {
    $this->bodyControl = new ComplexControl($this->bodyName);
    $this->addFormControl($this->bodyControl);

    $this->rows = [];
    foreach ($rows as $row)
    {
      $slatControl = $this->rowFactory->createRow($row);
      $this->bodyControl->addFormControl($slatControl);

      $row[self::$louverKey] = ['row'    => $slatControl->getRow(),
                                'walker' => $this->renderWalker,
                                'slat'   => $slatControl];

      $this->rows[] = $row;
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the name of the form control for the body of the table. The default is 'data'.
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
   * Returns the HTML code of this table
   *
   * @param RenderWalker $walker The object for walking the form control tree.
   *
   * @return string
   */
  protected function getHtmlTable(RenderWalker $walker): string
  {
    $table = $this->rowFactory->getTable();
    $table->setWalker($walker);

    $ret = $this->prefix;
    $ret .= $table->getHtmlTable($this->rows);
    $ret .= $this->postfix;

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Prepares the Overview table part for generation HTML code.
   */
  private function prepareOverviewTable(): void
  {
    if (OverviewTable::$responsiveMediaQuery!==null && $this->rowFactory->getTable()->getAttribute('id')===null)
    {
      $this->rowFactory->getTable()->setAttrId(Html::getAutoId());
    }

    if (!$this->isValid())
    {
      $table = $this->rowFactory->getTable();
      $table->addColumn(new ErrorTableColumn());
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
