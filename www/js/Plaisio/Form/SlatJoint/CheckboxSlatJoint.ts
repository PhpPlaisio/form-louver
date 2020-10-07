/**
 * Class for table columns with checkboxes.
 */
export class CheckboxSlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The master checkbox for checking or unchecking all checkboxes.
   */
  private $master: JQuery;

  /**
   * The 0-indexed column number.
   */
  private index: number;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param id The ID of the master checkbox.
   */
  private constructor(id: string)
  {
    this.$master = $('#' + $.escapeSelector(id));
    this.index   = this.deriveColumn(id);

    this.installEventHandlers();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Checks or unchecks all checkboxes in the column with header given by an ID.
   *
   * @param id The ID of the master checkbox.
   */
  public static addMasterCheckbox(id: string)
  {
    new CheckboxSlatJoint(id);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the 0-indexed column number of the check and uncheck all checkbox.
   *
   * @param id The ID of the master checkbox.
   */
  private deriveColumn(id: string): number
  {
    const $th = this.$master.closest('th');

    return $th.parent().children().index($th);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Installs the event handlers for the checkbox for checking or unchecking all checkboxes and all checkboxes in the
   * column.
   */
  private installEventHandlers(): void
  {
    const that = this;

    this.$master.on('change', function ()
    {
      that.toggleMaster();
    });

    const rows = this.$master.closest('table').find('tbody').first().children('tr').get();
    for (const row of rows)
    {
      if (row.style.display === '')
      {
        $(row).children().eq(this.index).find('input:checkbox').on('change', function ()
        {
          that.toggleSlave();
        });
      }
    }

    this.toggleSlave();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Checks or unchecks all slave checkboxes.
   */
  private toggleMaster(): void
  {
    const checked = this.$master.prop('checked');

    const rows = this.$master.closest('table').find('tbody').first().children('tr').get();
    for (const row of rows)
    {
      if (row.style.display === '')
      {
        const current = $(row).children().eq(this.index).find('input:checkbox').prop('checked');
        if (current !== checked)
        {
          $(row).children().eq(this.index).find('input:checkbox').prop('checked', checked).trigger('change');
        }
      }
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Checks or unchecks all slave checkboxes.
   */
  private toggleSlave(): void
  {
    let count0 = 0;
    let count1 = 0;

    const rows = this.$master.closest('table').find('tbody').first().children('tr').get();
    for (const row of rows)
    {
      const checked = $(row).children().eq(this.index).find('input:checkbox').prop('checked');
      if (checked)
      {
        count1++;
      }
      else
      {
        count0++;
      }
    }

    if ((count0 === 0 && count1 > 0) || (count0 > 0 && count1 === 0))
    {
      this.$master.removeClass('master-checkbox-mixed');
    }
    else
    {
      this.$master.addClass('master-checkbox-mixed');
    }

    this.$master.prop('checked', (count1 > 0));
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
