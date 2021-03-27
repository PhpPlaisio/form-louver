
import {Cast} from '../../Helper/Cast';
import {OverviewTable} from '../../Table/OverviewTable';
import {TextTableColumn as BaseTextTableColumn} from '../../Table/TableColumn/TextTableColumn';

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

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: f9475fb020a64790aa5b8fb343cdcdc1
