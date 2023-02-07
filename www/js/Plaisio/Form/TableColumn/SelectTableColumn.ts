import {TextTableColumn} from 'Plaisio/Form/TableColumn/TextTableColumn';
import {OverviewTable} from 'Plaisio/Table/OverviewTable';

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

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: 70af211cb724931e345aeb308ecb7abc
// Plaisio\Console\TypeScript\Helper\MarkHelper::md5: a439034d9d6a40000cbe2d384eb56c50
