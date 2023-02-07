import {TextTableColumn} from 'Plaisio/Form/TableColumn/TextTableColumn';
import {Cast} from 'Plaisio/Helper/Cast';
import {OverviewTable} from 'Plaisio/Table/OverviewTable';

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

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: d82c1381b1e76e1ab0e88b6a25e2cd63
// Plaisio\Console\TypeScript\Helper\MarkHelper::md5: a061038275aa6cbad6c4d5d483a8fd65
