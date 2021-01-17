import {OverviewTable} from "../../Table/OverviewTable";
import {TextTableColumn} from "../../Table/TableColumn/TextTableColumn";

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

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: 2bcf2c8129c44faf655bff0a0b6656e4
