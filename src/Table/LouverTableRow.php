<?php
declare(strict_types=1);

namespace Plaisio\Form\Table;

use Plaisio\Form\Control\LouverControl;
use Plaisio\Helper\RenderWalker;
use Plaisio\Table\TableRow\TableRow;

/**
 * Helper class for generating zebra themed table rows with attributes from the slat control.
 */
class LouverTableRow implements TableRow
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getRowAttributes(RenderWalker $walker, int $index, array $row): array
  {
    $attributes          = $row[LouverControl::$louverKey]['attr'];
    $attributes['class'] = array_merge($attributes['class'] ?? [],
                                       $walker->getClasses('row', ($index % 2===0) ? 'is-even' : 'is-odd'));

    return $attributes;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
