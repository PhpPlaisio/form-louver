import {TextTableColumn} from 'Plaisio/Form/TableColumn/TextTableColumn';
import {OverviewTable} from 'Plaisio/Table/OverviewTable';

/**
 * Table column with HTML elements.
 */
export class HtmlTableColumn extends TextTableColumn
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public extractForFilter(tableCell: HTMLTableCellElement): string
  {
    return OverviewTable.toLowerCaseNoDiacritics($(tableCell).children().text());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public getSortKey(tableCell: HTMLTableCellElement): string
  {
    return OverviewTable.toLowerCaseNoDiacritics($(tableCell).children().text());
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
OverviewTable.registerTableColumn('control-html', HtmlTableColumn);

// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: 84178dc8a8eabc6654b6d1f312e50c80
// Plaisio\Console\TypeScript\Helper\MarkHelper::md5: 667b04a60d786f821b2031c267be631a
