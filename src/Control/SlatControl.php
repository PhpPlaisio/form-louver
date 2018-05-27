<?php

namespace SetBased\Abc\Form\Control;

use SetBased\Abc\Helper\Html;

/**
 * A pseudo form control for generating table rows in a Louver control.
 */
class SlatControl extends ComplexControl
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @var Control;
   */
  private $deleteControl;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function generate()
  {
    // Create start tag of table row.
    $ret = Html::generateTag('tr', $this->attributes);

    // Create table cells.
    foreach ($this->controls as $control)
    {
      $ret .= $control->getHtmlTableCell();
    }

    // Create table cell with error message, if any.
    $ret .= $this->generateErrorCell();

    // Create end tag of table row.
    $ret .= '</tr>';

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  public function setDeleteControl($control)
  {
    $this->deleteControl = $control;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Executes a validators on the child form controls of this form complex control. If  and only if all child form
   * controls are valid the validators of this complex control are executed.
   *
   * @param array $invalidFormControls A nested array of invalid form controls.
   *
   * @return bool True if and only if all form controls are valid.
   */
  public function validateBase(&$invalidFormControls)
  {
    $valid = true;

    if ($this->deleteControl)
    {
      if (!$this->deleteControl->validateBase($invalidFormControls))
      {
        $this->invalidControls[] = $this->deleteControl;
        $valid                   = false;
      }
      else
      {
        if ($this->deleteControl->getSubmittedValue())
        {
          return $valid;
        }
      }
    }

    // First, validate all child form controls.
    foreach ($this->controls as $control)
    {
      if ($control!==$this->deleteControl)
      {
        if (!$control->validateBase($invalidFormControls))
        {
          $this->invalidControls[] = $control;
          $valid                   = false;
        }
      }
    }

    if ($valid)
    {
      // All the child form controls are valid. Validate this complex form control.
      foreach ($this->validators as $validator)
      {
        $valid = $validator->validate($this);
        if ($valid!==true)
        {
          $invalidFormControls[] = $this;
          break;
        }
      }
    }

    return $valid;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns a table cell with the errors messages of all form controls at this row.
   *
   * @return string
   */
  protected function generateErrorCell()
  {
    $ret = '';

    if (!$this->isValid())
    {
      $error_messages = $this->getErrorMessages(true);

      $ret .= '<td class="error">';
      if (!empty($error_messages))
      {
        foreach ($error_messages as $message)
        {
          $ret .= Html::txt2Html($message);
          $ret .= '<br/>';
        }
      }
      $ret .= '</td>';
    }
    else
    {
      $ret .= '<td class="error"></td>';
    }

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
