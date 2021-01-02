<?php
declare(strict_types=1);

namespace Plaisio\Form\Table;

use Plaisio\Form\Control\LouverFieldSet;
use Plaisio\Form\Control\SlatControl;
use Plaisio\Helper\Html;
use Plaisio\Table\TableColumn\UniTableColumn;
use Plaisio\Table\Walker\RenderWalker;

/**
 * Table column for error messages at slat (i.e. row) level.
 */
class ErrorTableColumn extends UniTableColumn
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   */
  public function __construct()
  {
    parent::__construct('error', null);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getHtmlCell(RenderWalker $walker, array $row): string
  {
    /** @var SlatControl $slatJoint */
    $slatJoint        = $row[LouverFieldSet::$louverKey]['slat'];
    $errorAttributes  = ['class' => $walker->getClasses('error')];
    $errorsAttributes = ['class' => $walker->getClasses('errors')];

    $errors = $slatJoint->getErrorMessages();
    if ($errors===null)
    {
      $inner = null;
    }
    else
    {
      $inner = Html::generateTag('div', $errorsAttributes);
      foreach ($errors as $error)
      {
        $inner .= Html::generateTag('span', $errorAttributes);
        $inner .= Html::txt2Html($error);
        $inner .= '</span>';
      }
      $inner .= '</div>';
    }

    return Html::generateElement('td', ['class' => $walker->getClasses('slat-error')], $inner, true);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
