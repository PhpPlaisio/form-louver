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
  public function htmlCell(RenderWalker $walker, array $row): string
  {
    /** @var SlatControl $slatJoint */
    $slatJoint = $row[LouverControl::$louverKey]['slat'];
    $errors    = $slatJoint->getErrorMessages();
    if ($errors===null)
    {
      $list = null;
    }
    else
    {
      $items = [];
      foreach ($errors as $error)
      {
        $items[] = ['tag'  => 'li',
                    'attr' => ['class' => $walker->getClasses('slat-error-message')],
                    'text' => $error];
      }
      $list = ['tag'   => 'ul',
               'attr'  => ['class' => $walker->getClasses('slat-error-messages')],
               'inner' => $items];
    }

    $struct = ['tag'   => 'td',
               'attr'  => ['class' => $walker->getClasses('slat-error')],
               'inner' => $list];

    return Html::htmlNested($struct);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function htmlColumnFilter(RenderWalker $walker): string
  {
    $struct = ['tag'  => 'td',
               'attr' => ['class' => $walker->getClasses(['filter', 'filter-slat-error'])],
               'html' => null];

    return Html::htmlNested($struct);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
