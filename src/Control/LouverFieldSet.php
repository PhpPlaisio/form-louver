<?php
declare(strict_types=1);

namespace Plaisio\Form\Control;

use Plaisio\Kernel\Nub;

/**
 * Field set for louver controls.
 */
class LouverFieldSet extends FieldSet
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The class used in the generated HTML code.
   *
   * @var string|null
   */
  public static $class = 'louver';

  /**
   * The complex form control holding the buttons of this fieldset.
   *
   * @var ComplexControl|null
   */
  private $buttonGroupControl = null;

  /**
   * The louver control of this fieldset.
   *
   * @var LouverControl
   */
  private $louverControl;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param string|null $name The (local) name of this form control.
   */
  public function __construct(?string $name = null)
  {
    parent::__construct($name);

    $this->louverControl = new LouverControl();
    $this->addFormControl($this->louverControl);

    $this->addClass('louver');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Adds a submit button to this fieldset.
   *
   * @param int|string $wrdId Depending on the type:
   *                          <ul>
   *                          <li>int: The ID of the word of the button text.
   *                          <li>string: The text of the button.
   *                          </ul>
   * @param string     $name  The name of the submit button.
   *
   * @return PushControl
   */
  public function addSubmitButton($wrdId, string $name = 'submit'): PushControl
  {
    if ($this->buttonGroupControl===null)
    {
      $this->buttonGroupControl = new ComplexControl();
    }

    $input = new SubmitControl($name);
    $input->setValue((is_int($wrdId)) ? Nub::$nub->babel->getWord($wrdId) : $wrdId);
    $this->buttonGroupControl->addFormControl($input);

    return $input;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function getHtml(): string
  {
    $html = $this->prefix;
    $html .= $this->getHtmlStartTag();
    $html .= $this->louverControl->getHtml();
    $html .= $this->getHtmlEndTag();
    $html .= $this->postfix;

    return $html;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the louver control of this louver fieldset.
   *
   * @return LouverControl
   */
  public function getLouverControl(): LouverControl
  {
    return $this->louverControl;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public function prepare(string $parentSubmitName): void
  {
    if ($this->buttonGroupControl!==null)
    {
      $this->louverControl->setFooterControl($this->buttonGroupControl);
    }

    parent::prepare($parentSubmitName);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
