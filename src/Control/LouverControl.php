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
#[\AllowDynamicProperties]
class LouverControl extends ComplexControl
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Adds a new slat at the top of the louver.
   */
  const POSITION_TOP = 'top';

  /**
   * Adds a new slat at the bottom of the louver.
   */
  const POSITION_BOTTOM = 'bottom';

  /**
   * The key for extending the data rows with data for louver table columns.
   *
   * @var string
   */
  public static string $louverKey = '__louver';

  /**
   * The ID of the HTML element when clicked a new row must be added to the louver form.
   *
   * @var string|null
   */
  private ?string $adderId = null;

  /**
   * The position where to add new slats.
   *
   * @var string
   */
  private string $newSlatPosition = self::POSITION_TOP;

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
   * The submit keys of the slat controls.
   *
   * @var string[]
   */
  private array $submitKeys = [];

  /**
   * The data for initializing template row(s).
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
  public function htmlControl(RenderWalker $walker): string
  {
    return $this->htmlLouverTable($walker);
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

      $values = $walker->getSubmittedValue($this->name);
      if (is_array($values))
      {
        $children     = [];
        $rows         = [];
        $templateData = $this->templateData;
        foreach ($values as $submitKey => $value)
        {
          if (!in_array($submitKey, $this->submitKeys))
          {
            // This is a (in the front end) dynamically added row.
            $templateData[$this->templateKey] = $submitKey;
            $slatControl                      = $this->rowFactory->createRow($templateData);
            $slatControl->setIsDynamical(true)
                        ->prepare($prepareWalker);

            $this->enhanceRow($templateData, $slatControl);
            $children[] = $slatControl;
            $rows[]     = $templateData;
          }
          else
          {
            // This is an existing row.
            $slatControl = array_shift($this->controls);
            if ($slatControl!==null)
            {
              $children[] = $slatControl;
            }
            $row = array_shift($this->rows);
            if ($row!==null)
            {
              $rows[] = $row;
            }
          }
        }

        $this->controls = $children;
        $this->rows     = $rows;
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
    $this->rows = [];
    foreach ($rows as $row)
    {
      $slatControl = $this->rowFactory->createRow($row);
      $this->addFormControl($slatControl);
      $this->enhanceRow($row, $slatControl);

      $this->rows[] = $row;
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function prepare(PrepareWalker $walker): void
  {
    parent::prepare($walker);

    foreach ($this->controls as $control)
    {
      $this->submitKeys[] = $control->submitKey();
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the name the louver control.
   *
   * @param string $name The name of the louver control.
   *
   * @return self
   */
  public function setName(string $name): self
  {
    $this->name = $name;

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
   * @param string $id   The ID of the HTML element when clicked a new row must be added to the louver form.
   *
   * @return self
   */
  public function setTemplate(array $data, string $key, string $id): self
  {
    $this->templateData = $data;
    $this->templateKey  = $key;
    $this->adderId      = $id;

    return $this;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Enhance a data row with attributes required by other parts of this package.
   *
   * @param mixed       $row         The row to be enhanced.
   * @param SlatControl $slatControl The related slat control of the data row.
   */
  private function enhanceRow(array &$row, SlatControl $slatControl): void
  {
    $row[self::$louverKey] = ['row'    => $slatControl->getRow(),
                              'attr'   => $slatControl->getAttributes(),
                              'walker' => $this->renderWalker,
                              'slat'   => $slatControl];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns whether one or more rows has one or more error messages.
   *
   * @return bool
   */
  private function hasRowErrorMessages(): bool
  {
    $hasErrorMessages = false;
    foreach ($this->controls as $control)
    {
      if (!empty($control->getErrorMessages()))
      {
        $hasErrorMessages = true;
        break;
      }
    }

    return $hasErrorMessages;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the HTML code displaying the form controls of this complex form control in a table.
   *
   * @param RenderWalker $walker The object for walking the form control tree.
   *
   * @return string
   */
  private function htmlLouverTable(RenderWalker $walker): string
  {
    $this->prepareOverviewTable();

    if (!empty($this->templateData))
    {
      $prepareWalker                          = new PrepareWalker($this->submitName);
      $this->templateData[$this->templateKey] = 0;
      $slatControl                            = $this->rowFactory->createRow($this->templateData);
      $slatControl->prepare($prepareWalker);

      $table = $this->rowFactory->getTable();
      $table->setAttrData('louver', 'louver')
            ->setAttrData('louver-adder-id', $this->adderId)
            ->setAttrData('louver-new-slat-position', $this->newSlatPosition)
            ->setAttrData('louver-slat-name', $this->submitName)
            ->setAttrData('louver-template', $table->htmlTemplateRow($slatControl, $this->templateData))
            ->setAttrData('louver-walker-module-class', $walker->getModuleClass())
            ->setAttrData('louver-walker-sub-module-class', $walker->getSubModuleClass());
    }

    return $this->htmlTable($walker);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the HTML code of this table
   *
   * @param RenderWalker $walker The object for walking the form control tree.
   *
   * @return string
   */
  private function htmlTable(RenderWalker $walker): string
  {
    $table = $this->rowFactory->getTable();
    $table->setWalker($walker);

    return $table->htmlTable($this->rows);
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

    if ($this->hasRowErrorMessages())
    {
      $table = $this->rowFactory->getTable();
      $table->addColumn(new ErrorTableColumn());
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
