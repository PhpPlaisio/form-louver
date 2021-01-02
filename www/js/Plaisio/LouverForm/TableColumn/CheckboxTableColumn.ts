import {OverviewTable} from '../../Table/OverviewTable';
import {TextTableColumn} from './TextTableColumn';

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
  public getSortKey(tableCell: HTMLTableCellElement): string
  {
    if ($(tableCell).find('input:checkbox').prop('checked'))
    {
      return '1';
    }

    return '0';
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
OverviewTable.registerTableColumn('control-checkbox', CheckboxTableColumn);

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: 6c6ef9e3e4e014b505733ef94cc1fb2d
