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

    const $id = Cast.toManString($table.attr('data-louver-id'));
    $('#' + $.escapeSelector($id)).on('click', function ()
    {
      that.addLouver();
    });

    if ($table.find('tbody > tr').length==0)
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
    Kernel.onBeefyHtmlAdded(function (event: TriggeredEvent, $html: JQuery)
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
    $row.find('input').each(function (index: number, input: HTMLElement)
    {
      const $input = $(input);
      const name   = Cast.toOptString($input.attr('name'));
      if (name !== null)
      {
        $input.attr('name', slatName + '[' + that.newRowIndex + ']' + name.substring(slatName.length + 3));
      }
    });

    this.$table.prepend($row);
    Kernel.triggerBeefyHtmlAdded($row);

    const table = OverviewTable.getOverviewTable(this.$table);
    if (table)
    {
      table.applyZebraTheme();
    }

    this.newRowIndex--;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

// Plaisio\Console\TypeScript\Helper\MarkHelper::md5: cef96e7427e4ff64fd2ecc572bbe8bdc
