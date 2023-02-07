import {TextTableColumn} from 'Plaisio/Form/TableColumn/TextTableColumn';
import {OverviewTable} from 'Plaisio/Table/OverviewTable';

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
  public getSortKey(tableCell: HTMLTableCellElement): string
  {
    const id = $(tableCell).find('input[type="checkbox"]:checked').prop('id');

    return OverviewTable.toLowerCaseNoDiacritics(($('label[for=' + $.escapeSelector(id) + ']').text()));
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
OverviewTable.registerTableColumn('control-checkboxes', CheckboxesTableColumn);

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: 948634e5d27557769510454fe1f71d14
// Plaisio\Console\TypeScript\Helper\MarkHelper::md5: bc1b6c3900e3aa8b25625f3b44fb90bb
