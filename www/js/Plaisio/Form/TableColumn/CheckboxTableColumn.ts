import {OverviewTable} from 'Plaisio/Table/OverviewTable';
import {TextTableColumn} from 'Plaisio/Table/TableColumn/TextTableColumn';

/**
 * Table column with cells with a checkbox.
 */
export class CheckboxTableColumn extends TextTableColumn
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public extractForFilter(tableCell: HTMLTableCellElement): string
  {
    if ($(tableCell).find('input:checkbox').prop('checked'))
    {
      return '1';
    }

    return '0';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public getSortKey(tableCell: HTMLTableCellElement): number
  {
    if ($(tableCell).find('input:checkbox').prop('checked'))
    {
      return 1;
    }

    return 0;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
OverviewTable.registerTableColumn('control-checkbox', CheckboxTableColumn);

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: fd86bba910b84f0830e0a69cdeaab07b
