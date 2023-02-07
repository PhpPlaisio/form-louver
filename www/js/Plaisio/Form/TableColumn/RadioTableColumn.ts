import {TextTableColumn} from 'Plaisio/Form/TableColumn/TextTableColumn';
import {OverviewTable} from 'Plaisio/Table/OverviewTable';

/**
 * Table column with cells with a radio button.
 */
export class RadioTableColumn extends TextTableColumn
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public extractForFilter(tableCell: HTMLTableCellElement): string
  {
    if ($(tableCell).find('input:radio').prop('checked'))
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
    if ($(tableCell).find('input:radio').prop('checked'))
    {
      return '1';
    }

    return '0';
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
OverviewTable.registerTableColumn('control-radio', RadioTableColumn);

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: 94fce282a6a3b89c7182e7199f750a20
// Plaisio\Console\TypeScript\Helper\MarkHelper::md5: 344ff6f08644d4ee30566edb22c163d4
