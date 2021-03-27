/**
 * Class for table columns with checkboxes.
 */
import {OverviewTable} from '../../Table/OverviewTable';

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

    this.installObservers();

    this.setMasterStatus();
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
   * Installs the observer for the checkbox for checking or unchecking all checkboxes and all checkboxes in the
   * column.
   */
  private installObservers(): void
  {
    this.installSlavesObserver();
    this.installMasterStatusObservers();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Installs the slave observer.
   */
  private installSlavesObserver(): void
  {
    const that = this;

    this.$master.on('input', function ()
    {
      that.toggleSlaves();
    });
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Installs the master status observer.
   */
  private installMasterStatusObservers(): void
  {
    const that = this;

    const rows = this.$master.closest('table').find('tbody').first().children('tr').get();
    for (const row of rows)
    {
      $(row).children().eq(this.index).find('input:checkbox').on('input', function ()
      {
        that.setMasterStatus();
      });
    }

    this.$master.closest('table').on(OverviewTable.FILTERING_ENDED, function()
    {
      that.setMasterStatus();
    })
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Sets the status of the master checkbox.
   */
  private setMasterStatus(): void
  {
    let count0 = 0;
    let count1 = 0;

    const rows = this.$master.closest('table').find('tbody').first().children('tr').get();
    for (const row of rows)
    {
      const $checkbox = $(row).children().eq(this.index).find('input:checkbox');
      if (!$checkbox.prop('disabled'))
      {
        const checked = $checkbox.prop('checked');
        if (checked)
        {
          count1++;
        }
        else
        {
          count0++;
        }
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
  /**
   * Checks or unchecks all slave checkboxes.
   */
  private toggleSlaves(): void
  {
    const checked = this.$master.prop('checked');

    const rows = this.$master.closest('table').find('tbody').first().children('tr').get();
    for (const row of rows)
    {
      if (row.style.display === '')
      {
        const $checkbox = $(row).children().eq(this.index).find('input:checkbox');
        if (!$checkbox.prop('disabled'))
        {
          const current = $checkbox.prop('checked');
          if (current !== checked)
          {
            $(row).children()
                  .eq(this.index)
                  .find('input:checkbox')
                  .prop('checked', checked)
                  .trigger('input');
          }
        }
      }
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: fe31dd3174838375b34483162e5833e0
