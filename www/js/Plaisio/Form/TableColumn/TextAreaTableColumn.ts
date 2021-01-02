import {Cast} from '../../Helper/Cast';
import {OverviewTable} from '../../Table/OverviewTable';
import {TextTableColumn} from './TextTableColumn';

/**
 * Table column with cells with a text area.
 */
export class TextAreaTableColumn extends TextTableColumn
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public extractForFilter(tableCell: HTMLTableCellElement): string
  {
    return OverviewTable.toLowerCaseNoDiacritics(Cast.toManString($(tableCell).find('textarea').val(), ''));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public getSortKey(tableCell: HTMLTableCellElement): string
  {
    return OverviewTable.toLowerCaseNoDiacritics(Cast.toManString($(tableCell).find('textarea').val(), ''));
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
OverviewTable.registerTableColumn('control-text-area', TextAreaTableColumn);

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: 860007b7b28e44de7d695ee9daad2353
