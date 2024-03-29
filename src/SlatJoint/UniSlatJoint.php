<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Form\Control\Control;
use Plaisio\Form\Control\LouverControl;
use Plaisio\Helper\Html;
use Plaisio\Helper\RenderWalker;
use Plaisio\Table\TableColumn\UniTableColumn;

/**
 * Abstract parent class for slat joints of one column.
 */
abstract class UniSlatJoint extends UniTableColumn implements SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The name of this slat joint.
   *
   * @var string
   */
  private string $name;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string          $name         The name of this slat joint.
   * @param string          $dataType     The data type of this table column.
   * @param int|string|null $header       The header text of this table column.
   * @param bool            $headerIsHtml Whether the header is HTML code.
   */
  public function __construct(string $name, string $dataType, int|string|null $header, bool $headerIsHtml = false)
  {
    parent::__construct($dataType, $header, $headerIsHtml);

    $this->name = $name;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public function getName(): string
  {
    return $this->name;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the inner HTML for a table cell of the slat joint.
   *
   * @param array $row The data of a row in the overview table.
   *
   * @return string
   */
  protected function htmlInner(array $row): string
  {
    /** @var Control $control */
    /** @var RenderWalker $walker */
    $control = $row[LouverControl::$louverKey]['row'][$this->name];
    $walker  = $row[LouverControl::$louverKey]['walker'];

    $errors = $control->getErrorMessages();
    if (is_array($errors))
    {
      $inner = [];
      foreach ($errors as $error)
      {
        $inner[] = ['tag'  => 'span',
                    'attr' => ['class' => $walker->getClasses('error-message')],
                    'text' => $error];
      }

      $struct = [['html' => $control->htmlControl($walker)],
                 ['tag'   => 'div',
                  'attr'  => ['class' => $walker->getClasses('error-messages')],
                  'inner' => $inner]];

      $html = Html::htmlNested($struct);
    }
    else
    {
      $html = $control->htmlControl($walker);
    }

    return $html;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
