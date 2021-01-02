import {OverviewTable} from '../../Table/OverviewTable';
import {TextTableColumn} from './TextTableColumn';

/**
 * Table column with cells with checkboxes.
 */
export class CheckboxesTableColumn extends TextTableColumn
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public extractForFilter(tableCell: HTMLTableCellElement): string
  {
    const id = $(tableCell).find('input[type="checkbox"]:checked').prop('id');

    return OverviewTable.toLowerCaseNoDiacritics(($('label[for=' + $.escapeSelector(id) + ']').text()));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public getSortKey(tableCell:HTMLTableCellElement): string
  {
    const id = $(tableCell).find('input[type="checkbox"]:checked').prop('id');

    return OverviewTable.toLowerCaseNoDiacritics(($('label[for=' + $.escapeSelector(id) + ']').text()));
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
OverviewTable.registerTableColumn('control-checkboxes', CheckboxesTableColumn);

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: cdb255eb04b229414e121122ba446e04
