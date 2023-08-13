import * as $ from 'jquery';
import {Cast} from 'Plaisio/Helper/Cast';
import {Kernel} from 'Plaisio/Kernel/Kernel';
import {OverviewTable} from 'Plaisio/Table/OverviewTable';
import TriggeredEvent = JQuery.TriggeredEvent;

export class LouverForm
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The index of the next new row added to the lover form.
   */
  private newRowIndex: number = -1;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param $table The jQuery object of the table.
   */
  public constructor(private $table: JQuery)
  {
    const that = this;

    const $id = Cast.toManString($table.attr('data-louver-adder-id'));
    $('#' + $.escapeSelector($id)).on('click', function ()
    {
      that.addLouver();
    });

    if ($table.find('tbody > tr').length == 0)
    {
      this.addLouver();
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Registers table as a Louver fieldset.
   */
  public static init(): void
  {
    Kernel.onBeefyHtmlAdded(function (event: TriggeredEvent, $html: JQuery): void
    {
      $html.find('table[data-louver=louver]').each(function ()
      {
        const $table = $(this);
        if (!$table.hasClass('is-louver-registered'))
        {
          new LouverForm($table);
          $table.addClass('is-louver-registered');
        }
      });
    });
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Adds a new louver to this louver table.
   */
  private addLouver(): void
  {
    const that     = this;
    const slatName = Cast.toManString(this.$table.attr('data-louver-slat-name'));
    const $row     = $(Cast.toManString(this.$table.attr('data-louver-template')));
    $row.find('input,select,textarea').each(function (index: number, input: HTMLElement): void
    {
      const $input = $(input);
      const name   = Cast.toOptString($input.attr('name'));
      if (name !== null)
      {
        // Replace the row index (i.e. 0) from the template with the actual row index.
        $input.attr('name', slatName + '[' + that.newRowIndex + ']' + name.substring((slatName + '[0]').length));
      }
    });

    const moduleClass = Cast.toOptString(this.$table.attr('data-overview-table-module-class'));
    if (moduleClass !== null)
    {
      $row.addClass(moduleClass + '-is-new-louver-row');
      $row.children('.' + moduleClass + '-cell').addClass(moduleClass + '-is-new-louver-cell');
    }

    const newSlatPosition = Cast.toManString(this.$table.attr('data-louver-new-slat-position'));
    switch (newSlatPosition)
    {
      case 'top':
        this.$table.prepend($row);
        Kernel.triggerBeefyHtmlAdded($row);
        break;

      case 'bottom':
        this.$table.append($row);
        Kernel.triggerBeefyHtmlAdded($row);
        break;

      default:
        console.debug(`Unknown new slat position: ${newSlatPosition}`);
    }

    const table = OverviewTable.getOverviewTable(this.$table);
    if (table)
    {
      table.applyZebraTheme();
    }

    this.newRowIndex--;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
// Plaisio\Console\TypeScript\Helper\MarkHelper::md5: 53bf3bead4c9b69ae8eed2f75948ff6a
