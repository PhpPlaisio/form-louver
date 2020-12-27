<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

use Plaisio\Helper\Html;

/**
 * A pseudo form control for generating table rows in a Louver control.
 */
class SlatControl extends ComplexControl
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @var Control|null
   */
  private ?Control $deleteControl = null;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getHtml(): string
  {
    $childAttributes  = ['class' => LouverFieldSet::$class];
    $errorAttributes  = ['class' => [LouverFieldSet::$class, LouverFieldSet::$class.'-error']];
    $errorsAttributes = ['class' => [LouverFieldSet::$class, LouverFieldSet::$class.'-errors']];

    // Create start tag of table row.
    $ret = Html::generateTag('tr', $this->attributes);

    // Create table cells.
    foreach ($this->controls as $control)
    {
      $errors = $control->getErrorMessages();

      if (!$control->isHidden())
      {
        if (is_a($control, TableColumnControl::class))
        {
          $ret .= $control->getHtml();
        }
        else
        {
          $ret .= Html::generateTag('td', $childAttributes);
          $ret .= $control->getHtml();
          if (!empty($errors))
          {
            $ret .= Html::generateTag('div', $errorsAttributes);
            foreach ($errors as $error)
            {
              $ret .= Html::generateTag('span', $errorAttributes);
              $ret .= Html::txt2Html($error);
              $ret .= '</span>';
            }
            $ret .= '</div>';
          }
          $ret .= '</td>';
        }
      }
    }

    // Create table cell with error message, if any.
    $ret .= $this->getHtmlErrorCell();

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
   * @inheritdoc
   */
  public function validateBase(array &$invalidFormControls): bool
  {
    $valid = true;

    if ($this->deleteControl!==null)
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
  protected function getHtmlErrorCell(): string
  {
    $ret = '';

    if (!$this->isValid())
    {
      $errorAttributes  = ['class' => [LouverFieldSet::$class, LouverFieldSet::$class.'-error']];

      $errors = $this->getErrorMessages();

      $ret .= '<td class="overview-table overview-table-error">';
      if (!empty($errors))
      {
        foreach ($errors as $error)
        {
          $ret .= Html::generateTag('span', $errorAttributes);
          $ret .= Html::txt2Html($error);
          $ret .= '</span>';
        }
      }
      $ret .= '</td>';
    }
    else
    {
      $ret .= '<td class="overview-table overview-table-error"></td>';
    }

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
