import {Cast} from 'Plaisio/Helper/Cast';
import {OverviewTable} from 'Plaisio/Table/OverviewTable';
import {TextTableColumn as BaseTextTableColumn} from 'Plaisio/Table/TableColumn/TextTableColumn';

/**
 * Table column with cell with input:text form control.
 */
export class TextTableColumn extends BaseTextTableColumn
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public extractForFilter(tableCell: HTMLTableCellElement): string
  {
    return OverviewTable.toLowerCaseNoDiacritics(Cast.toManString($(tableCell).find('input').val(), ''));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public getSortKey(tableCell: HTMLTableCellElement): string
  {
    return OverviewTable.toLowerCaseNoDiacritics(Cast.toManString($(tableCell).find('input').val(), ''));
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
OverviewTable.registerTableColumn('control-button', TextTableColumn);
OverviewTable.registerTableColumn('control-date', TextTableColumn);
OverviewTable.registerTableColumn('control-html', TextTableColumn);
OverviewTable.registerTableColumn('control-integer', TextTableColumn);
OverviewTable.registerTableColumn('control-number', TextTableColumn);
OverviewTable.registerTableColumn('control-submit', TextTableColumn);
OverviewTable.registerTableColumn('control-tel', TextTableColumn);
OverviewTable.registerTableColumn('control-text', TextTableColumn);
OverviewTable.registerTableColumn('control-url', TextTableColumn);
OverviewTable.registerTableColumn('control-weight', TextTableColumn);

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: 4aa03792b25e33b1422b030ad2b31def
// Plaisio\Console\TypeScript\Helper\MarkHelper::md5: a6a6ed13a5bfc730f2bf4741892a849a
