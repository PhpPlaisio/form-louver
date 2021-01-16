import {OverviewTable} from '../../Table/OverviewTable';
import {TextTableColumn} from './TextTableColumn';

/**
 * Table column with cells with select boxes.
 */
export class SelectTableColumn extends TextTableColumn
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public extractForFilter(tableCell: HTMLTableCellElement): string
  {
    const text = $(tableCell).find('select option:selected').text();

    return OverviewTable.toLowerCaseNoDiacritics(text);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public getSortKey(tableCell: HTMLTableCellElement): string
  {
    const text = $(tableCell).find('select option:selected').text();

    return OverviewTable.toLowerCaseNoDiacritics(text);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
OverviewTable.registerTableColumn('control-select', SelectTableColumn);

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: 48836a885f0c2b2ca3ccf30cde486566
