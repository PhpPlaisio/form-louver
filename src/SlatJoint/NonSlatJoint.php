<?php
declare(strict_types=1);

namespace Plaisio\Form\SlatJoint;

use Plaisio\Table\TableColumn\NonTableColumn;

/**
 * Abstract parent class for slat joints that will appear in the generated overview table.
 */
abstract class NonSlatJoint extends NonTableColumn implements SlatJoint
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The name of this slat joint.
   *
   * @var string
   */
  private string $name;

  //--------------------------------------------------------------------------------------------------------------------

  /**
   * Object constructor.
   *
   * @param string $name The name of this slat joint.
   */
  public function __construct(string $name)
  {
    parent::__construct();

    $this->name = $name;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public function getName(): string
  {
    return $this->name;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
