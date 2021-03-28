<?php
declare(strict_types=1);

namespace Plaisio\Form\Table;

use Plaisio\Form\Control\LouverControl;
use Plaisio\Form\Control\SlatControl;
use Plaisio\Helper\Html;
use Plaisio\Helper\RenderWalker;
use Plaisio\Table\TableColumn\UniTableColumn;

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
    $slatJoint = $row[LouverControl::$louverKey]['slat'];
    $errors    = $slatJoint->getErrorMessages();
    if ($errors===null)
    {
      $inner = null;
    }
    else
    {
      $errorAttributes = ['class' => $walker->getClasses('slat-error-message')];

      $inner = Html::generateTag('div', ['class' => $walker->getClasses('slat-error-messages')]);
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
  /**
   * @inheritdoc
   */
  public function getHtmlColumnFilter(RenderWalker $walker): string
  {
    return Html::generateElement('td', ['class' => $walker->getClasses(['filter', 'filter-slat-error'])]);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
